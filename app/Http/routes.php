<?php
use App\User;
use App\Patient;

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

    Route::get('/accessTest', 'PageController@getAccessTest');

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

    Route::resource('procedures', 'ProcedureController');
    Route::resource('insurers', 'InsurerController');

    Route::get('patients/{chart_number}', 'PatientController@showChartNum')
      ->where('chart_number', '[A-Z]{5}[0-9]{3}');
    //Route::get('patients/{chart_number}/edit', 'PatientController@editChartNum')
    //  ->where('chart_number', '[A-Z]{5}[0-9]{3}');
    Route::resource('patients', 'PatientController');



    Route::get('/home', 'HomeController@index');
});
