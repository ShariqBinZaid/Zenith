<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\User;
use App\Models\Brands;
Use Exception;
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
        $leads = Leads::orderBy('created_at','desc')->with('getBrand')->paginate(10);
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
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'business_unit_head');
                $q->orWhere('name', 'front_sales_manager');
                $q->orWhere('name', 'support_manager');
                $q->orWhere('name', 'support_agent');
            }
        )->get();
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
        $lead->users()->attach($request->user_id);
        $successmessage = "Lead assigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    
}
