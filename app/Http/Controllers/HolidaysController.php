<?php

namespace App\Http\Controllers;

use App\Models\Holidays;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Auth;
class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $holidays = Holidays::latest();
        // $totalholidays = Holidays::count();
        
        if ($search) {
            $holidays->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('holiday_date', 'like', '%' . $search . '%');
            });
        }

        $holidays = $holidays->paginate(15);
        
        return view('settings.holidays',compact(['holidays','search']));
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
            'holiday_date'=>strtotime($input['holiday_date']),
            'company_id'=>Auth::user()->company_id
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
        $holidays = Holidays::find($input['id']);
        $holidays->update([
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
        $holidays = Holidays::find($request->id);
        $holidays->delete();
        return 'success';
    }
    
}
