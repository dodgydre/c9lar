<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Procedure;
use Session;

class ProcedureController extends Controller
{
    // Change these so that delete only works for admin?
    public function __construct()
    {
      $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procedures = Procedure::orderBy('id', 'asc')->get();
        return view('procedures.index')->withProcedures($procedures);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('procedures.create');
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
          'code' => 'required|max:15|unique:procedures,code',
          'type' => 'required|max:1',
          'description' => 'required|max:255',
          'amount' => 'numeric'
        ));

        $procedure = new Procedure;

        $procedure->code = $request->code;
        $procedure->type = $request->type;
        $procedure->description = $request->description;
        $procedure->amount = $request->amount;
        $procedure->taxable = $request->taxable;
        $procedure->inactive = $request->inactive;

        $procedure->save();

        Session::flash('success', 'The procedure has been created');

        return redirect()->route('procedures.show', $procedure->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $procedure = Procedure::find($id);
        return view('procedures.show')->withProcedure($procedure);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $procedure = Procedure::find($id);
        if($procedure->type == 'Z') {
          return view('procedures.edit.tax')->withProcedure($procedure);
        }
        return view('procedures.edit')->withProcedure($procedure);
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
        'type' => 'required|max:1',
        'description' => 'required|max:255',
        'amount' => 'required|numeric'
      ));

      $procedure = Procedure::find($id);

      //$procedure->code = $request->input('code');
      $procedure->type = $request->input('type');
      $procedure->description = $request->input('description');
      $procedure->amount = $request->input('amount');
      $procedure->taxable = $request->input('taxable');
      $procedure->inactive = $request->input('inactive');
      //dd($request);
      $procedure->save();

      Session::flash('success', 'The procedure was updated');

      return redirect()->route('procedures.show', $procedure->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procedure = Procedure::find($id);
        $procedure->delete();
        Session::flash('success', 'The procedure was deleted');
        return redirect()->route('procedures.index');
    }
}
