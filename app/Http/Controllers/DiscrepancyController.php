<?php

namespace App\Http\Controllers;

use App\Models\Discrepancy;
use App\Models\Attendance;
use App\Models\Leaves;
use App\Models\User;
use App\Models\Notify;
use App\Events\LeavesNotify;
use Illuminate\Http\Request;
use Redirect;
use Auth;

class DiscrepancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        if(Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'human_resource_executive'){
            $discrepency = Discrepancy::where('company_id',Auth::user()->company_id)->latest();
        }else{
            $discrepency = Discrepancy::where(['company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id])->latest();
        }
        if ($status) {
            $discrepency->where('status', $status);
        }
        else {
            $discrepency->where('status', 'pending');
        }
        $discrepency = $discrepency->paginate(15);
        
        return view('discrepency.show', compact(['discrepency','status']));
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
        $validatedData = $request->validate([
            'desc' => 'required',
        ], [
            'desc.required' => 'Description field is required.',
        ]);
        $input = $request->all();
        $discrepancy = Discrepancy::create([
            'desc'=>$input['desc'],
            'user_id'=>Auth::user()->id,
            'company_id'=>Auth::user()->company_id,
            'date'=>$input['date']
        ]);
        $hrdepart = User::whereHas(
                'roles',
                function ($q) {
                    $q->where('name', 'human_resource_manager');
                    $q->orWhere('name', 'human_resource_executive');
                }
            )->where('company_id',Auth::user()->company_id)->get();
        $notifyusers = array();
        foreach($hrdepart as $thishr)
        {
            array_push($notifyusers,$thishr->id);
        }
        $user = User::find(Auth::user()->id);
        array_push($notifyusers,$user->reporting_authority);
        foreach($notifyusers as $thisnotifyuser)
        {
            $notificationfor = $thisnotifyuser;
            $url = env('APP_URL').'discrepancy';
            $discrepancy->notifyalert()->create(['for' => $notificationfor, 'message' => Auth::user()->name.' filled the discrepancy for ('.date('d-M-Y',$input['date']).')!','url'=>$url, 'data' => serialize(['url'=>$url,'userid' => Auth::user()->id,'month'=>date('m'),'year'=>date('Y'), 'filled_at' => time()])]);
            $notify = Notify::where('for', $notificationfor)->where('notifiable_type', Discrepancy::class)->latest()->first();
            event(new LeavesNotify($notify, $notificationfor,$url));
        }
        $successmessage = "Discrepancy saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discrepancy  $discrepancy
     * @return \Illuminate\Http\Response
     */
    public function show(Discrepancy $discrepancy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discrepancy  $discrepancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Discrepancy $discrepancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discrepancy  $discrepancy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discrepancy $discrepancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discrepancy  $discrepancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discrepancy $discrepancy)
    {
        //
    }
    public function approveDiscrepancy(Request $request)
    {
        $discrepancy = Discrepancy::find($request->id);
        $discrepancy->update(['status' => 'approved']);
        $attendance = Attendance::where(['userid'=>$discrepancy->user_id,'date'=>$discrepancy->date])->first();
        $attendance->update(['timeout' => ($attendance->timein+32400),'totalhours'=>32400]);
        $notifyusers = array();
        $user = User::find($discrepancy->user_id);
        array_push($notifyusers,$user->reporting_authority);
        array_push($notifyusers,$discrepancy->user_id);
        foreach($notifyusers as $thisnotifyuser)
        {
            $notificationfor = $thisnotifyuser;
            $url = env('APP_URL').'discrepancy';
            $discrepancy->notifyalert()->create(['for' => $notificationfor, 'message' => Auth::user()->name.'(Human Resource Department) approved your discrepancy for ('.date('d-M-Y',$discrepancy->date).')!','url'=>$url, 'data' => serialize(['url'=>$url,'approved_by'=>Auth::user()->id,'userid' => Auth::user()->id,'month'=>date('m'),'year'=>date('Y'), 'filled_at' => time()])]);
            $notify = Notify::where('for', $notificationfor)->where('notifiable_type', Discrepancy::class)->latest()->first();
            event(new LeavesNotify($notify, $notificationfor,$url));
        }
        return 'success';
    }

    public function rejectDiscrepancy(Request $request)
    {
        $discrepancy = Discrepancy::find($request->id);
        $discrepancy->update(['status' => 'rejected']);
        $notifyusers = array();
        $user = User::find($discrepancy->user_id);
        array_push($notifyusers,$user->reporting_authority);
        array_push($notifyusers,$discrepancy->user_id);
        foreach($notifyusers as $thisnotifyuser)
        {
            $notificationfor = $thisnotifyuser;
            $url = env('APP_URL').'discrepancy';
            $discrepancy->notifyalert()->create(['for' => $notificationfor, 'message' => Auth::user()->name.'(Human Resource Department) rejected your discrepancy for ('.date('d-M-Y',$discrepancy->date).')!','url'=>$url, 'data' => serialize(['url'=>$url,'rejected_by'=>Auth::user()->id,'userid' => Auth::user()->id,'month'=>date('m'),'year'=>date('Y'), 'filled_at' => time()])]);
            $notify = Notify::where('for', $notificationfor)->where('notifiable_type', Discrepancy::class)->latest()->first();
            event(new LeavesNotify($notify, $notificationfor,$url));
        }
        return 'success';
    }
}
