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
        $teams = DB::table('teams_user')->where('user_id',Auth::user()->id)->get();
        $reportingauthority = array();
        $teamdata = array();
        foreach($teams as $thisteam)
        {
            $leader = Teams::where('id','=',$thisteam->teams_id)->with('getLeader')->first();
            $user = User::find($leader->getLeader->id);
            array_push($reportingauthority,$user);
            array_push($teamdata,$leader);
        }
        return view('profile.index',compact('reportingauthority','teamdata'));
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
        $updateprofile = User::find(auth()->user()->id);
        if($request->image == NULL)
        {   
            $updateprofile->update(['name' => $request->name,'phone'=>$request->phone ]); 
        }
        else{
            $imageName = 'user/'.time().'-'.$request->name.'.'.$request->image->extension();
            $request->image->move(public_path('images/user'), $imageName);
            User::whereId(auth()->user()->id)->update([
                'name' => $request->name,'image' => $imageName,'phone'=>$request->phone
            ]);
        }
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
