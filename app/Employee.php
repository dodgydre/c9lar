<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function paystubs()
    {
      return $this->hasMany('App\Paystub');
    }

    public function eiToDate($current_date)
    {
      $year = Carbon::createFromFormat('Y-m-d', $current_date)->year;
      $start_date = Carbon::createFromDate($year,1,1)->format('Y-m-d');
      $end_date = $current_date;
      return $this->paystubs()->where('ppe', '<', $end_date)->orWhere('ppe', '=', $end_date)->where('ppe', '>', $start_date)->sum('ei');      
    }
}
