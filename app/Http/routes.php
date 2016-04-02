<?php
use App\User;
use App\Patient;
use App\Procedure;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
    Route::get('/user/{id}', 'PageController@getUserModifiedPatients');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', function () {
        return view('welcome');
    });

    //Route::get('/accessTest', 'PageController@getAccessTest');

    Route::get('/tester', function() {
       return view('tester');
    });

    Route::get('/admin', function() {
           if(!empty(Auth::user()) && Auth::user()->hasRole('admin')) {
                return view('tester');
           }
           else {
               return view('welcome');
           }
    });

    // ProcedureController Resource - Good
    Route::resource('procedures', 'ProcedureController');
    // InsurerController Resource - Good
    Route::resource('insurers', 'InsurerController');

    // Additional route for patient using {chart_number} instead of {id}
    Route::get('patients/{chart_number}', 'PatientController@showChartNum')
      ->where('chart_number', '[A-Z]{5}[0-9]{3}');
    //Route::get('patients/{chart_number}/edit', 'PatientController@editChartNum')
    //  ->where('chart_number', '[A-Z]{5}[0-9]{3}');
    // PatientController Resource - Good
    Route::resource('patients', 'PatientController');

    // List all patient transactions
    Route::get('/patients/{id}/transactions', function($id) {
        $patient = Patient::find($id);
        $transactions = $patient->transactions;
        foreach($transactions as $transaction) {
           echo $transaction->id . ' - ' . $transaction->procedure_description . ': $' . $transaction->amount . '<br />';
        }
       return 'end';
    });

    // List all patient CHARGES (+ve amount)
    Route::get('/patients/{id}/charges', function($id) {
        $patient = Patient::find($id);
        $charges = $patient->charges;
        foreach($charges as $charge) {
           echo $charge->id . ': $' . $charge->amount . '<br />';
        }
       return 'end';
    });

    Route::get('/patients/{id}/payments', function($id) {
        $patient = Patient::find($id);
        $payments = $patient->payments;
        foreach($payments as $payment) {
           echo $payment->id . ': $' . $payment->amount . '<br />';
        }
       return 'end';
    });

    // Add Charge and Payment to patient.  patient_id is in the $request variable
    Route::post('/patients/addCharge', [
        'as' => 'patients.addCharge',
      'uses' => 'PatientController@addCharge'
    ]);
    Route::post('/patients/addPayment', [
        'as' => 'patients.addPayment',
      'uses' => 'PatientController@addPayment'
    ]);

    // Apply a payment to {patient} by {payor}
    Route::get('/patients/{id}/apply/{transaction}/from/{payor}', [
        'as' => 'patients.applyPaymentForm',
      'uses' => 'PatientController@applyPaymentForm'
    ]);
    Route::post('/patients/applyPayment', [
        'as' => 'patients.applyPayment',
      'uses' => 'PatientController@applyPayment'
    ]);

    Route::post('/patients/assignInsurer', [
        'as' => 'patients.assignInsurer',
      'uses' => 'PatientController@assignInsurer'
    ]);


    Route::get('/admin/checkBalances', [
      'as'   => 'admin.checkBalances',
      'uses' => 'AdminController@tidyUpPatientRemainingBalance'
    ]);


    Route::get('/testForm', function() {
      return view('patients.test');
    });

    Route::post('/testForm', [
      'as' => 'testForm',
      'uses' => 'PatientController@testForm'
    ]);

    Route::get('/test', function() {
      $x = array();
      $y = array();
      $counter = 1;
      $years = array(2010, 2011, 2012, 2013, 2014, 2015, 2016);
      foreach($years as $year) {
        for($month = 1; $month <= 12; $month++) {
          if ($month < 10) {
              $month = '0' . $month;
          }

          $search = $year . '-' . $month;

          $revenues = App\Transaction::where('date_from', 'like', $search .'%')->get();

          $sum = 0;
          foreach ($revenues as $revenue) {
              $sum += $revenue->amount;
          }

          array_push($x, (string)$year . "-" . (string)$month);
          array_push($y, $sum);
          $counter ++;
        }
      }
      return view('patients.test')->with('x', $x)->with('y', $y);
    });


    Route::get('/home', 'HomeController@index');
});
