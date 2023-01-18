<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Opportunity;
use App\Models\Brands;
use App\Models\User;
use App\Models\Packages;
class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $opportunities = Opportunity::latest()->with('getBrand')->with('getPackage')->paginate(10);
        $brandspackages = Brands::latest()->with('packages.getCurrency')->get();
        return view('opportunities.index',compact(['opportunities','brandspackages']));
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
            'email' => 'required|email|unique:opportunity',
            'phone' => 'required|unique:opportunity',
            'package_id'=>'required'
        ], [
            'username.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as an opportunity!',
            'phone.required' => 'Phone field is required.',
            'phone.unique' => 'Phone Number already registered as an opportunity!',
            'package_id.required'=>'Select Package'
        ]);
        $inputs = $request->all();
        $inputs['url']= "www.google.com";
        $brand_id = Packages::where('id',$request->package_id)->pluck('brand_id')->first();
        $inputs['brand_id']= $brand_id;
        Opportunity::create($inputs);
        $successmessage = "Opportunity saved successfully!";
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
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'package_id' => 'required'
        ], [
            'username.required' => 'Name field is required.',
            'package_id' => 'Select Package'
        ]);
        $opportunityupdate = Opportunity::find($request->id);
        $brand_id = Packages::where('id',$request->package_id)->pluck('brand_id')->first();
        $opportunityupdate->update(['username' => $request->username , 'brand_id' => $brand_id ,'package_id' => $request->package_id]);
        $successmessage = "Opportunity updated successfully!";
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
        $opportunity=Opportunity::find($request->id);
        $opportunity->delete();
        return 'success';
    }
    public function assignOpportunity($id)
    {
        $opportunity = Opportunity::find($id);
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'business_unit_head');
                $q->orWhere('name', 'front_sales_manager');
                $q->orWhere('name', 'support_manager');
                $q->orWhere('name', 'support_agent');
            }
        )->get();
        return view('opportunities.assign_opportunity',compact(['opportunity','users']));
    }
    public function assignOpportunitySubmit(Request $request)
    {
        $opportunity = Opportunity::find($request->opportunity_id);
        if($opportunity->users->contains($request->user_id))
        {
            $successmessage = "Opportunity already assigned to this user!";
        }else{
            $opportunity->users()->attach($request->user_id);
            $successmessage = "Opportunity assigned successfully!";
        }
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignOpportunitySubmit(Request $request)
    {
        $opportunity = Opportunity::find($request->opportunity_id);
        $opportunity->users()->detach($request->user_id);
        $successmessage = "Opportunity unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
}
