<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $patientsCount = User::count();
       
    
        return view('admin.dashboard', compact(
            'patientsCount', 
            
        ));    
    }
}
