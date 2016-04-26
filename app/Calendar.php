<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public function provider() {
      return $this->belongsTo('App\Provider');
    }
}
