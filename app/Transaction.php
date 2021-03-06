<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\AuditingTrait;

class Transaction extends Model
{
    use AuditingTrait;

    /**
     * Log custom message
     */
    public static $logCustomMessage = '{user.name|Anonymous} {type} a transaction {elapsed_time}';
    /**
     * Log custom fields message
     */
    /*public static $logCustomFields = [
        'name'  => 'The name was defined as {new.name}',
        'owner_id' => [
            'updated' => '{||ownerName} owns the team',
            'created' => '{owner.owner.name} was defined as owner'
        ],
    ];*/



    protected $fillable = [
      'g_amount_paid',
      'i1_amount_paid',
      'i2_amount_paid',
      'i3_amount_paid'
    ];

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public function charges()
    {
      return $this->belongsToMany('App\Transaction', 'payments', 'payment_ref', 'charge_ref')
        ->withPivot('amount', 'who_paid', 'deposit_id')
        ->withTimestamps();
    }

    public function payments()
    {
      return $this->belongsToMany('App\Transaction', 'payments', 'charge_ref', 'payment_ref')
        ->withPivot('amount', 'who_paid', 'deposit_id')
        ->withTimestamps();
    }

    public function onePayment($payment_id)
    {
      return $this->belongsToMany('App\Transaction', 'payments', 'charge_ref', 'payment_ref')
        ->withPivot('amount', 'who_paid', 'deposit_id')
        ->withTimestamps()
        ->where('payment_ref', '=', $payment_id);
    }

    /**
     * Apply various classes to the Apply form based on how much of the payment has been applied
     *
     **/
    public function appliedClass()
    {
      if($this->total < 0)
      {
        if($this->unapplied_amount == 0) return 'fully_applied';
        elseif($this->unapplied_amount == $this->total) return 'warning not_applied';
        elseif($this->unapplied_amount < 0) return 'info partially_applied';
        else return 'danger';
      }
    }

    public function paidClass()
    {
      if($this->total > 0)
      $paid = $this->g_amount_paid + $this->i1_amount_paid + $this->i2_amount_paid + $this->i3_amount_paid;
      {
        if($paid == 0) return 'warning not_paid';
        if($this->total == -$paid) return ' fully_paid';
        if($this->total > -$paid) return 'info partially_paid';
        else return 'danger over_paid';
      }
    }
    public function unapplied()
    {
      return $this->total + $this->g_amount_paid + $this->i1_amount_paid + $this->i2_amount_paid + $this->i3_amount_paid;
    }

}
