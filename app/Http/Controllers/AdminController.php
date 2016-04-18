<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Log;

use App\Services\GoogleCalendar;

use App\Http\Requests;
use App\Patient;
use App\Transaction;

class AdminController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth', ['only'=>[
      'tidyUpPatientRemainingBalance'
      ]]);
      // also 'except' for views that don't go through the middleware.
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

  public function listTransactionLogs($id)
  {
    //return $id;
    $logs = Log::get();
    return view('auditing', compact('logs'));
  }

  public function getCalendarID()
  {
    $calendar = new GoogleCalendar;
    $calendarId = 'pn0qnhkiai0calfpf7b1lvojfg@group.calendar.google.com';
    $result = $calendar->getEvents($calendarId);
    $result = $calendar->get($calendarId);
    $result = $calendar->addEvent($calendarId);
  }

}
