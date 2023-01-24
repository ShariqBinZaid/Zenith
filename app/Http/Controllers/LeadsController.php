<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\User;
use App\Models\Brands;
use App\Models\Teams;
Use Exception;
use Auth;
use Illuminate\Support\Facades\Redirect;
class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->roles->pluck('name')[0] == 'admin')
        {
            $leads = Leads::latest()->with('getBrand')->paginate(10);
        }
        else if(Auth::user()->roles->pluck('name')[0] == 'business_unit_head'){
            $teamid = Teams::where('leader',Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach($teamid->brands as $thisbrand)
            {
                array_push($brands,$thisbrand->id);
            }
            $leads = Leads::whereIn('brand_id', $brands)->paginate(10);
        }
        else{
            $user = auth()->user();
            $leads =Leads::whereHas('users', function ($query) use ($user) {
                $query->where('leads_user.user_id', '=', $user->id);
            })->paginate(10);
        }
        
        $allbrands = Brands::orderBy('created_at','desc')->get();
        $totalleads = Leads::count();
        return view('leads.index',compact(['leads','totalleads','allbrands']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'username' => 'required',
            'email' => 'required|email|unique:leads',
            'phone' => 'required|unique:leads',
            'brand_id' => 'required'
        ], [
            'username.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as a lead!',
            'phone.required' => 'Phone field is required.',
            'brand_id.required' => 'Select Brand',
            'phone.unique' => 'Phone already registered as a lead!'
        ]);
        $inputs = $request->all();
        $inputs['url']= "www.google.com";
        Leads::create($inputs);
        $successmessage = "Lead saved successfully!";
        return Redirect::back()->with('success',$successmessage);
        /*try {
            Leads::create($inputs);
            $successmessage = "Lead saved successfully!";
            return Redirect::back()->with('success',$successmessage);
        } catch(\Illuminate\Database\QueryException $ex){ 
            $errormessage = $ex->errorInfo[2];
            return Redirect::back()->with('errordb',['message'=>$errormessage])->withInput();
        }*/
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
    public function assignLead($id)
    {
        $lead = Leads::find($id);
        if(Auth::user()->roles->pluck('name')[0] == 'admin')
        {
            $users = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'business_unit_head');
                    $q->orWhere('name', 'front_sales_manager');
                    $q->orWhere('name', 'front_sales_executive');
                }
            )->get();
        }
        else if(Auth::user()->roles->pluck('name')[0] == 'business_unit_head'){
            $users = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'front_sales_manager');
                    $q->orWhere('name', 'front_sales_executive');
                }
            )->whereHas(
                'teams', function($q){
                    $q->where('leader', Auth::user()->id);
                }
            )->get();
        }
        else{
            $userdata = User::where('id',Auth::user()->id)->with('teams')->first();
            $users = User::whereHas(
                'roles', function($q){
                    $q->where('name', 'front_sales_executive');
                })->
                whereHas(
                'teams.users', function($q) use($userdata){
                    $q->where('teams_id', 2);
                    foreach($userdata->teams as $thisteam)
                    {
                        if($thisteam->count == 1)
                        {
                            $q->where('teams_id', $thisteam->id);
                        }else{
                            $q->orWhere('teams_id', $thisteam->id);
                        }
                    }
                })->get();
        }
        return view('leads.assign_lead',compact(['lead','users']));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'brand_id' => 'required'
        ], [
            'username.required' => 'Name field is required.',
            'brand_id.required' => 'Select Brand',
        ]);
        $leadsupdate = Leads::find($request->id);
        $leadsupdate->update(['username' => $request->username , 'brand_id' => $request->brand_id]);
        $successmessage = "Lead updated successfully!";
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $lead=Leads::find($request->id);
        $lead->delete();
        return 'success';
    }
    public function assignLeadSubmit(Request $request)
    {
        $lead = Leads::find($request->leads_id);
        if($lead->users->contains($request->user_id))
        {
            $successmessage = "Lead already assigned to this user!";
        }else{
            $lead->users()->attach($request->user_id);
            $successmessage = "Lead assigned successfully!";
        }
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignLeadSubmit(Request $request)
    {
        $lead = Leads::find($request->leads_id);
        $lead->users()->detach($request->user_id);
        $successmessage = "Lead unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
}
