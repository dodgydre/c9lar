<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public function calendar() {
      return $this->hasOne('App\Calendar');
    }

    public function name() {
      $name = $this->first_name . " " . $this->last_name;
      return $name;
    }
}
