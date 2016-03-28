<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Patient;
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
          'phone4' => 'max:255',
          'phone5' => 'max:255',
          'gender' => 'max:1',
          'email' => 'max:255'
        ));
        
        $newChartStart = strtoupper(substr($request->last_name, 0, 3) . substr($request->first_name, 0, 2));
        $charts = Patient::where('chart_number', 'LIKE', $newChartStart . '%')->get();
        $endNumber = (string)count($charts)+1;
        
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
        $patient->phone4 = $request->phone4;
        $patient->phone5 = $request->phone5;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
