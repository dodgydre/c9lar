<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Transaction;
use App\Payment;

class TransactionController extends Controller
{
    /**
     *  Add a new Charge to the Transactions table for a given patient
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function addCharge(Request $request)
    {
      $this->validate($request, array(
        'date_from' => 'required',
        'units' => 'required|numeric',
        'amount' => 'required|numeric',
        'total' => 'required|numeric',
        'attending_provider' => 'required',
        'procedure_code'    => 'required|max:8',
        'procedure_description' => 'required'
      ));

      $patient = Patient::find($request->patient_id);
      $procedure = Procedure::where('code', '=', $request->procedure_code)->first();

      $charge = new Transaction;
      $charge->patient_id = $request->patient_id;
      $charge->chart_number = $patient->chart_number;
      $charge->date_from = Carbon::createFromFormat('d/m/Y', $request->date_from);
      $charge->attending_provider = $request->attending_provider;
      $charge->procedure_code = $request->procedure_code;
      $charge->procedure_description = $procedure->description;
      $charge->transaction_type = $procedure->type;
      $charge->units = $request->units;
      $charge->amount = $request->amount;
      $charge->total = $request->total;
      $charge->unapplied_amount = $request->total;

      $charge->save();
      $patient->remaining_balance += $charge->total;

      // Is the procedure taxable?  If so add an extra transaction
      if($procedure->taxable == 1) {
        $tax_procedure = Procedure::where('code', '=', 'TAX')->first();

        $tax = new Transaction;
        $tax_total = ($request->total) * ($tax_procedure->amount)/100;
        $tax->patient_id = $request->patient_id;
        $tax->chart_number = $patient->chart_number;
        $tax->date_from = Carbon::createFromFormat('d/m/Y', $request->date_from);
        $tax->attending_provider = $request->attending_provider;
        $tax->procedure_code = $tax_procedure->code;
        $tax->procedure_description = $tax_procedure->description;
        $tax->transaction_type = $tax_procedure->type;
        $tax->total = $tax_total;
        $tax->unapplied_amount = $tax_total;

        $tax->save();
        $patient->remaining_balance += $tax->total;
      }

      $patient->save();

      return redirect()->route('patients.show', [$patient->id]);
    }

    /**
     *  Add a new Payment to the Transactions table for a given patient
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function addPayment(Request $request)
    {
      $this->validate($request, array(
        'date_from' => 'required',
        'total' => 'required|numeric',
        'attending_provider' => 'required',
        'payment_code'    => 'required|max:15',
        'payment_description' => 'required',
        'who_paid' => 'required'
      ));

      $patient = Patient::find($request->patient_id);
      $procedure = Procedure::where('code', '=', $request->payment_code)->first();

      $payment = new Transaction;
      $payment->patient_id = $request->patient_id;
      $payment->chart_number = $patient->chart_number;
      $payment->date_from =  Carbon::createFromFormat('d/m/Y', $request->date_from);
      $payment->attending_provider = $request->attending_provider;
      $payment->procedure_code = $request->payment_code;
      $payment->procedure_description = $procedure->description;
      $payment->who_paid = $request->who_paid;
      $payment->transaction_type = $procedure->type;
      $payment->units = 1;
      $payment->total = -($request->total);
      $payment->unapplied_amount = -($request->total);

      // Also update the patient page to keep track of remaining balance, last payment, and date of last payment
      $patient->remaining_balance += $payment->total;
      $patient->last_pmt = $payment->total;
      $patient->date_of_last_pmt = Carbon::createFromFormat('d/m/Y', $request->date_from);

      $payment->save();
      $patient->save();

      return redirect()->route('patients.show', [$patient->id]);
    }

    /**
     * Apply Payment
     * /patients/{id}/apply/{transaction}/from/{payor}
     * @params
     *      id => patient_id
     *      transaction => transaction_id
     *      payor => who_paid
     */
     public function applyPaymentForm($id, $transaction_id, $payor)
     {
       $patient = Patient::find($id);
       $thisTransaction = Transaction::find($transaction_id);

       //$appliedTo = $thisTransaction->payments();
       //echo $appliedTo;
       // TODO: What to do if $payor is not G, 1, 2, 3?  What to do if 1,2 or 3 is empty?
       if ($payor == 'G') $who_paid = $patient->last_name . ', ' . $patient->first_name . ' - Guarantor';
       elseif ($payor == 1) $who_paid = $patient->insurance1->name . ' - Primary';
       elseif ($payor == 2) $who_paid = $patient->insurance2->name . ' - Secondary';
       elseif ($payor == 3) $who_paid = $patient->insurance3->name . ' - Third';

       return view('patients.apply')
                ->withPatient($patient)
                ->with('thisTransaction', $thisTransaction)
                ->with('who_paid', $who_paid)
                ->with('payor', $payor);
     }

