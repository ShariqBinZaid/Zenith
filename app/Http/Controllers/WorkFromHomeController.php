<?php

namespace App\Http\Controllers;

use App\Models\WorkFromHome;
use Illuminate\Http\Request;
use Redirect;
use Auth;

class WorkFromHomeController extends Controller
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
            $workformhome = WorkFromHome::where('company_id',Auth::user()->company_id)->latest();
        }else{
            $workformhome = WorkFromHome::where(['company_id'=>Auth::user()->company_id,'user_id'=>Auth::user()->id])->latest();
        }
        if ($status) {
            $workformhome->where('status', $status);
        }
        else {
            $workformhome->where('status', 'pending');
        }
        $workformhome = $workformhome->paginate(15);
        
        return view('workfromhome.show', compact(['workformhome','status']));
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
        $workfromhome = WorkFromHome::create([
            'desc'=>$input['desc'],
            'user_id'=>Auth::user()->id,
            'company_id'=>Auth::user()->company_id,
            'date'=> $input['date']
            
            // 'date' => $input['date'] ?? date('Y-m-d'), // use current date if $input['date'] is null
        ]);
        
        $successmessage = "Work From Home saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkFromHome  $workFromHome
     * @return \Illuminate\Http\Response
     */
    public function show(WorkFromHome $workFromHome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkFromHome  $workFromHome
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkFromHome $workFromHome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkFromHome  $workFromHome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkFromHome $workFromHome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkFromHome  $workFromHome
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkFromHome $workFromHome)
    {
        //
    }
    
    public function approveWorkFromHome(Request $request)
    {
        $workfromhome = WorkFromHome::find($request->id);
        $workfromhome->update(['status' => 'approved']);
    }
    
    public function rejectWorkFromHome(Request $request)
    {
        $workfromhome = WorkFromHome::find($request->id);
        $workfromhome->update(['status' => 'rejected']);
    }
}
