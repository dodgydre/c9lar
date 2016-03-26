<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Role;
use App\Permission;
use App\User;
use App\Patient;
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
    
    public function getUserModifiedPatients($id) {
        
        $user = User::find($id);
        $patients = $user->hasModified()->get();
        
        foreach($patients as $patient) {
            echo $patient->first_name;
        }
        
        return "done";
    }
    
    public function getPatientsModifiedBy($id) {
        $patient = Patient::find($id);
        $modifier = $patient->modifiedBy()->first();
        
        return "Patient: " . $patient->first_name . " " . $patient->last_name . " - Last modified by: " . $modifier->name;
    }
    
}
