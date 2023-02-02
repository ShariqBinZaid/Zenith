<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Auth;
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
            'date'=>$date
        ], [
            'timein'=>$timein
        ]);
        $successmessage = "Timed In Successfuly!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function timeOut()
    {
        $userid = Auth::user()->id;
        $timeout = time();
        $date = strtotime(date('d-M-Y'));
        $timein = Attendance::where(['userid'=>$userid,'date'=>$date])->pluck('timein')->first();
        $timeout = Attendance::updateOrCreate([
            'userid' => $userid,
            'date'=>$date
        ], [
            'timeout'=>$timeout,
            'totalhours'=>($timeout-$timein)
        ]);
        $successmessage = "Timed Out Successfuly!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function attendance($id,$month,$year)
    {
        $userdata = User::find($id);
        $date = "01-".$month."-".$year;
        $firstday = strtotime(date('Y-m-01',strtotime($date)));
        $lastday = strtotime(date('Y-m-t',strtotime($date)));
        $attendance = Attendance::where([['userid','=',$id],['date','>=',$firstday],['date','<=',$lastday]])->get();
        return view('attendance.index',compact(['userdata','attendance','firstday','lastday','month','year']));
    }
}
