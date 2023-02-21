<?php

namespace App\Http\Controllers;

use App\Models\LeaveTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LeaveTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leavetypes = LeaveTypes::all();
        $totalleavetypes = LeaveTypes::count();
        return view('settings.leave_types',compact(['leavetypes','totalleavetypes']));
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
            'name' => 'required',
            'days' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'days.required' => "Days field is required."
        ]);
        $input = $request->all();
        LeaveTypes::create([
            'name'=>$input['name'],
            'days'=>$input['days'],
            'company_id'=>auth()->user()->company_id
        ]);
        $successmessage = "Leave Type saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveTypes $leaveTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveTypes $leaveTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'days' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'days.required' => "Holiday's date field is required."
        ]);
        $input = $request->all();
        $leavetype = LeaveTypes::find($input['id']);
        $leavetype->update([
            'name'=>$input['name'],
            'days'=>$input['days']
        ]);
        $successmessage = "success";
        return $successmessage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveTypes  $leaveTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $leavetype=LeaveTypes::find($request->id);
        $leavetype->delete();
        return 'success';
    }
}
