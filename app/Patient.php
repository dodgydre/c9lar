<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Patient extends Model
{
    protected $primarykey = 'id';

    public function appointments() 
    {
        return $this->hasMany('App\Appointment');
    }
    
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
    
    // Charges are Transactions where the amount is +ve
    public function charges()
    {
        return $this->hasMany('App\Transaction')->where('transactions.amount', '>', '0');
    }
    
    // Payments are Transactions where the amount is -ve
    public function payments()
    {
        return $this->hasMany('App\Transaction')->where('transactions.amount', '<', '0');
    }
    
    // Created By:
    /*public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }

    // Modified By:
    public function modifiedBy() {
        return $this->belongsTo('App\User', 'modified_by');
    }*/
}
