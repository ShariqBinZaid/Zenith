<?php

namespace App\Http\Controllers;

use App\Models\Leaves;
use App\Models\LeaveTypes;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Models\Activity;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalleave = Leaves::where('userid',auth()->user()->id)->count();
        $leaves = Leaves::where('userid',auth()->user()->id)->with('leavetype')->latest()->paginate(25);
        $leavetypes = LeaveTypes::all();
        $personal = 1;
        $username = auth()->user()->name;
        return view('leaves.index', compact(['totalleave','leaves','leavetypes','personal','username']));
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
        $leavesShow = $request->validate([
            'start_date' => 'required',
             'reason' => 'required'
        ], [
            'start_date.required' => "Date field is required.",
            'Reason.required' => "Reason field is required."
        ]);
        $LeaveStore = Leaves::all();
        $year = date('Y',strtotime($request->start_date));
        $typedays = LeaveTypes::where('id',$request->type)->pluck('days')->first();
        $typename = LeaveTypes::where('id',$request->type)->pluck('name')->first();
        $takendays = Leaves::where(['type'=>$request->type,'userid'=>auth()->user()->id,'year'=>date('Y')])->count();
        if($request->half_day == NULL)
        {
            $halfday = 0;
        }
        else{
            $halfday = 1;
        }
        if($request->end_date == NULL)
        {
            if($takendays >= $typedays){
                $message = $typename." are completely availed by you!";
                $msgstatus = 'error';
                
            }else{
                Leaves::updateOrCreate(
                    ['date' =>  strtotime($request->start_date),'year'=>$year,'userid'=>auth()->user()->id],
                    ['type'=>$request->type,'reason'=>$request->reason,'half_day'=>$halfday,'status'=>'pending']);
                    $message = "Leave applied successfully!";
                    $msgstatus = 'success';
            }
            
            
        }else{
            $startdate = strtotime($request->start_date);
            $enddate = strtotime($request->end_date);
            for($i=$startdate;$i<=$enddate;$i+=86400)
            {
                if($takendays >= $typedays){
                    $message = $typename." are completely availed by you!";
                    $msgstatus = 'error';
                }else{
                    Leaves::updateOrCreate(
                    ['date' =>  $i,'year'=>$year,'userid'=>auth()->user()->id],
                    ['type'=>$request->type,'reason'=>$request->reason,'half_day'=>$halfday,'status'=>'pending']);}
                    $message = $typename." are completely availed by you!";
                    $msgstatus = 'error';
            }
        }
        return Redirect::back()->with($msgstatus,$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function show(Leaves $leaves)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function edit(Leaves $leaves)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leaves $leaves)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leaves $leaves)
    {
        //
    }
    public function userleaves($id)
    {
        $totalleave = Leaves::where('userid',$id)->count();
        $leaves = Leaves::where('userid',$id)->with('leavetype')->latest()->paginate(10);
        $leavetypes = LeaveTypes::all();
        $personal = NULL;
        $username = User::where('id',$id)->pluck('name')->first();
        return view('leaves.index', compact(['totalleave','leaves','leavetypes','personal','username']));
    }
    public function approve(Request $request)
    {
        $leave=Leaves::find($request->id);
        $leave->update(['status'=>'approved']);
        return 'success';
    }
    public function reject(Request $request){
        $leave=Leaves::find($request->id);
        $leave->update(['status'=>'rejected']);
        return 'success';
    }
    public function activitylogs()
    {
        $lastLoggedActivity = Activity::all()->last();
        dd($lastLoggedActivity->description);
    }
}
