<?php

namespace App\Http\Controllers;

use App\Models\FleetMaintainance;
use App\Models\Fleet;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Redirect;
class FleetMaintainanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fleetmaintainances = FleetMaintainance::latest()->paginate(15);
        return view('fleet.maintainances', compact(['fleetmaintainances']));
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
        $inputs = $request->all();
        $fleetmaintainance = new FleetMaintainance();
        $fleetmaintainance->user_id = Auth::user()->id;
        $fleetmaintainance->fleet_id = $request->id;
        $fleetmaintainance->reason = $request->reason;
        $fleetmaintainance->company_id = Auth::user()->company_id;
        $fleetmaintainance->save();
        $successmessage = "Fleet Maintainance Requested Successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FleetMaintainance  $fleetMaintainance
     * @return \Illuminate\Http\Response
     */
    public function show(FleetMaintainance $fleetMaintainance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FleetMaintainance  $fleetMaintainance
     * @return \Illuminate\Http\Response
     */
    public function edit(FleetMaintainance $fleetMaintainance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FleetMaintainance  $fleetMaintainance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FleetMaintainance $fleetMaintainance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FleetMaintainance  $fleetMaintainance
     * @return \Illuminate\Http\Response
     */
    public function destroy(FleetMaintainance $fleetMaintainance)
    {
        //
    }
}