     public function applyPayment(Request $request)
     {
       echo "Starting <br />";
       $affectedTransactions = array();
       //$patient = Patient::find($request->id);
       switch ($request->payor) {
        case 'G':
          $payor_col = 'g_amount_paid';
          break;
        case '1':
          $payor_col = 'i1_amount_paid';
          break;
        case '2':
          $payor_col = 'i2_amount_paid';
          break;
        case '3':
          $payor_col = 'i3_amount_paid';
          break;
       }
       echo $payor_col . "<br />";
       $payTransaction = Transaction::find($request->transaction_id);
       array_push($affectedTransactions, (int)$request->transaction_id);

       echo 'Pay Reference: ' . $payTransaction->id . '<br />';
       foreach($request->toapply as $charge_id => $amount)
       {
         echo 'Charge Reference: ' . $charge_id . " - Amount: " . $amount . "<br />";

         $exists = DB::table('payments')->where('charge_ref', '=', $charge_id)->where('payment_ref', $payTransaction->id)->get();
         print_r($exists);

         if($amount != 0)
         {
           array_push($affectedTransactions, $charge_id);
           if(isset($exists)){
             $payTransaction->charges()->detach($charge_id);
           }
           $amount = - abs($amount);
           $payTransaction->charges()->attach($charge_id, ['amount' => $amount, 'who_paid' => $request->payor]);

         }
      }
      $this->doApplyPayments($affectedTransactions);

      return redirect()->route('patients.show', [$request->patient_id]);
    }

    public function doApplyPayments($affectedTransactions) {
      foreach($affectedTransactions as $affectedTransaction) {
        $transaction = Transaction::find($affectedTransaction);
        echo "Transaction " . $transaction->id . " <br />";
        if($transaction->total > 0) {
          echo "Charge<br />";
          $unapplied = $transaction->total;
          $transaction->g_amount_paid = 0;
          $transaction->i1_amount_paid = 0;
          $transaction->i2_amount_paid = 0;
          $transaction->i3_amount_paid = 0;

          $payments = DB::table('payments')->where('charge_ref', '=', $transaction->id)->get();
          foreach($payments as $payment) {
            echo "Payment Ref: " . $payment->payment_ref . " - Amount $" . $payment->amount . " - paid by: " . $payment->who_paid . "<br />";
            if($payment->who_paid == 'G') {
              $transaction->g_amount_paid -= abs($payment->amount);
              echo "Transaction g_amount_paid = " . $transaction->g_amount_paid . "<br />";
            }
            elseif($payment->who_paid == 1) {
              $transaction->i1_amount_paid -= abs($payment->amount);
              echo "Transaction i1_amount_paid = " . $transaction->i1_amount_paid . "<br />";

            }
            elseif($payment->who_paid == 2) {
              $transaction->i2_amount_paid -= abs($payment->amount);
              echo "Transaction i2_amount_paid = " . $transaction->i2_amount_paid . "<br />";
            }
            elseif($payment->who_paid == 3) {
              $transaction->i3_amount_paid-= abs($payment->amount);
              echo "Transaction i3_amount_paid = " . $transaction->i3_amount_paid . "<br />";
            }
            $unapplied -= abs($payment->amount);
          }
          $transaction->unapplied_amount = $unapplied;
        }

        else {
          echo "Payment<br />";
          $unapplied = $transaction->total;

          $charges = DB::table('payments')->where('payment_ref', '=', $transaction->id)->get();
          foreach($charges as $charge) {
            echo "Charge Ref: " . $charge->payment_ref . " - Amount: $" . $charge->amount . " - paid by: " . $charge->who_paid . "<br />";
            $amount = abs($charge->amount);
            $unapplied += $amount;
          }
          $transaction->unapplied_amount = $unapplied;
        }
        $transaction->save();

      }

    }
    
