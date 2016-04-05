<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Transaction;
use App\Task;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $x = array();
      $y = array();
      $counter = 1;
      $years = array(2012, 2013, 2014, 2015, 2016);
      foreach($years as $year) {
        for($month = 1; $month <= 12; $month++) {
          if($year == 2016 && $month>3) {}
          else {
            if ($month < 10) {
                $month = '0' . $month;
            }


            $search = $year . '-' . $month;

            $revenues = Transaction::where('date_from', 'like', $search .'%')->get();

            $sum = 0;
            foreach ($revenues as $revenue) {
                $sum += $revenue->amount;
            }

            array_push($x, (string)$year . "-" . (string)$month);
            array_push($y, $sum);
            $counter ++;
          }
        }
      }

      $tasks = Task::where('status', '=', 0)->orderBy('updated_at', 'desc')->take(5)->get();


      return view('home')->with('x', $x)->with('y', $y)->withTasks($tasks);
    }
}
