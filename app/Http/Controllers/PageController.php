<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use App\Permission;
use App\User;
use Auth;

class PageController extends Controller
{
    public function getAccessTest() {
        if(Auth::check()) {
            $user = Auth::user();
            if($user->hasRole('admin')) {
                return('Is Admin');
            }
            else {
                return("Not Admin");
            }
        }
        else {
            return("Not Logged In!");
        }   
    }
}
