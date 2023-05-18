<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Holidays;
use App\Models\LeaveTypes;
use App\Models\Discrepancy;
use App\Models\Departments;
use App\Models\Leaves;
use App\Models\User;
use App\Models\Tax;
use App\Models\Company;
use Auth;
class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('month')){
            $month = request()->month;
        }else{
            $month = date('m');
        }
        if(request()->has('year')){
            $year = request()->year;
        }else{
            $year = date('Y');
        }
        $users = User::where('company_id',Auth::user()->company_id)->where('id','!=','2');
        if(request()->has('departments'))
        {
            $users = $users->whereIn('depart_id', request()->departments);
        }
        
        $users = $users->get();
        $allusers = array();
        foreach($users as $thisuser)
        {
            $userdata = User::find($thisuser->id);
            $numofdesc  = Discrepancy::whereBetween('date', [\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->where('user_id',$thisuser->id)->count();
            $date = "01-".$month."-".$year;
            $firstday = strtotime(date('Y-m-01',strtotime($date)));
            $lastday = strtotime(date('Y-m-t',strtotime($date)));
            $annualleaves = LeaveTypes::where('name','Annual Leaves')->pluck('days')->first();
            $casualleaves = LeaveTypes::where('name','Casual Leaves')->pluck('days')->first();
            $sickleaves = LeaveTypes::where('name','Sick Leaves')->pluck('days')->first();
            $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $usersalary = $userdata->getMeta('salary');
            $perdaysalary = $usersalary/$totalDays;
            $earned = 0;
            $deduction= 0;
            $halfdays = 0;
            for($i = $firstday;$i<=$lastday;$i+=86400)
            {
               $perdayattendance = Attendance::where([['userid','=',$thisuser->id],['date','=',$i]])->first();
               $day = date('l', $i);
               if($perdayattendance == NULL){
                    if($i > strtotime(date('d-M-Y'))){
                        
                    }
                    elseif(strtotime($userdata->getMeta('joining')) > $i)
                    {
                        
                    }
                    else{
                        if(date('D', $i) == 'Sat' || date('D', $i) == 'Sun')
                        {
                            
                            $earned+=1;
                        }
                        elseif(Holidays::where('holiday_date',$i)->count() > 0)
                        {
                            
                            $earned+=1;
                        }
                        elseif($i == strtotime(date('d-M-Y')))
                        {
                            
                        }
                        else{
                            $noofleaves = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->count();
                            $leavestatus = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->pluck('final_status')->first();
                            
                            if($leavestatus == 'approved'){
                                $earned+=1;
                            }else{
                                $deduction+=1;
                            }
                            
                        }
                    }
               }
               elseif($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL)
               {
                    
               }
               elseif($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600)
               {
                    
                    $halfdays+=1;
               }
               elseif($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL)
               {
                    $noofleaves = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->count();
                    $leavestatus = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->pluck('final_status')->first();
                    
                    if($leavestatus == 'approved'){
                        $earned+=1;
                    }else{
                        $deduction+=1;
                    }
               }
               elseif($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL)
               {
                $disrepency = Discrepancy::where('user_id',$thisuser->id)->where('date',$i)->count();
                $disrepencystatus = Discrepancy::where('user_id',$thisuser->id)->where('date',$i)->pluck('status')->first();
                if($numofdesc >= 5){
                    $disc_allowed = 0;
                }else{
                    $disc_allowed = 1;
                }
                if($disrepencystatus == 'approved')
                {
                    $earned+=1;
                }
                else{
                    $deduction+=1;
                }
               }
               else{
                $earned+=1;
               }
               if($halfdays < 3)
               {
                   $earned+=$halfdays;
               }else{
                  if($halfdays%3 == 0)
                  {
                      $halddayded = $halfdays/3;
                      $deduction+=$halddayded;
                  }
                  else{
                      $remainder = $halfdays%3;
                      $halfdayded = ($halfdays - $remainder)/3;
                      $deduction+=$halfdayded;
                      $earned+=$remainder;
                  }
               }
               $yearlysalarry = $usersalary*12;
                $taxslab = Tax::where('from', '<=', $yearlysalarry)->where('to', '>=', $yearlysalarry)
                      ->orderBy('from', 'desc')
                      ->first();
                      
                $difference = floatval($yearlysalarry)-$taxslab->from;
                $taxamount = ceil(round((($difference*$taxslab->tax_percent/100)+$taxslab->amount)/12, 2));
                $deductionamount = number_format($deduction*$perdaysalary, 2, '.', ',');
                $earnedamount = number_format($earned*$perdaysalary, 2, '.', ',');
                $totalamount = number_format(($earned*$perdaysalary)-$taxamount, 2, '.', ',');
               
            }
            $data = [
                   'userid'=>$thisuser->id,
                   'username'=>$thisuser->name,
                   'image'=>$thisuser->image,
                   'designation'=>$thisuser->getMeta('designation'),
                   'department'=>$thisuser->getDepart->name,
                   'salary'=>number_format($usersalary, 2, '.', ','),
                   'deduction'=>$deductionamount,
                   'totalamount'=>$totalamount,
                   'earned'=>$earnedamount,
                   'deduction_days'=>$deduction,
                   'earned_days'=>$earned,
                   'tax_deduction'=>number_format($taxamount, 2, '.', ','),
                   'yearlysalary'=>$yearlysalarry,
                   'tax_percent'=>$taxslab->tax_percent,
                   'tax_amount'=>$taxslab->amount
               ];
               array_push($allusers,$data);
        }
        $departments = Departments::where('company_id',Auth::user()->company_id)->get();
        $filterdepart = request()->departments;
        $filterdepart = $filterdepart ?? [];
        return view('payroll.index',compact(['allusers','departments','filterdepart','month','year']));
    }
    public function payrollCSV()
    {
        if(request()->has('month')){
            $month = request()->month;
        }else{
            $month = date('m');
        }
        if(request()->has('year')){
            $year = request()->year;
        }else{
            $year = date('Y');
        }
        $users = User::where('company_id',Auth::user()->company_id)->where('id','!=','2');
        if(request()->has('departments'))
        {
            $users = $users->whereIn('depart_id', request()->departments);
        }
        
        $users = $users->get();
        $allusers = array();
        foreach($users as $thisuser)
        {
            $userdata = User::find($thisuser->id);
            $numofdesc  = Discrepancy::whereBetween('date', [\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->where('user_id',$thisuser->id)->count();
            $date = "01-".$month."-".$year;
            $firstday = strtotime(date('Y-m-01',strtotime($date)));
            $lastday = strtotime(date('Y-m-t',strtotime($date)));
            $annualleaves = LeaveTypes::where('name','Annual Leaves')->pluck('days')->first();
            $casualleaves = LeaveTypes::where('name','Casual Leaves')->pluck('days')->first();
            $sickleaves = LeaveTypes::where('name','Sick Leaves')->pluck('days')->first();
            $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $usersalary = $userdata->getMeta('salary');
            $perdaysalary = $usersalary/$totalDays;
            $earned = 0;
            $deduction= 0;
            $halfdays = 0;
            for($i = $firstday;$i<=$lastday;$i+=86400)
            {
               $perdayattendance = Attendance::where([['userid','=',$thisuser->id],['date','=',$i]])->first();
               $day = date('l', $i);
               if($perdayattendance == NULL){
                    if($i > strtotime(date('d-M-Y'))){
                        
                    }
                    elseif(strtotime($userdata->getMeta('joining')) > $i)
                    {
                        
                    }
                    else{
                        if(date('D', $i) == 'Sat' || date('D', $i) == 'Sun')
                        {
                            
                            $earned+=1;
                        }
                        elseif(Holidays::where('holiday_date',$i)->count() > 0)
                        {
                            
                            $earned+=1;
                        }
                        elseif($i == strtotime(date('d-M-Y')))
                        {
                            
                        }
                        else{
                            $noofleaves = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->count();
                            $leavestatus = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->pluck('final_status')->first();
                            
                            if($leavestatus == 'approved'){
                                $earned+=1;
                            }else{
                                $deduction+=1;
                            }
                            
                        }
                    }
               }
               elseif($perdayattendance->date == strtotime(date('d-M-Y')) && $perdayattendance->timeout == NULL)
               {
                    
               }
               elseif($perdayattendance->totalhours >= 16200 && $perdayattendance->totalhours <= 21600)
               {
                    
                    $halfdays+=1;
               }
               elseif($perdayattendance->totalhours < 16200 && $perdayattendance->totalhours != NULL)
               {
                    $noofleaves = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->count();
                    $leavestatus = Leaves::where(['date'=>$i,'userid'=>$thisuser->id])->pluck('final_status')->first();
                    
                    if($leavestatus == 'approved'){
                        $earned+=1;
                    }else{
                        $deduction+=1;
                    }
               }
               elseif($perdayattendance->timeout == NULL && $perdayattendance->timein != NULL)
               {
                $disrepency = Discrepancy::where('user_id',$thisuser->id)->where('date',$i)->count();
                $disrepencystatus = Discrepancy::where('user_id',$thisuser->id)->where('date',$i)->pluck('status')->first();
                if($numofdesc >= 5){
                    $disc_allowed = 0;
                }else{
                    $disc_allowed = 1;
                }
                if($disrepencystatus == 'approved')
                {
                    $earned+=1;
                }
                else{
                    $deduction+=1;
                }
               }
               else{
                $earned+=1;
               }
               if($halfdays < 3)
               {
                   $earned+=$halfdays;
               }else{
                  if($halfdays%3 == 0)
                  {
                      $halddayded = $halfdays/3;
                      $deduction+=$halddayded;
                  }
                  else{
                      $remainder = $halfdays%3;
                      $halfdayded = ($halfdays - $remainder)/3;
                      $deduction+=$halfdayded;
                      $earned+=$remainder;
                  }
               }
               $yearlysalarry = $usersalary*12;
                $taxslab = Tax::where('from', '<=', $yearlysalarry)->where('to', '>=', $yearlysalarry)
                      ->orderBy('from', 'desc')
                      ->first();
                      
                $difference = floatval($yearlysalarry)-$taxslab->from;
                $taxamount = ceil(round((($difference*$taxslab->tax_percent/100)+$taxslab->amount)/12, 2));
                $deductionamount = number_format($deduction*$perdaysalary, 2, '.', ',');
                $earnedamount = number_format($earned*$perdaysalary, 2, '.', ',');
                $totalamount = number_format(($earned*$perdaysalary)-$taxamount, 2, '.', ',');
               
            }
            $data = [
                   'userid'=>$thisuser->id,
                   'emp_id'=>$thisuser->getMeta('emp_id'),
                   'username'=>$thisuser->name,
                   'image'=>$thisuser->image,
                   'designation'=>$thisuser->getMeta('designation'),
                   'department'=>$thisuser->getDepart->name,
                   'salary'=>number_format($usersalary, 2, '.', ','),
                   'deduction'=>$deductionamount,
                   'earned'=>$earnedamount,
                   'totalamount'=>$totalamount,
                   'deduction_days'=>$deduction,
                   'earned_days'=>$earned,
                   'tax_deduction'=>number_format($taxamount, 2, '.', ','),
                   'yearlysalary'=>$yearlysalarry,
                   'tax_percent'=>$taxslab->tax_percent,
                   'tax_amount'=>$taxslab->amount
               ];
               array_push($allusers,$data);
        }
        $departnames = '';
        if(request()->has('departments'))
        {
            foreach(request()->departments as $thisdepart)
            {
                $departname = Departments::where('id',$thisdepart)->pluck('name')->first();
                $departnames .= $departname.'-';
            }
        }
        $headers = array( "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=payroll-".$month."-".$year."-".$departnames.".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0" ); 
        $columns = array( 'Employee ID', 'Username', 'Actual Salary', 'Deduction', 'Tax', 'No of working days', 'No of absent days','Total Amount(Excluding Tax Deduction)' ); 
        $callback = function() use ($allusers, $columns) { $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        foreach($allusers as $row) { 
            $data = array( $row['emp_id'], $row['username'], $row['salary'], $row['deduction'], $row['tax_deduction'], $row['earned_days'], $row['deduction_days'], $row['earned'] ); fputcsv($file, $data);
        } fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    
    public function generatePayroll(Request $request)
    {
        if(request()->has('month')){
            $month = request()->month;
        }else{
            $month = date('m');
        }
        if(request()->has('year')){
            $year = request()->year;
        }else{
            $year = date('Y');
        }
        $users = User::where('company_id',Auth::user()->company_id)->where('id','!=','2');
        if(request()->has('departments'))
        {
            $users = $users->whereIn('depart_id', request()->departments);
        }
        
        $users = $users->get();
        
        $payrollobj = new Payroll();
        $payrollobj->month = $request->month;
        $payrollobj->year = $request->year;
        $payrollobj->status = $request->status;
        $payrollobj->user_id = Auth::user()->user_id;
        $payrollobj->company_id = Auth::user()->company_id;
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
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
