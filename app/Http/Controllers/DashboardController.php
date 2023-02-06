<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\Brands;
use App\Models\Packages;
use App\Models\Opportunity;
use App\Models\LeaveTypes;
use App\Models\Leaves;
use App\Models\User;
use App\Models\Shifts;
use Auth;
use App\Models\Attendance;
class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalead=Leads::count();
        $totalopportunity=Opportunity::count();
        $totalbrand=Brands::count();
        $totalpackage=Packages::count();
        $totalbrand = Brands::count();
        $leads = Leads::latest()->take(3)->get();
        $totalead = Leads::count();
        $opportunities = Opportunity::latest()->take(3)->get();
        $totaopportunity = Opportunity::count();
        $packages = Packages::latest()->take(4)->get();
        $totapackage = Packages::count();
        $date = strtotime(date('d-M-Y'));
        $totalleaves = LeaveTypes::sum('days');
        $myleaves = Leaves::where('year',date('Y'))->count();
        $attendance = Attendance::where(['date'=>$date,'userid'=>Auth::user()->id])->first();
        if($attendance == NULL)
        {
            $timedin = 0;
            $timedout = 0;
        }
        else{
            if($attendance->timein != NULL && $attendance->timeout == NULL)
            {
                $timedin = 1;
                $timedout = 0;
            }
            else{
                $timedin = 1;
                $timedout = 1;
            }
        }
        return view('dashboard.admin', compact(['totalead','totalopportunity','totalbrand','totalpackage','leads','totalead','opportunities','totaopportunity','packages','totapackage','timedin','timedout','attendance','totalleaves','myleaves']));
    }
}