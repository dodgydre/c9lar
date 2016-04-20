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
        return $this->hasMany('App\Transaction')->orderBy('transactions.date_from', 'desc')->orderBy('transactions.updated_at', 'desc');
    }

    // Charges are Transactions where the amount is +ve
    public function charges()
    {
        return $this->hasMany('App\Transaction')->where('transactions.total', '>', '0')->orderBy('transactions.date_from', 'desc')->orderBy('transactions.updated_at', 'desc');
    }

    // Payments are Transactions where the amount is -ve
    public function payments()
    {
        return $this->hasMany('App\Transaction')->where('transactions.total', '<', '0')->orderBy('transactions.date_from', 'desc')->orderBy('transactions.updated_at', 'desc');
    }

    // hasOne from Insurers based on code
    public function insurance1()
    {
        return $this->hasOne('App\Insurer', 'code', 'insurer1');
    }
    public function insurance2()
    {
        return $this->hasOne('App\Insurer', 'code', 'insurer2');
    }
    public function insurance3()
    {
        return $this->hasOne('App\Insurer', 'code', 'insurer3');
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
