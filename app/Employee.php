<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function paystubs()
    {
      return $this->hasMany('App\Paystub');
    }

    public function eiToDate($year)
    {
      return $this->paystubs()->where('ppe', 'like', $year . '%')->sum('ei');      
    }
}
