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
        $patient->dob = Carbon::createFromFormat('m/d/Y', $request->dob);
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
     *
     * Generate a new statement
     *  @param id, date_from, date_to
     *
     **/
    public function generateStatement($id) {
      $patient = Patient::find($id);

      $date_from = new Carbon('last friday');
      $date_to = new Carbon;

      $date_to = $date_to->tomorrow()->format('Y-m-d');
      $date_from = $date_from->format('Y-m-d');

      $transactions = Transaction::where('patient_id','=', $patient->id)
        ->where('date_from', '<', $date_to)
        ->where('date_from', '>', $date_from)
        ->get();
      $sum_charges = 0;
      $sum_payments = 0;

      foreach($transactions as $transaction) {
        if($transaction->total > 0) $sum_charges += $transaction->total;
        else $sum_payments += $transaction->total;
      }

      $data = ['patient' => $patient, 'transactions' => $transactions, 'sum_charges' => $sum_charges, 'sum_payments' => $sum_payments];
      $pdf = \PDF::loadView('testStatement', $data);
      return $pdf->stream();

      return view('patients.testStatement')->withPatient($patient)->withTransactions($transactions)->with('sum_payments', $sum_payments)->with('sum_charges', $sum_charges);
      dd($transactions);

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
