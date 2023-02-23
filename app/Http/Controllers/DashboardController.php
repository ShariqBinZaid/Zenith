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
    public function dashboard()
    {
        $date = strtotime(date('d-M-Y'));
        if(Auth::user()->roles->pluck('name')[0] == 'superadmin' || Auth::user()->roles->pluck('name')[0] == 'admin')
        {
            $brands = Brands::latest()->take(3)->get();
            $totalbrand = Brands::count();
            $leads = Leads::latest()->take(3)->get();
            $totalead = Leads::count();
            $opportunities = Opportunity::latest()->take(3)->get();
            $totalopportunity = Opportunity::count();
            $packages = Packages::latest()->take(4)->get();
            $totalpackage = Packages::count();
            $totalleaves = LeaveTypes::sum('days');
            $myleaves = Leaves::where('year', date('Y'))->count();
            $attendance = Attendance::where(['date' => $date, 'userid' => Auth::user()->id])->first();
            if ($attendance == NULL) {
                $timedin = 0;
                $timedout = 0;
            } else {
                if ($attendance->timein != NULL && $attendance->timeout == NULL) {
                    $timedin = 1;
                    $timedout = 0;
                } else {
                    $timedin = 1;
                    $timedout = 1;
                }
            }
            $users = User::with('latestattendance')->get();
            return view('dashboard.admin', compact(['brands', 'totalbrand', 'leads', 'totalead', 'opportunities', 'totalopportunity', 'packages', 'totalpackage', 'timedin', 'timedout', 'attendance', 'totalleaves', 'myleaves', 'users']));
        }
        else{
            
            $totalleaves = LeaveTypes::sum('days');
            $myleaves = Leaves::where('year', date('Y'))->count();
            $attendance = Attendance::where(['date' => $date, 'userid' => Auth::user()->id])->first();
            if ($attendance == NULL) {
                $timedin = 0;
                $timedout = 0;
            } else {
                if ($attendance->timein != NULL && $attendance->timeout == NULL) {
                    $timedin = 1;
                    $timedout = 0;
                } else {
                    $timedin = 1;
                    $timedout = 1;
                }
            }
            $totalleads =Leads::whereHas('users', function ($query)  {
                $query->where('leads_user.user_id', '=', Auth::user()->id);
            })->count();
            $totalopportunities =Opportunity::whereHas('users', function ($query)  {
                $query->where('opportunity_user.user_id', '=', Auth::user()->id);
            })->count();
            
            $users = User::with('latestattendance')->get();
            return view('dashboard.sales', compact(['totalleads','totalopportunities','timedin', 'timedout', 'attendance', 'totalleaves', 'myleaves','date','users']));
        }
    }
    public function welcome()
    {
        return view('welcome');
    }
}