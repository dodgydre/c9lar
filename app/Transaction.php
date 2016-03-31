<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function appliedClass()
    {
      if($this->total < 0)
      {
        if($this->unapplied_amount == 0) return '';
        elseif($this->unapplied_amount == $this->total) return 'warning';
        elseif($this->unapplied_amount < 0) return 'info';
        else return 'danger';
      }
    }

    public function paidClass()
    {
      if($this->total > 0)
      $paid = $this->g1_amount_paid + $this->i1_amount_paid + $this->i2_amount_paid + $this->i3_amount_paid;
      {
        if($paid == 0) return 'warning';
        if($this->total == -$paid) return '';
        if($this->total > -$paid) return 'info';
        else return 'danger';
      }
    }
}
