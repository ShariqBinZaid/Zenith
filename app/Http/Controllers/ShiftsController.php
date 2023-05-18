<?php

namespace App\Http\Controllers;

use App\Models\Shifts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;



class ShiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $shifts = Shifts::where('company_id',Auth::user()->company_id)->latest();
        
        if ($search) {
            $shifts->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->Orwhere('timing', 'like', '%' . $search . '%');
            });
        }

        $shifts = $shifts->paginate(10);
        
        return view('shifts.index',compact(['shifts']));
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
            'starting_hours'=>'required',
            'ending_hours'=>'required'
        ], [
            'name.required' => 'Department Name is required.',
            'starting_hours.required' => 'Starting Hours is required.',
            'ending_hours.required' => 'Ending Hours is required.'
        ]);
        $start_time = strtotime($request->starting_hours . ':00');
        $end_time = strtotime($request->ending_hours . ':00');
        $difference = ($end_time - $start_time) / 3600;
        $shiftsobj = new Shifts();
        $shiftsobj->name = $request->name;
        $shiftsobj->starting_hours = $request->starting_hours;
        $shiftsobj->ending_hours = $request->ending_hours;
        $shiftsobj->shift_hours = $difference;
        $shiftsobj->timing = date('h:i A',$start_time) ."-". date('h:i A',$end_time);
        $shiftsobj->company_id = Auth::user()->company_id;
        $shiftsobj->save();
        $successmessage = "Shifts created successfully!";
        return Redirect::back()->with('success',$successmessage);
        
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
        $validatedData = $request->validate([
            'name' => 'required',
            'timing' => 'required',
            'starting_hours'=>'required',
            'ending_hours'=>'required',
            'shift_hours'=>'required'
        ], [
            'name.required' => 'Department Name is required.',
            'timing.required' => 'Timing is required.',
            'starting_hours.required' => 'Starting Hours is required.',
            'ending_hours.required' => 'Ending Hours is required.',
            'shift_hours.required' => 'Shift Hours is required.'
        ]);
        $shiftsupdate = Shifts::find($request->id);
        $shiftsupdate->update(['name' => $request->name,'timing'=>$request->timing,'starting_hours'=>$request->starting_hours,'ending_hours'=>$request->ending_hours,'shift_hours'=>$request->shift_hours,]);
        $successmessage = "Shifts updated successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $shifts=Shifts::find($request->id);
        $shifts->delete();
        return 'success';
    }
}
