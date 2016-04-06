<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use Session;

use App\Http\Requests;
use App\Patient;
use App\Transaction;
use App\Insurer;
use App\Procedure;
use App\Payment;

class PatientController extends Controller
{
    // Set Auth Middleware for All but Patient Index.  Add admin only to delete
    public function __construct()
    {
      $this->middleware('auth');
      /*
      $this->middleware('auth', ['only'=>[
        'create',
        'delete',
        'store',
        'edit',
        'update',
        ]]);*/
        // also 'except' for views that don't go through the middleware.
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::orderBy('last_name', 'asc')->get();
        return view('patients.index')->withPatients($patients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Change validation requirements for phone, etc. check patterns?  only numeric?
        $this->validate($request, array(
          'first_name' => 'required|max:255',
          'last_name' => 'required|max:255',
          'middle_name' => 'max:255',
          'street1' => 'max:255',
          'street2' => 'max:255',
          'city'    => 'max:255',
          'province' => 'max:255',
          'postcode' => 'max:10',
          'country'=> 'max:25',
          'phone1' => 'max:255',
          'phone2' => 'max:255',
          'phone3' => 'max:255',
          'gender' => 'max:10',
          'email' => 'max:255'
        ));

        $newChartStart = strtoupper(substr($request->last_name, 0, 3) . substr($request->first_name, 0, 2));
        $charts = Patient::where('chart_number', 'LIKE', $newChartStart . '%')->get();
        $endNumber = (string)count($charts);  // include 000 as a chart number

        $newChart = $newChartStart . str_pad($endNumber, 3, "0", STR_PAD_LEFT);

        $patient = new Patient;

        $patient->chart_number = $newChart;
        $patient->first_name = $request->first_name;
        $patient->middle_name = $request->middle_name;
        $patient->last_name = $request->last_name;
        $patient->street1 = $request->street1;
        $patient->street2 = $request->street2;
        $patient->city = $request->city;
        $patient->province = $request->province;
        $patient->postcode = $request->postcode;
        $patient->country = $request->country;
        $patient->phone1 = $request->phone1;
        $patient->phone2 = $request->phone2;
        $patient->phone3 = $request->phone3;
        $patient->gender = $request->gender;
        $patient->dob = $request->dob;
        $patient->email = $request->email;

        $patient->save();

        Session::flash('success', 'The patient has been created');

        return redirect()->route('patients.index');
        //return redirect()->route('patients.show', $patient->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $patient = Patient::find($id);
      $procedures = Procedure::orderBy('code')->where('type', '=', 'A')->orWhere('type', '=', 'B')->orWhere('type', '=', 'H')->get();
      $payments = Procedure::orderBy('code')->where('type', '!=', 'A')->where('type', '!=', 'B')->where('type', '!=', 'H')->get();
      $insurers = Insurer::orderBy('code')->get();

      return view('patients.show')->withPatient($patient)->withProcedures($procedures)->withPayments($payments)->withInsurers($insurers);
    }


    public function showChartNum($chart_number)
    {
      $patient = Patient::where('chart_number', '=', $chart_number)->first();
      $procedures = Procedure::orderBy('code')->where('type', '=', 'A')->orWhere('type', '=', 'B')->orWhere('type', '=', 'H')->get();
      $payments = Procedure::orderBy('code')->where('type', '!=', 'A')->where('type', '!=', 'B')->where('type', '!=', 'H')->get();
      $insurers = Insurer::orderBy('code')->get();

      return view('patients.show')->withPatient($patient)->withProcedures($procedures)->withPayments($payments)->withInsurers($insurers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $patient = Patient::find($id);
      return view('patients.edit')->withPatient($patient);
    }
    public function editChartNum($chart_number)
    {
      $patient = Patient::where('chart_number', '=', $chart_number)->first();
      return view('patients.edit')->withPatient($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, array(
        /*'code' => 'required|max:8|unique:procedures,code',*/
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'middle_name' => 'max:255',
        'street1' => 'max:255',
        'street2' => 'max:255',
        'city'    => 'max:255',
        'province' => 'max:255',
        'postcode' => 'max:10',
        'country'=> 'max:25',
        'phone1' => 'max:255',
        'phone2' => 'max:255',
        'phone3' => 'max:255',
        'gender' => 'max:10',
        'email' => 'max:255'
      ));

      $patient = Patient::find($id);

      //$patient->chart_number = $newChart;
      $patient->first_name = $request->first_name;
      $patient->middle_name = $request->middle_name;
      $patient->last_name = $request->last_name;
      $patient->street1 = $request->street1;
      $patient->street2 = $request->street2;
      $patient->city = $request->city;
      $patient->province = $request->province;
      $patient->postcode = $request->postcode;
      $patient->country = $request->country;
      $patient->phone1 = $request->phone1;
      $patient->phone2 = $request->phone2;
      $patient->phone3 = $request->phone3;
      $patient->gender = $request->gender;
      $patient->dob = $request->dob;
      $patient->email = $request->email;

      $patient->save();

      Session::flash('success', 'The patient was updated');

      return redirect()->route('patients.show', $patient->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $patient = Patient::find($id);
      $patient->delete();
      Session::flash('success', 'The patient was deleted');
      return redirect()->route('patients.index');
    }
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/*******************************************************************************
/******************************************************************************/
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
      $charge->date_from = Carbon::createFromFormat('m/d/Y', $request->date_from);
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
        $tax->date_from = Carbon::createFromFormat('m/d/Y', $request->date_from);
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
      $payment->date_from =  Carbon::createFromFormat('m/d/Y', $request->date_from);
      $payment->attending_provider = $request->attending_provider;
      $payment->procedure_code = $request->payment_code;
      $payment->procedure_description = $procedure->description;
      $payment->who_paid = $request->who_paid;
      $payment->transaction_type = $procedure->type;
      $payment->total = -($request->total);
      $payment->unapplied_amount = -($request->total);

      $patient->remaining_balance += $payment->total;
      $patient->last_pmt = $payment->total;
      $patient->date_of_last_pmt = $request->date_from;

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
     * Assign an insurer to a patient
     * /patients/assignInsurer
     **/
     public function assignInsurer(Request $request)
     {
       $this->validate($request, array(
         'patient_id' => 'required',
         'insurer_num' => 'required',
         'insurer' => 'required'
       ));

       $patient = Patient::find($request->patient_id);
       switch($request->insurer_num) {
        case 1:
          $patient->insurer1 = $request->insurer;
          $patient->save();
          Session::flash('success', 'The insurer was added');
          return redirect()->route('patients.show', $patient->id);
          break;
        case 2:
          $patient->insurer2 = $request->insurer;
          $patient->save();
          Session::flash('success', 'The insurer was added');
          return redirect()->route('patients.show', $patient->id);
          break;
        case 3:
          $patient->insurer3 = $request->insurer;
          $patient->save();
          Session::flash('success', 'The insurer was added');
          return redirect()->route('patients.show', $patient->id);
       }
     }
}
