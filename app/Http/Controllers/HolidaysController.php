<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays = Holidays::all();
        $totalholidays = Holidays::count();
        return view('settings.holidays',compact(['holidays','totalholidays']));
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
            'holiday_date' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'holiday_date.required' => "Holiday's date field is required."
        ]);
        $input = $request->all();
        Holidays::create([
            'name'=>$input['name'],
            'holiday_date'=>strtotime($input['holiday_date'])
        ]);
        $successmessage = "Holiday saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holidays  $holidays
     * @return \Illuminate\Http\Response
     */
    public function show(Holidays $holidays)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holidays  $holidays
     * @return \Illuminate\Http\Response
     */
    public function edit(Holidays $holidays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holidays  $holidays
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'holiday_date' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'holiday_date.required' => "Holiday's date field is required."
        ]);
        $input = $request->all();
        $holiday = Holidays::find($input['id']);
        $holiday->update([
            'name'=>$input['name'],
            'holiday_date'=>strtotime($input['holiday_date'])
        ]);
        $successmessage = "success";
        return $successmessage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holidays  $holidays
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $holiday=Holidays::find($request->id);
        $holiday->delete();
        return 'success';
    }
}
