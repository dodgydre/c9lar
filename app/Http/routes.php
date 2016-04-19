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
Route::get('testPrint', function() {
  $data = [];
  $pdf = PDF::loadView('testStatement', $data);
  return $pdf->stream();
  return view('testStatement');
});




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
    
    // Auth routes login, logout, register, password reset 
    Route::auth();

    
    // Calendar Routes  (TODO: create and update events should become ajax routes maybe?)
    Route::get('/calendar/{provider_id}/show', 'AppointmentController@showCalendar');
    Route::post('/calendar/{provider_id}/updateEvent', 'AppointmentController@updateEvent');
    Route::post('/calendar/{provider_id}/createEvent', 'AppointmentController@createEvent');



    // Generate a test PDF statement (TODO: add in options for start/end/etc.)
    Route::get('/patients/{id}/testStatement', [
        'as' => 'patients.testStatement',
        'uses' => 'PatientController@generateStatement'
        ]);


    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');

    // EmployeeController Resource
    Route::resource('employees', 'EmployeeController');

    // ProcedureController Resource
    Route::resource('procedures', 'ProcedureController');
    // InsurerController Resource
    Route::resource('insurers', 'InsurerController');

    // Additional route for patient using {chart_number} instead of {id}
    Route::get('patients/{chart_number}', 'PatientController@showChartNum')->where('chart_number', '[A-Z]{5}[0-9]{3}');

    // PatientController Resource - Good
    Route::resource('patients', 'PatientController');
    // Assign insurer to a patient - (done through AJAX)
    Route::post('/patients/assignInsurer', ['as' => 'patients.assignInsurer', 'uses' => 'PatientController@assignInsurer']);

    // Add Charge and Payment to patient.  patient_id is in the $request variable
    Route::post('/patients/addCharge', ['as' => 'patients.addCharge', 'uses' => 'PatientController@addCharge']);
    Route::post('/patients/addPayment', ['as' => 'patients.addPayment', 'uses' => 'PatientController@addPayment']);

    // Apply a payment to {patient} by {payor}  (FORM)
    Route::get('/patients/{id}/apply/{transaction}/from/{payor}', ['as' => 'patients.applyPaymentForm', 'uses' => 'PatientController@applyPaymentForm']);
    // apple a payment (POST)
    Route::post('/patients/applyPayment', ['as' => 'patients.applyPayment','uses' => 'PatientController@applyPayment']);

    // Apply a payment to the most recent charges until all empty.
    Route::post('/applyPaymentsToRecent', ['as' => 'patients.applyPaymentsToMostRecent', 'uses' => 'PatientController@applyPaymentsToMostRecent']);



    // TASK LIST ROUTES
    Route::resource('tasks', 'TaskController');
    Route::post('/ajaxTaskStatus', 'TaskController@changeStatus');


    // Admin group (TODO: check how to name the routes in a prefix group?)
    // put these in a hasRole('admin') middleware through Entrust
    /*Route::group(['prefix' => 'admin'], function () {
        Route::get('users', function ()    {
            // Matches The "/admin/users" URL
        });
    });*/
    Route::get('/admin/checkBalances', [
      'as'   => 'admin.checkBalances',
      'uses' => 'AdminController@tidyUpPatientRemainingBalance'
    ]);
    // Calendar routes  (TODO: TESTERS... remove these)
    Route::get('/admin/calendar', 'AdminController@getCalendarID');
    Route::get('/admin/calendar/add', 'AdminController@addCalendarEvent');
    // View transaction logs (TODO: Generate similar routes for other logs.  Add logs elsewhere)
    Route::get('/admin/transactionLog/user/{id}', [
      'as'  => 'admin.transactionLog',
      'uses' => 'adminController@listTransactionLogs'
    ]);


    

    // test  (TODO: This was for testing hasRole.  Can remove)
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


    // TODO: used?
    Route::get('/splash', function () {
        return view('welcome');
    });

    // List all patient transactions
    Route::get('/patients/{id}/transactions', function($id) {
        $patient = Patient::find($id);
        $transactions = $patient->transactions;
        foreach($transactions as $transaction) {
           echo $transaction->id . ' - ' . $transaction->procedure_description . ': $' . $transaction->amount . '<br />';
        }
       return 'end';
    });

    // TODO:  USED?
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


});
