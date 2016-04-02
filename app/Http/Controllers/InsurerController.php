<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Insurer;
use Session;

class InsurerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insurer = Insurer::orderBy('id', 'asc')->get();
        return view('insurers.index')->withInsurers($insurer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insurers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: validation for phone numbers?
        $this->validate($request, array(
          'code'=>'required|max:15|unique:insurers,code',
          'name'=>'required',
          'street1' => 'max:150',
          'street2' => 'max:150',
          'city' => 'max:50',
          'prov' => 'max:25',
          'country' => 'max:25',
          'postcode' => 'max:10',
          'phone' => 'max:15',
          'fax' => 'max:15',
        ));

        $insurer = new Insurer;

        $insurer->code = $request->code;
        $insurer->name = $request->name;
        $insurer->street1 = $request->street1;
        $insurer->street2 = $request->street2;
        $insurer->city = $request->city;
        $insurer->prov = $request->prov;
        $insurer->country = $request->country;
        $insurer->postcode = $request->postcode;
        $insurer->phone = $request->phone;
        $insurer->fax = $request->fax;

        $insurer->save();

        Session::flash('success', 'The insurer has been created');

        return redirect()->route('insurers.show', $insurer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $insurer = Insurer::find($id);
        return view('insurers.show')->withInsurer($insurer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insurer = Insurer::find($id);
        return view('insurers.edit')->withInsurer($insurer);
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
      //TODO: validation for phone numbers?
      $this->validate($request, array(
        /*'code'=>'required|max:5|unique:insurers,code',*/
        'name'=>'required',
        'street1' => 'max:150',
        'street2' => 'max:150',
        'city' => 'max:50',
        'prov' => 'max:25',
        'country' => 'max:25',
        'postcode' => 'max:10',
        'phone' => 'max:15',
        'fax' => 'max:15',
      ));

      $insurer = Insurer::find($id);

      $insurer->code = $request->input('code');
      $insurer->name = $request->input('name');
      $insurer->street1 = $request->input('street1');
      $insurer->street2 = $request->input('street2');
      $insurer->city = $request->input('city');
      $insurer->prov = $request->input('prov');
      $insurer->country = $request->input('country');
      $insurer->postcode = $request->input('postcode');
      $insurer->phone = $request->input('phone');
      $insurer->fax = $request->input('fax');

      $insurer->save();

      Session::flash('success', 'The insurer has been updated');

      return redirect()->route('insurers.show', $insurer->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insurer = Insurer::find($id);
        $insurer::delete();

        Session::flash('success', 'The insurer was deleted');
        return redirect()->route('insurers.index');

    }
}
