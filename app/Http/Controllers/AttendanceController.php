<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Holidays;
use App\Models\WorkFromHome;
use App\Models\LeaveTypes;
use App\Models\Discrepancy;
use App\Models\Leaves;
use App\Models\User;
use App\Models\Company;
use App\Events\AttendanceNotify;
use App\Models\Units;
use App\Models\Shifts;
use App\Models\Teams;
use App\Models\Notify;
use App\Models\Departments;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function timeIn()
    {
        $userid = Auth::user()->id;
        $timein = time();
        $date = strtotime(date('d-M-Y'));
        $timein = Attendance::updateOrCreate([
            'userid' => $userid,
            'date' => $date
        ], [
            'timein' => $timein
        ]);
        $hrdepart = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'human_resource_manager');
                $q->orWhere('name', 'human_resource_executive');
            }
        )->where('company_id', Auth::user()->company_id)->get();
        $notifyusers = array();
        foreach ($hrdepart as $thishr) {
            array_push($notifyusers, $thishr->id);
        }
        if (getuserRole() == 'admin' || getuserRole() == 'superadmin') {
        } else {
            // new code
            if ((Auth::user()->is_leader == 1 && Auth::user()->unit_id != 0) || (Auth::user()->is_leader == 0 && Auth::user()->unit_id != 0 && Auth::user()->team_id == 0)) {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                $unithead = Units::where('id', Auth::user()->unit_id)->pluck('unithead')->first();
                array_push($notifyusers, $unithead, $companyOwner);
            } elseif (Auth::user()->is_leader == 0 && Auth::user()->unit_id == 0 && Auth::user()->team_id != 0) {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                $team_lead = Teams::where('id', Auth::user()->team_id)->pluck('leader')->first();
                array_push($notifyusers, $team_lead, $companyOwner);
            } elseif (Auth::user()->is_leader == 0 && Auth::user()->unit_id != 0 && Auth::user()->team_id != 0) {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                $team_lead = Teams::where('id', Auth::user()->team_id)->pluck('leader')->first();
                $unithead = Units::where('id', Auth::user()->unit_id)->pluck('unithead')->first();
                array_push($notifyusers, $unithead, $companyOwner, $team_lead);
            } else {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                array_push($notifyusers, $companyOwner);
            }
        }
        foreach ($notifyusers as $thisnotifyuser) {
            $unitheaddata = User::find($thisnotifyuser);
            $notificationfor = $thisnotifyuser;
            $userid = Auth::user()->id;
            $theurl = 'attendance/user/' . Auth::user()->id . '/' . sprintf("%02d", date('m')) . '/' . date('Y');
            $timein->notifyalert()->create(['for' => $notificationfor, 'message' => Auth::user()->name . ' Timed In!', 'data' => serialize(['url' => $theurl, 'userid' => Auth::user()->id, 'month' => date('m'), 'year' => date('Y'), 'timedin_at' => time()])]);
            $notify = Notify::where('for', $thisnotifyuser)->where('notifiable_type', Attendance::class)->latest()->first();
            $url = config('app.url') . $theurl;
            event(new AttendanceNotify($notify, $notificationfor, $url));
        }
        $successmessage = "Timed In Successfuly!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function timeOut()
    {
        $userid = Auth::user()->id;
        $timeout = time();
        $date = strtotime(date('d-M-Y'));
        $timein = Attendance::where('userid', $userid)->latest()->first();
        $timeout = Attendance::where(['userid' => $userid, 'date' => $timein->date])->update(['timeout' => $timeout, 'totalhours' => ($timeout - ($timein->timein))]);
        $hrdepart = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'human_resource_manager');
                $q->orWhere('name', 'human_resource_executive');
            }
        )->where('company_id', Auth::user()->company_id)->get();
        $notifyusers = array();
        foreach ($hrdepart as $thishr) {
            array_push($notifyusers, $thishr->id);
        }
        if (getuserRole() == 'admin' || getuserRole() == 'superadmin') {
        } else {
            // new code
            if ((Auth::user()->is_leader == 1 && Auth::user()->unit_id != 0) || (Auth::user()->is_leader == 0 && Auth::user()->unit_id != 0 && Auth::user()->team_id == 0)) {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                $unithead = Units::where('id', Auth::user()->unit_id)->pluck('unithead')->first();
                array_push($notifyusers, $unithead, $companyOwner);
            } elseif (Auth::user()->is_leader == 0 && Auth::user()->unit_id == 0 && Auth::user()->team_id != 0) {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                $team_lead = Teams::where('id', Auth::user()->team_id)->pluck('leader')->first();
                array_push($notifyusers, $team_lead, $companyOwner);
            } elseif (Auth::user()->is_leader == 0 && Auth::user()->unit_id != 0 && Auth::user()->team_id != 0) {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                $team_lead = Teams::where('id', Auth::user()->team_id)->pluck('leader')->first();
                $unithead = Units::where('id', Auth::user()->unit_id)->pluck('unithead')->first();
                array_push($notifyusers, $unithead, $companyOwner, $team_lead);
            } else {
                $companyOwner = Company::where('id', Auth::user()->company_id)->pluck('owner')->first();
                array_push($notifyusers, $companyOwner);
            }
        }
        foreach ($notifyusers as $thisnotifyuser) {
            $unitheaddata = User::find($thisnotifyuser);
            $notificationfor = $thisnotifyuser;
            $userid = Auth::user()->id;
            $theurl = 'attendance/user/' . Auth::user()->id . '/' . sprintf("%02d", date('m')) . '/' . date('Y');
            $timein->notifyalert()->create(['for' => $notificationfor, 'message' => Auth::user()->name . ' Timed Out!', 'data' => serialize(['url' => $theurl, 'userid' => Auth::user()->id, 'month' => date('m'), 'year' => date('Y'), 'timedout_at' => time()])]);
            $notify = Notify::where('for', $thisnotifyuser)->where('notifiable_type', Attendance::class)->latest()->first();
            $url = config('app.url') . $theurl;
            event(new AttendanceNotify($notify, $notificationfor, $url));
        }
        $successmessage = "Timed Out Successfuly!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function attendance($id, $month, $year)
    {
        $userdata = User::find($id);
        $numofdesc  = Discrepancy::whereBetween('date', [\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->where('user_id', $id)->count();
        if (Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'human_resource_executive' || Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'superadmin' || $id == Auth::user()->id) {
        } else {
            if (Auth::user()->roles->pluck('name')[0] == 'sales_head' && (User::where('id', $id)->pluck('depart_id')->first() == 1)) {
            } else {
                if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
                    if ((Units::where('unithead', Auth::user()->id)->count() > 0) && (User::where('id', $id)->pluck('unit_id')->first() == Units::where('unithead', Auth::user()->id)->pluck('id')->first())) {
                    } else {
                        return abort(403, "You cannot view other's attendance");
                    }
                } else {
                    if ($userdata->reporting_authority == Auth::user()->id) {
                    } else {
                        return abort(403, "You cannot view other's attendance");
                    }
                }
            }
        }
        $userdata = User::find($id);
        $date = "01-" . $month . "-" . $year;
        $firstday = strtotime(date('Y-m-01', strtotime($date)));
        $lastday = strtotime(date('Y-m-t', strtotime($date)));
        // dd($firstday);
        $attendance = array();
        $totalannualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
        $totalcasualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
        $totalsickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
        $takenannualleaves = Leaves::where(['type'=>1,'userid'=>$id,'year'=>date('Y')])->count();
        $takencasualleaves = Leaves::where(['type'=>2,'userid'=>$id,'year'=>date('Y')])->count();
        $takensickleaves = Leaves::where(['type'=>3,'userid'=>$id,'year'=>date('Y')])->count();
        $annualleaves = $totalannualleaves - $takenannualleaves;
        $casualleaves = $totalcasualleaves - $takencasualleaves;
        $sickleaves = $totalsickleaves - $takensickleaves;
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $usersalary = $userdata->getMeta('salary');
        $perdaysalary = $usersalary / $totalDays;
        $earned = 0;
        $deduction = 0;
        $halfdays = 0;
        for ($i = $firstday; $i <= $lastday; $i += 86400) {
            $perdayattendance = Attendance::where([['userid', '=', $id], ['date', '=', $i]])->first();
            $day = date('l', $i);
            if ($perdayattendance == NULL) {
                if ($i > strtotime(date('d-M-Y'))) {
                    $data = ['status' => 'future', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => ''];
                } elseif (strtotime($userdata->getMeta('joining')) > $i) {
                    $data = ['status' => 'beforejoining', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Not Joined Yet'];
                } else {
                    if (date('D', $i) == 'Sat' || date('D', $i) == 'Sun') {
                        $data = ['status' => 'weekend', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Weekend'];
                        $earned += 1;
                    }elseif (Holidays::where('holiday_date', $i)->count() > 0) {
                        $data = ['status' => 'holiday', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Holiday (' . Holidays::where('holiday_date', $i)->pluck('name')->first() . ')'];
                        $earned += 1;
                    }elseif (WorkFromHome::where(['date'=>$i,'user_id'=>$id])->count() > 0) {
                        $wfhstatus = WorkFromHome::where(['date'=>$i,'user_id'=>$id])->pluck('status')->first();
                        if($wfhstatus == 'approved'){$earned += 1;}else{$deduction += 1;}
                        $data = ['status' => 'workfromhome'.$wfhstatus, 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Work from home request '.$wfhstatus];
                    }elseif ($i == strtotime(date('d-M-Y'))) {
                        $data = ['status' => 'today', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Today'];
                    } else {
                        $noofleaves = Leaves::where(['date' => $i, 'userid' => $id])->count();
                        $leavestatus = Leaves::where(['date' => $i, 'userid' => $id])->pluck('final_status')->first();
                        $data = ['status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Absent', 'no_of_leaves' => $noofleaves, 'leave_status' => $leavestatus];
                        if ($leavestatus == 'approved') {
                            $earned += 1;
                        } else {
                            $deduction += 1;
                        }
                    }
                }
            } elseif ($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL) {
                $data = ['status' => 'today', 'timein' => $perdayattendance->timein, 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Today'];
            } elseif ($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600) {
                $data = ['status' => 'halfday', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Half Day'];
                $halfdays += 1;
            } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL) {
                $noofleaves = Leaves::where(['date' => $i, 'userid' => $id])->count();
                $leavestatus = Leaves::where(['date' => $i, 'userid' => $id])->pluck('final_status')->first();
                $data = ['status' => 'nohalfday', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Less then Half Day (Absent)', 'no_of_leaves' => $noofleaves, 'leave_status' => $leavestatus];
                if ($leavestatus == 'approved') {
                    $earned += 1;
                } else {
                    $deduction += 1;
                }
            } elseif ($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL) {
                $disrepency = Discrepancy::where('user_id', $id)->where('date', $i)->count();
                $disrepencystatus = Discrepancy::where('user_id', $id)->where('date', $i)->pluck('status')->first();
                if ($numofdesc >= 5) {
                    $disc_allowed = 0;
                } else {
                    $disc_allowed = 1;
                }
                $data = ['status' => 'forgettotimeout', 'timein' => $perdayattendance->timein, 'timeout' => '-', 'totalhours' => '-', 'date' => $i, 'day' => $day, 'name' => 'Forgot to Timeout', 'num_of_descrepancy' => $disrepency, 'disc_status' => $disrepencystatus, 'disc_allowed' => $disc_allowed];
                if ($disrepencystatus == 'approved') {
                    $earned += 1;
                } else {
                    $deduction += 1;
                }
            } else {
                $data = ['status' => 'present', 'timein' => $perdayattendance->timein, 'timeout' => $perdayattendance->timeout, 'totalhours' => $perdayattendance->totalhours, 'date' => $i, 'day' => $day, 'name' => 'Present'];
                $earned += 1;
            }
            if ($halfdays < 3) {
                $earned += $halfdays;
            } else {
                if ($halfdays % 3 == 0) {
                    $halddayded = $halfdays / 3;
                    $deduction += $halddayded;
                } else {
                    $remainder = $halfdays % 3;
                    $halfdayded = ($halfdays - $remainder) / 3;
                    $deduction += $halfdayded;
                    $earned += $remainder;
                }
            }
            $expecteddeduction = number_format($deduction * $perdaysalary, 2, '.', ',');
            array_push($attendance, $data);
        }
        $leavetypes = LeaveTypes::where('company_id', Auth::user()->company_id)->get();
        $users = User::where('company_id', Auth::user()->company_id)->whereNotIn('id', ['1', '2'])->get();
        return view('attendance.index', compact(['userdata', 'attendance', 'firstday', 'lastday', 'month', 'year', 'annualleaves', 'casualleaves', 'sickleaves', 'earned', 'deduction', 'expecteddeduction', 'leavetypes', 'users','takenannualleaves','takencasualleaves','takensickleaves']));
    }
    public function datewise()
    {
        if (request()->has('date')) {
            $date = strtotime(request()->date);
        } else {
            $date = strtotime(date('d-M-Y'));
        }
        $users = User::where('company_id', Auth::user()->company_id)->where('id', '!=', '2');
        if (request()->has('departments')) {
            $users = $users->whereIn('depart_id', request()->departments);
        }

        $users = $users->get();
        $totalusers = User::where('company_id', Auth::user()->company_id)->count();
        $presentusers = Attendance::where('date', $date)->count();
        $absentusers = $totalusers - $presentusers;
        $finalarray = array();
        foreach ($users as $user) {
            $attendance = Attendance::where('userid', $user->id)->where('date', $date)->first();
            if (@$attendance->timein == NULL) {
                $status = 'Absent';
                $timein = '--';
                $timeout = '--';
                $workinghours = '--';
                $class = 'table-danger';
            } elseif (@$attendance->timeout == NULL) {
                $status = 'Present';
                $timein = date('h:i:s A', $attendance->timein);
                $timeout = '--';
                $workinghours = '--';
                $class = 'table-success';
            } else {
                $status = 'Gone';
                $timein = date('h:i:s A', $attendance->timein);
                $timeout = date('h:i:s A', $attendance->timeout);
                $workinghours = gmdate('H:i:s', $attendance->totalhours);
                $class = 'table-light';
            }
            $singleuser = [
                'userid' => $user->id,
                'phone' => $user->phone,
                'timein' => $timein,
                'timeout' => $timeout,
                'workinghours' => $workinghours,
                'status' => $status,
                'username' => $user->name,
                'image' => $user->image,
                'department' => $user->getDepart->name,
                'designation' => $user->getMeta('designation'),
                'class' => $class
            ];
            if (request()->has('status')) {
                $statussearch = request()->status;
                if ($statussearch == 'All') {
                    array_push($finalarray, $singleuser);
                } else {
                    if ($statussearch == $status) {
                        array_push($finalarray, $singleuser);
                    }
                }
            } else {
                $statussearch = 'All';
                array_push($finalarray, $singleuser);
            }
        }
        $departments = Departments::all();
        $filterdepart = request()->departments;
        $filterdepart = $filterdepart ?? [];
        return view('attendance.date-wise', compact(['finalarray', 'date', 'absentusers', 'presentusers', 'departments', 'filterdepart', 'statussearch']));
    }
    public function dateWiseCSV()
    {
        if (request()->has('date')) {
            $date = strtotime(request()->date);
        } else {
            $date = strtotime(date('d-M-Y'));
        }
        $users = User::where('company_id', Auth::user()->company_id)->where('id', '!=', '2');
        $departnames = '';
        if (request()->has('departments')) {
            $users = $users->whereIn('depart_id', request()->departments);
            foreach (request()->departments as $thisdepart) {
                $departname = Departments::where('id', $thisdepart)->pluck('name')->first();
                $departnames .= $departname . '-';
            }
        }
        $users = $users->get();
        $totalusers = User::where('company_id', Auth::user()->company_id)->count();
        $presentusers = Attendance::where('date', $date)->count();
        $absentusers = $totalusers - $presentusers;
        $finalarray = array();
        foreach ($users as $user) {
            $attendance = Attendance::where('userid', $user->id)->where('date', $date)->first();
            if (@$attendance->timein == NULL) {
                $status = 'Absent';
                $timein = '--';
                $timeout = '--';
                $workinghours = '--';
                $class = 'table-danger';
            } elseif (@$attendance->timeout == NULL) {
                $status = 'Present';
                $timein = date('h:i:s A', $attendance->timein);
                $timeout = '--';
                $workinghours = '--';
                $class = 'table-success';
            } else {
                $status = 'Gone';
                $timein = date('h:i:s A', $attendance->timein);
                $timeout = date('h:i:s A', $attendance->timeout);
                $workinghours = gmdate('H:i:s', $attendance->totalhours);
                $class = 'table-light';
            }
            $singleuser = [
                'userid' => $user->id,
                'emp_id' => $user->getMeta('emp_id'),
                'timein' => $timein,
                'timeout' => $timeout,
                'workinghours' => $workinghours,
                'status' => $status,
                'username' => $user->name,
                'department' => $user->getDepart->name,
                'designation' => $user->getMeta('designation')
            ];
            if (request()->has('status')) {
                $statussearch = request()->status;
                if ($statussearch == 'All') {
                    array_push($finalarray, $singleuser);
                } else {
                    if ($statussearch == $status) {
                        array_push($finalarray, $singleuser);
                    }
                }
            } else {
                $statussearch = 'All';
                array_push($finalarray, $singleuser);
            }
        }
        $headers = array("Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=" . $departnames . "-(" . $statussearch . ")-attendance-" . request()->date . ".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0");
        $columns = array('Employee ID', 'Username', 'Time In', 'Time Out', 'Working Hours', 'Status', 'Department', 'Designation');
        $callback = function () use ($finalarray, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($finalarray as $row) {
                $data = array($row['emp_id'], $row['username'], $row['timein'], $row['timeout'], $row['workinghours'], $row['status'], $row['department'], $row['designation']);
                fputcsv($file, $data);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public function attendanceCSV($id, $month, $year)
    {
        $userdata = User::find($id);
        if (Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'human_resource_executive' || Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'superadmin' || $id == Auth::user()->id) {
        } else {
            if (Auth::user()->roles->pluck('name')[0] == 'sales_head' && (User::where('id', $id)->pluck('depart_id')->first() == 1)) {
            } else {
                if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
                    if ((Units::where('unithead', Auth::user()->id)->count() > 0) && (User::where('id', $id)->pluck('unit_id')->first() == Units::where('unithead', Auth::user()->id)->pluck('id')->first())) {
                    } else {
                        return abort(403, "You cannot view other's attendance");
                    }
                } else {
                    if ($userdata->reporting_authority == Auth::user()->id) {
                    } else {
                        return abort(403, "You cannot view other's attendance");
                    }
                }
            }
        }
        $userdata = User::find($id);
        $date = "01-" . $month . "-" . $year;
        $firstday = strtotime(date('Y-m-01', strtotime($date)));
        $lastday = strtotime(date('Y-m-t', strtotime($date)));
        $attendance = array();
        $annualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
        $casualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
        $sickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
        for ($i = $firstday; $i <= $lastday; $i += 86400) {
            $perdayattendance = Attendance::where([['userid', '=', $id], ['date', '=', $i]])->first();
            $day = date('l', $i);
            if ($perdayattendance == NULL) {
                if ($i > strtotime(date('d-M-Y'))) {
                    $data = ['status' => 'future', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => ''];
                } elseif (strtotime($userdata->getMeta('joining')) > $i) {
                    $data = ['status' => 'beforejoining', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Not Joined Yet'];
                } else {
                    if (date('D', $i) == 'Sat' || date('D', $i) == 'Sun') {
                        $data = ['status' => 'weekend', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Weekend'];
                    } elseif (Holidays::where('holiday_date', $i)->count() > 0) {
                        $data = ['status' => 'holiday', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Holiday (' . Holidays::where('holiday_date', $i)->pluck('name')->first() . ')'];
                    } else {
                        $data = ['status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Absent'];
                    }
                }
            } elseif ($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL) {
                $data = ['status' => 'today', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Today'];
            } elseif ($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600) {
                $data = ['status' => 'halfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Half Day'];
            } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL) {
                $data = ['status' => 'nohalfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Less then Half Day (Absent)'];
            } elseif ($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL) {
                $data = ['status' => 'forgettotimeout', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Forgot to Timeout'];
            } else {
                $data = ['status' => 'present', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Present'];
            }
            array_push($attendance, $data);
        }
        $headers = array("Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=attendance-" . $userdata->name . "-" . date('F', mktime(0, 0, 0, $month, 10)) . "-" . $year . ".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0");
        $columns = array('Date', 'Day', 'Time In', 'Time Out', 'Working Hours', 'Status');
        $callback = function () use ($attendance, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($attendance as $row) {
                $data = array($row['date'], $row['day'], $row['timein'], $row['timeout'], $row['totalhours'], $row['name']);
                fputcsv($file, $data);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public function companyattendanceCSV($month, $year)
    {
        $users = User::where('company_id', Auth::user()->company_id)->whereNotIn('id', [1, 2])->get();
        $attendance = array();
        foreach ($users as $thisuser) {
            $userdata = User::where('id', $thisuser->id)->with('getDepart')->first();
            $date = "01-" . $month . "-" . $year;
            $firstday = strtotime(date('Y-m-01', strtotime($date)));
            $lastday = strtotime(date('Y-m-t', strtotime($date)));
            $annualleaves = LeaveTypes::where('name', 'Annual Leaves')->pluck('days')->first();
            $casualleaves = LeaveTypes::where('name', 'Casual Leaves')->pluck('days')->first();
            $sickleaves = LeaveTypes::where('name', 'Sick Leaves')->pluck('days')->first();
            for ($i = $firstday; $i <= $lastday; $i += 86400) {
                $perdayattendance = Attendance::where([['userid', '=', $thisuser->id], ['date', '=', $i]])->first();
                $day = date('l', $i);
                if ($perdayattendance == NULL) {
                    if ($i > strtotime(date('d-M-Y'))) {
                        $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'future', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => ''];
                    } elseif (strtotime($userdata->getMeta('joining')) > $i) {
                        $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'beforejoining', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Not Joined Yet'];
                    } else {
                        if (date('D', $i) == 'Sat' || date('D', $i) == 'Sun') {
                            $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'weekend', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Weekend'];
                        } elseif (Holidays::where('holiday_date', $i)->count() > 0) {
                            $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'holiday', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Holiday (' . Holidays::where('holiday_date', $i)->pluck('name')->first() . ')'];
                        } else {
                            $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'absent', 'timein' => '-', 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Absent'];
                        }
                    }
                } elseif ($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL) {
                    $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'today', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Today'];
                } elseif ($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600) {
                    $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'halfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Half Day'];
                } elseif ($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL) {
                    $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'nohalfday', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Less then Half Day (Absent)'];
                } elseif ($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL) {
                    $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'forgettotimeout', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => '-', 'totalhours' => '-', 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Forgot to Timeout'];
                } else {
                    $data = ['username' => $userdata->name, 'department' => $userdata->getDepart->name, 'status' => 'present', 'timein' => date('h:i:s A', $perdayattendance->timein), 'timeout' => date('h:i:s A', $perdayattendance->timeout), 'totalhours' => gmdate('H:i:s', $perdayattendance->totalhours), 'date' => date('d-M-Y', $i), 'day' => $day, 'name' => 'Present'];
                }
                array_push($attendance, $data);
            }
        }
        $headers = array("Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=company-attendance-" . date('F', mktime(0, 0, 0, $month, 10)) . "-" . $year . ".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0");
        $columns = array('Name', 'Department', 'Date', 'Day', 'Time In', 'Time Out', 'Working Hours', 'Status');
        $callback = function () use ($attendance, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($attendance as $row) {
                $data = array($row['username'], $row['department'], $row['date'], $row['day'], $row['timein'], $row['timeout'], $row['totalhours'], $row['name']);
                fputcsv($file, $data);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
