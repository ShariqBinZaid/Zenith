<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Teams;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportingauthority = 0;
        $id = Auth::user()->id;
        $userdata = User::where('id',$id)->first();
        if($userdata->roles->pluck('name')[0] == 'admin')
        {
            $reportingauthority = NULL;
        }
        elseif($userdata->roles->pluck('name')[0] == 'superadmin')
        {
            $reportingauthority = NULL;
        }
        elseif($userdata->roles->pluck('name')[0] == 'business_unit_head')
        {
            $reportingauthority = User::find($userdata->getCompany->owner);;
        }
        else{
            if($userdata->is_leader == 1)
            {
                $reportingauthority = User::find($userdata->getUnit->unithead);
            }
            else{
                $reportingauthority = User::find($userdata->getTeam->leader);
            }
        }
        if($userdata->roles->pluck('name')[0] == 'superadmin' || $userdata->roles->pluck('name')[0] == 'admin' || $userdata->roles->pluck('name')[0] == 'business_unit_head')
        {
            $unithead = NULL;
        }
        else{
            
            $unithead = User::find($userdata->getUnit->unithead);
        }
        return view('profile.index',compact('reportingauthority','unithead','userdata'));
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
        //
    }
    public function changepassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $updateprofile = User::find(auth()->user()->id);
        #Match The Old Password

        if(!Hash::check($request->old_password,$updateprofile->password)){
            return Redirect::back()->withErrors(['msg' => "The Old Password Doesn't match!"]);
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return Redirect::back()->with("success", "Password changed successfully!");
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
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ], [
            'name.required' => 'Name field is required.'
        ]);
        $updateprofile = User::find(Auth::user()->id);
        if($request->image == NULL)
        {   
            $updateprofile->update(['name' => $request->name,'phone'=>$request->phone ]);  
        }
        else{
            
            $imageName = 'user/'.time().'-'.$request->name.'.'.$request->image->extension();
            $request->image->move(public_path('images/user'), $imageName);
            User::whereId(Auth::user()->id)->update([
                'name' => $request->name,'image' => $imageName,'phone'=>$request->phone
            ]);
        }
        $updateprofile->setMeta('gender',$request->gender);
        $successmessage = "Profile updated successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
