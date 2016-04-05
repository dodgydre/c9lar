<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Carbon\Carbon;

use App\Employee;


class EmployeeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $employees = Employee::orderBy('id')->get();
      return view('employees.index')->withEmployees($employees);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('employees.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $this->validate($request, array(
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
      ));

      $employee = new Employee;
      $employee->first_name = $request->first_name;
      $employee->last_name = $request->last_name;
      $employee->status = 1;
      $employee->birth_date = Carbon::createFromFormat('m/d/Y', $request->birth_date);
      $employee->hire_date = Carbon::createFromFormat('m/d/Y', $request->hire_date);
      $employee->street1 = $request->street1;
      $employee->street2 = $request->street2;
      $employee->city = $request->city;
      $employee->prov = $request->prov;
      $employee->post_code = $request->post_code;
      $employee->country = $request->country;
      $employee->phone = $request->phone;
      $employee->email = $request->email;
      $employee->sin = $request->sin;

      $employee->save();

      Session::flash('success', 'The Employee has been added');

      return redirect()->route('employees.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $employee = Employee::find($id);
      return view('employees.show')->withEmployee($employee);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $employee = Employee::find($id);
      $employee->birth_date = Carbon::createFromFormat('Y-m-d', $employee->birth_date)->format('m/d/Y');
      $employee->hire_date = Carbon::createFromFormat('Y-m-d', $employee->hire_date)->format('m/d/Y');
      return view('employees.edit')->withEmployee($employee);
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
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255'

      ));

      $employee = Employee::find($id);

      $employee->first_name = $request->first_name;
      $employee->last_name = $request->last_name;
      $employee->status = 1;
      $employee->birth_date = Carbon::createFromFormat('m/d/Y', $request->birth_date);
      $employee->hire_date = Carbon::createFromFormat('m/d/Y', $request->hire_date);
      $employee->street1 = $request->street1;
      $employee->street2 = $request->street2;
      $employee->city = $request->city;
      $employee->prov = $request->prov;
      $employee->post_code = $request->post_code;
      $employee->country = $request->country;
      $employee->phone = $request->phone;
      $employee->email = $request->email;
      $employee->sin = $request->sin;
      $employee->status = $request->status;

      $employee->save();

      Session::flash('sucess', 'The employee was updated');

      return redirect()->route('employees.show', $employee->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $employee = Employee::find($id);
      $employee->delete();

      Session::flash('success', 'The Employee was deleted');
      return redirect()->route('employees.index');
  }


}
