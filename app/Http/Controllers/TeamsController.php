<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brands;

use Auth;
use Illuminate\Support\Facades\Redirect;
class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Teams::latest()->with('getLeader')->get();
        $totalteams = Teams::count();
        $leaders = User::whereDoesntHave(
            'roles', function($q){
                $q->where('name', 'admin');
            }
        )->get();
        return view('settings.teams',compact(['teams','totalteams','leaders']));
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
            'leader' => 'required'
        ], [
            'name.required' => 'Name is required.',
            'leader.required' => 'Team Leader is required.'
        ]);
        $input = $request->all();
        Teams::create($input);
        $successmessage = "Team created successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teamdetails = Teams::find($id);
        return view('teams.index',compact(['teamdetails']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teamdata = Teams::find($id);
        $allmembers = User::whereDoesntHave(
            'roles', function($q){
                $q->where('name', 'admin');
                $q->orWhere('name', 'business_unit_head');
            }
        )->get();
        return view('settings.assign-team-members',compact(['teamdata','allmembers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teams $teams)
    {
        //
    }
    public function assignTeamMember(Request $request)
    {
        $team = Teams::find($request->team_id);
        if($team->users->contains($request->user_id))
        {
            $successmessage = "Team Member already present!";
        }else{
            $team->users()->attach($request->user_id);
            $successmessage = "Team Member added successfully!";
        }
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignTeamMember(Request $request)
    {
        $team = Teams::find($request->team_id);
        $team->users()->detach($request->user_id);
        $successmessage = "Team Member removed successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function assignBrandtoTeam($id)
    {
        $team = Teams::find($id);
        $brands = Brands::latest()->get();
        return view('settings.assign-brand-team',compact(['team','brands']));
    }
    public function assignBrandSubmit(Request $request)
    {
        $team = Teams::find($request->team_id);
        if($team->brands->contains($request->user_id))
        {
            $successmessage = "Brand already assigned!";
        }else{
            $team->brands()->attach($request->user_id);
            $successmessage = "Brand Assigned successfully!";
        }
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignBrandSubmit(Request $request)
    {
        $team = Teams::find($request->team_id);
        $team->brands()->detach($request->brand_id);
        $successmessage = "Brand Unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teams  $teams
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $team=Teams::find($request->id);
        $team->delete();
        return 'success';
    }
}
