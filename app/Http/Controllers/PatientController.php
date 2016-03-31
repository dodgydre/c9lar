<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Patient;
use App\Transaction;
use App\Procedure;
use Session;

class PatientController extends Controller
{
    // Set Auth Middleware for All but Patient Index.  Add admin only to delete
    public function __construct()
    {
      $this->middleware('auth', ['only'=>[
        'create',
        'delete',
        'store',
        'edit',
        'update',
        ]]);
        // also 'except' for views that don't go through the middleware.
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::orderBy('id', 'asc')->get();
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
      $procedures = Procedure::orderBy('code')->where('type', '=', 'A')->orWhere('type', '=', 'B')->get();
      $payments = Procedure::orderBy('code')->where('type', '!=', 'A')->Where('type', '!=', 'B')->get();

      return view('patients.show')->withPatient($patient)->withProcedures($procedures)->withPayments($payments);
    }


    public function showChartNum($chart_number)
    {
      $patient = Patient::where('chart_number', '=', $chart_number)->first();
      $procedures = Procedure::orderBy('code')->where('type', '=', 'A')->orWhere('type', '=', 'B')->get();
      $payments = Procedure::orderBy('code')->where('type', '!=', 'A')->Where('type', '!=', 'B')->get();

      return view('patients.show')->withPatient($patient)->withProcedures($procedures)->withPayments($payments);
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
      //dd($request->procedure_code);

      $charge = new Transaction;
      $charge->patient_id = $request->patient_id;
      $charge->chart_number = $patient->chart_number;
      $charge->date_from = $request->date_from;
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
        'payment_code'    => 'required|max:8',
        'payment_description' => 'required',
        'who_paid' => 'required'
      ));

      $patient = Patient::find($request->patient_id);
      $procedure = Procedure::where('code', '=', $request->payment_code)->first();
      //dd($request->procedure_code);
      $payment = new Transaction;
      $payment->patient_id = $request->patient_id;
      $payment->chart_number = $patient->chart_number;
      $payment->date_from = $request->date_from;
      $payment->attending_provider = $request->attending_provider;
      $payment->procedure_code = $request->payment_code;
      $payment->procedure_description = $request->payment_description;
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
     public function applyPayment($id, $transaction_id, $payor) {
       $patient = Patient::find($id);
       $thisTransaction = Transaction::find($transaction_id);
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



    /**
    * We need some sort of Admin method to check the Remaining Balances of all patients
    * In case things get out of whack.
    * TODO: This should perhaps be moved to an AdminController.php file
    *
    **/
    public function tidyUpPatientRemainingBalance() {
      $patients = Patient::all();
      foreach ($patients as $patient)
      {
        echo "Patient: " . $patient->chart_number . ' - ' . $patient->last_name . ', ' . $patient->first_name . '<br />';
        $remaining = 0;
        $transactions = $patient->transactions;
        foreach ($transactions as $transaction)
        {
            echo $transaction->total . '<br />';
            $remaining += $transaction->total;
        }
        echo $remaining . '<br /><br />';
        $patient->remaining_balance = $remaining;
        $patient->save();
      }
    }

}
