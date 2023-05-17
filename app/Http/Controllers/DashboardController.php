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
use App\Models\Finance;
use App\Models\Shifts;
use App\Models\Units;
use Auth;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $date = strtotime(date('d-M-Y'));
        if(Auth::user()->roles->pluck('name')[0] == 'superadmin' || Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'sales_head')
        {
            $brands = Brands::latest()->take(3)->get();
            $totalbrand = Brands::count();
            $leads = Leads::latest()->take(3)->get();
            $totalead = Leads::count();
            $totaluser = User::count();
            $opportunities = Opportunity::latest()->take(3)->get();
            $totalopportunity = Opportunity::count();
            $packages = Packages::latest()->take(4)->get();
            $totalpackage = Packages::count();
            $totalleaves = LeaveTypes::sum('days');
            $myleaves = Leaves::where('year', date('Y'))->where('userid',Auth::user()->id)->count();
            $totalusers = User::where('company_id',Auth::user()->company_id)->count();
            $presentusers = Attendance::where('date',$date)->count();
            $absentusers = $totalusers - $presentusers;
            $attendance = Attendance::where('userid',Auth::user()->id)->latest()->first();
            if (@$attendance == NULL) {
                $timedin = 0;
                $timedout = 0;
            } else {
                if((time() - $attendance->timein) < 54000)
                {
                    if ($attendance->timein != NULL && $attendance->timeout == NULL) {
                        $timedin = 1;
                        $timedout = 0;
                    } else {
                        $timedin = 1;
                        $timedout = 1;
                    }
                }else{
                    $timedin = 0;
                    $timedout = 0;
                }
                
            }
            if(Auth::user()->roles->pluck('name')[0] == 'superadmin'){
                $users = User::with('latestattendance')->get();
            }else{
                $users = User::where('company_id',Auth::user()->company_id)->with('latestattendance')->get();
            }
            $discrepancies = Attendance::whereBetween('date', [strtotime(date('01-m-Y')), strtotime(date('Y-m-t'))])->where('userid',Auth::user()->id)->where('timeout',NULL)->where('date','!=',strtotime(date('d-m-Y')))->count();
            
            return view('dashboard.admin', compact(['brands', 'totalbrand', 'leads', 'totalead', 'opportunities', 'totalopportunity', 'packages', 'totalpackage', 'timedin', 'timedout', 'attendance', 'totalleaves', 'myleaves', 'users','presentusers','absentusers','discrepancies']));
        }
        elseif(Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'human_resource_executive')
        {
            $totalleaves = LeaveTypes::sum('days');
            $myleaves = Leaves::where('year', date('Y'))->where('userid',Auth::user()->id)->count();
            $attendance = Attendance::where('userid',Auth::user()->id)->latest()->first();
            $totalusers = User::where('company_id',Auth::user()->company_id)->count();
            $presentusers = Attendance::where('date',$date)->count();
            $absentusers = $totalusers - $presentusers;
            if (@$attendance == NULL) {
                $timedin = 0;
                $timedout = 0;
            } else {
                if((time()-$attendance->timein) < 54000)
                {
                    if ($attendance->timein != NULL && $attendance->timeout == NULL) {
                        $timedin = 1;
                        $timedout = 0;
                    } else {
                        $timedin = 1;
                        $timedout = 1;
                    }
                }else{
                    $timedin = 0;
                    $timedout = 0;
                }
                
            }
            $totalLeaves = Leaves::where(['year'=>date('Y'),'final_status'=>'pending'])->count();
            $totalusers = User::where('company_id',Auth::user()->company_id)->count();
            $totalFinance = Finance::where('companyid',Auth::user()->company_id)->count();
            $users = User::where('company_id',Auth::user()->company_id)->with('latestattendance')->get();
            $discrepancies = Attendance::whereBetween('date', [strtotime(date('01-m-Y')), strtotime(date('Y-m-t'))])->where('userid',Auth::user()->id)->where('timeout',NULL)->where('date','!=',strtotime(date('d-m-Y')))->count();
            return view('dashboard.human_resource', compact(['totalLeaves','totalFinance','totalusers','timedin', 'timedout', 'attendance', 'totalleaves', 'myleaves','date','users','presentusers','absentusers','discrepancies']));
        }
        else{
            if(Auth::user()->depart_id == 2 || Auth::user()->depart_id == 12 || Auth::user()->depart_id == 17 || Auth::user()->depart_id == 10)
            {
              $totalleaves = LeaveTypes::sum('days');
            $myleaves = Leaves::where('year', date('Y'))->where('userid',Auth::user()->id)->count();
            $attendance = Attendance::where('userid',Auth::user()->id)->latest()->first();
           
            if (@$attendance == NULL) {
                $timedin = 0;
                $timedout = 0;
            } else {
                // dd($attendance->timein-time());
                if((time() - $attendance->timein) < 54000)
                {
                    
                    if ($attendance->timein != NULL && $attendance->timeout == NULL) {
                        $timedin = 1;
                        $timedout = 0;
                    } else {
                        $timedin = 1;
                        $timedout = 1;
                    }
                }else{
                    $timedin = 0;
                    $timedout = 0;
                }
                
            }
             
            $totalleads =Leads::whereHas('users', function ($query)  {
                $query->where('leads_user.user_id', '=', Auth::user()->id);
            })->count();
            $totalopportunities =Opportunity::whereHas('users', function ($query)  {
                $query->where('opportunity_user.user_id', '=', Auth::user()->id);
            })->count();
            if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $unitid = Units::where('unithead', Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach ($unitid->brands as $thisbrand) {
                array_push($brands, $thisbrand->id);
            }
            $leads = Leads::whereIn('brand_id', $brands);
            } else {
            $user = Auth::user();
            $leads = Leads::whereHas('users', function ($query) use ($user) {
                $query->where('leads_user.user_id', '=', $user->id);
            });
            }

        $leads = $leads->take(4)->get();
        
        if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $unitid = Units::where('unithead', Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach ($unitid->brands as $thisbrand) {
                array_push($brands, $thisbrand->id);
            }
            $opportunities = Opportunity::whereIn('brand_id', $brands)
                ->take(4)->get();
        } else {
            $user = Auth::user();
            $opportunities = Opportunity::whereHas('users', function ($query) use ($user) {
                $query->where('opportunity_user.user_id', '=', $user->id);
            })
            ->take(4)->get();
        }
        
            $users = User::where('company_id',Auth::user()->company_id)->with('latestattendance')->get();
            $discrepancies = Attendance::whereBetween('date', [strtotime(date('01-m-Y')), strtotime(date('Y-m-t'))])->where('userid',Auth::user()->id)->where('timeout',NULL)->where('date','!=',strtotime(date('d-m-Y')))->count();
            return view('dashboard.production', compact(['totalleads','totalopportunities','timedin', 'timedout', 'attendance', 'totalleaves', 'myleaves','date','users','leads','opportunities','discrepancies']));
            }else{
            $totalleaves = LeaveTypes::sum('days');
            $myleaves = Leaves::where('year', date('Y'))->where('userid',Auth::user()->id)->count();
            $attendance = Attendance::where('userid',Auth::user()->id)->latest()->first();
           
            if (@$attendance == NULL) {
                $timedin = 0;
                $timedout = 0;
            } else {
                // dd($attendance->timein-time());
                if((time() - $attendance->timein) < 54000)
                {
                    
                    if ($attendance->timein != NULL && $attendance->timeout == NULL) {
                        $timedin = 1;
                        $timedout = 0;
                    } else {
                        $timedin = 1;
                        $timedout = 1;
                    }
                }else{
                    $timedin = 0;
                    $timedout = 0;
                }
                
            }
             
            $totalleads =Leads::whereHas('users', function ($query)  {
                $query->where('leads_user.user_id', '=', Auth::user()->id);
            })->count();
            $totalopportunities =Opportunity::whereHas('users', function ($query)  {
                $query->where('opportunity_user.user_id', '=', Auth::user()->id);
            })->count();
            if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $unitid = Units::where('unithead', Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach ($unitid->brands as $thisbrand) {
                array_push($brands, $thisbrand->id);
            }
            $leads = Leads::whereIn('brand_id', $brands);
            } else {
            $user = Auth::user();
            $leads = Leads::whereHas('users', function ($query) use ($user) {
                $query->where('leads_user.user_id', '=', $user->id);
            });
            }

        $leads = $leads->take(4)->get();
        
        if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $unitid = Units::where('unithead', Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach ($unitid->brands as $thisbrand) {
                array_push($brands, $thisbrand->id);
            }
            $opportunities = Opportunity::whereIn('brand_id', $brands)
                ->take(4)->get();
        } else {
            $user = Auth::user();
            $opportunities = Opportunity::whereHas('users', function ($query) use ($user) {
                $query->where('opportunity_user.user_id', '=', $user->id);
            })
            ->take(4)->get();
        }
        
            $users = User::where('company_id',Auth::user()->company_id)->with('latestattendance')->get();
            $discrepancies = Attendance::whereBetween('date', [strtotime(date('01-m-Y')), strtotime(date('Y-m-t'))])->where('userid',Auth::user()->id)->where('timeout',NULL)->where('date','!=',strtotime(date('d-m-Y')))->count();
            return view('dashboard.sales', compact(['totalleads','totalopportunities','timedin', 'timedout', 'attendance', 'totalleaves', 'myleaves','date','users','leads','opportunities','discrepancies']));
        }
        }
    }
    public function welcome()
    {
        return view('welcome');
    }
}