<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Patient extends Model
{
    protected $primarykey = 'id';
    
    // Created By:
    public function createdBy() {
        return $this->belongsTo('App\User', 'created_by');
    }
    
    // Modified By:
    public function modifiedBy() {
        return $this->belongsTo('App\User', 'modified_by');
    }
}
