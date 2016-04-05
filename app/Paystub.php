<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paystub extends Model
{
    public function employee()
    {
      return $this->belongsTo('App\Employee');
    }
    
    public function eiToDate($current_date) 
    {
      return $this->employee->eiToDate($current_date);
    }

}
