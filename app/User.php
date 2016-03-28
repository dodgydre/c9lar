<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Patient;

class User extends Authenticatable
{

    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function hasModified() {
        return $this->hasMany('App\Patient', 'modified_by', 'id');
    }

    public function hasCreated() {
        return $this->hasMany('App\Patient', 'created_by', 'id');
    }
}
