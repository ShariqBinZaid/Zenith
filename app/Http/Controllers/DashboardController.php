<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Brands;
use App\Models\Packages;
use App\Models\Opportunity;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalead=Leads::count();
        $totalopportunity=Opportunity::count();
        $totalbrand=Brands::count();
        $totalpackage=Packages::count();
        $brands = Brands::latest()->take(3)->get();
        $totalbrand = Brands::count();
        $leads = Leads::latest()->take(3)->get();
        $totalead = Leads::count();
        $opportunities = Opportunity::latest()->take(3)->get();
        $totaopportunity = Opportunity::count();
        $packages = Packages::latest()->take(4)->get();
        $totapackage = Packages::count();
        return view('dashboard.admin', compact(['totalead','totalopportunity','totalbrand','totalpackage','brands','leads','totalead','opportunities','totaopportunity','packages','totapackage']));
    }
}








