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
        $brands = Brands::latest()->take(4)->get();
        $totalbrand = Brands::count();
        return view('dashboard.admin', compact(['totalead','totalopportunity','totalbrand','totalpackage','brands']));
    }
}








