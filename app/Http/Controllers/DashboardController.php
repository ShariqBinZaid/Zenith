<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Opportunity;

class DashboardController extends Controller
{
    public function adminDashboard(){
        $totalead=Leads::count();
        $totalopportunity=Opportunity::count();
        return view('dashboard.admin', compact(['totalead','totalopportunity']));
    }
}