    /**
      * Apply payments to the most recent outstanding transactions
      *
      **/
      public function applyPaymentsToMostRecent(Request $request)
      {
        $patient_id = $request->patient_id;
        $transaction_id = $request->transaction_id;

        // Create an array of transactions affected by this operation to sort out totals after
        $affectedTransactions = array();


        $patient = Patient::find($patient_id);
        // get the payment transaction collection:
        $payTransaction = Transaction::find($transaction_id);
        $availableTotal = $payTransaction->unapplied_amount;

        array_push($affectedTransactions, $payTransaction->id);

        switch($payTransaction->who_paid) {
          case 'G':
            $payor_col = 'g_amount_paid';
            break;
          case '1':
            $payor_col = 'i1_amount_paid';
            break;
          case '2':
            $payor_col = 'i2_amount_paid';
            break;
          case '3':
            $payor_col = 'i3_amount_paid';
            break;
        }

        echo "Patient ID: " . $patient->id . "<br/>";
        echo "Patient Name: " . $patient->first_name . " " . $patient->last_name . "<br />";
        echo "Who Paid: " . $payor_col . "<br />";
        echo "Available total: $" . $availableTotal . "<br />";

        // Get all of the patientTransactions
        $patientTransactions = Transaction::where('patient_id', '=', $patient_id)->orderBy('date_from', 'desc')->get();
        $patientCharges = $patient->charges;

        foreach($patientCharges as $patientCharge) {
          if($patientCharge->unapplied() > 0) {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $patientCharge->date_from . ' - Total: $' . $patientCharge->total . ' - Unapplied $' , $patientCharge->unapplied() . '<br />';

            // There is a lot of money left in the payment so pay the full amount to the charge
            if( $patientCharge->unapplied() <= abs($availableTotal) ) {
              $amountToApply = $patientCharge->unapplied();
              $availableTotal = $availableTotal + $patientCharge->unapplied();
              echo "Applying full amount - $" . $patientCharge->unapplied() . " - amount remaining in payment: $ " . $availableTotal . " <br><br>";

              // Apply the payment
              $exists = DB::table('payments')->where('charge_ref', '=', $patientCharge->id)->where('payment_ref', $payTransaction->id)->get();
              print_r($exists);

              if($amountToApply != 0)
              {
                array_push($affectedTransactions, $patientCharge->id);
                if(isset($exists)){
                  $payTransaction->charges()->detach($patientCharge->id);
                }
                $amount = - abs($amountToApply);
                $payTransaction->charges()->attach($patientCharge->id, ['amount' => $amount, 'who_paid' => $payTransaction->who_paid]);

              }
            }

            // There is nothing left in the payment so move along
            else if ($availableTotal == 0){
              echo "nothing left to apply <br />";
            }

            // There is a enough left in the payment to cover a portion of the charge
            else {
              $amountToApply = $availableTotal;
              $availableTotal = 0;

              echo "Applying a portion of the full - $" . $amountToApply . " Nothing remaining in available total - " . $availableTotal . "<br>";

              // Apply the payment
              $exists = DB::table('payments')->where('charge_ref', '=', $patientCharge->id)->where('payment_ref', $payTransaction->id)->get();
              print_r($exists);

              if($amountToApply != 0)
              {
                array_push($affectedTransactions, $patientCharge->id);
                if(isset($exists)){
                  $payTransaction->charges()->detach($patientCharge->id);
                }
                $amount = - abs($amountToApply);
                $payTransaction->charges()->attach($patientCharge->id, ['amount' => $amount, 'who_paid' => $payTransaction->who_paid]);

              }
            }
          }
        }
        $this->doApplyPayments($affectedTransactions);
        return redirect()->route('patients.show', [$patient_id]);




      }
}
