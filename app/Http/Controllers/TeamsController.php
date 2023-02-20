<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brands;
use App\Models\Units;
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
                $q->where('name','admin');
                $q->Orwhere('name','superadmin');
                $q->Orwhere('name','business_unit_head');
            }
        )->get();
        $units = Units::all();
        return view('settings.teams',compact(['teams','totalteams','leaders','units']));
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
        $input['company_id'] = Units::where('id',$request->unit_id)->pluck('company_id')->first();
        $team = Teams::create($input);
        User::where('id',$request->leader)->update(['is_leader'=>'1','team_id'=>$team->id]);
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
        )->where(['unit_id'=>$teamdata->unit_id])->where('is_leader','0')->where('team_id',NULL)->get();
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
        if(User::where(['id'=>$request->user_id,'team_id'=>$request->team_id])->count() > 0){
            $successmessage = "Team Member already present!";
        }
        else{
            User::where('id',$request->user_id)->update(['team_id'=>$request->team_id]);
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
        $brands = Brands::where('unit_id',$team->unit_id)->latest()->get();
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
        foreach($team->users as $thisuser)
        {
            User::where('id',$thisuser->id)->update(['team_id'=>NULL]);
        }
        User::where('id',$team->leader)->update(['is_leader'=>'0','team_id'=>NULL]);
        $team->delete();
        return 'success';
    }
    public function team_chart($id)
    {
        $team = Teams::find($id);
        return view('teams.team_chart',compact(['team']));
    }
}
