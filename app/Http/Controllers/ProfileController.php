<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Teams;
use App\Models\Passwords;
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
        $userdata = User::where('id', $id)->first();
        if ($userdata->roles->pluck('name')[0] == 'admin' || $userdata->roles->pluck('name')[0] == 'superadmin') {
            $reportingauthority = NULL;
        } elseif ($userdata->roles->pluck('name')[0] == 'human_resource_manager' || ($userdata->is_leader == 0 && $userdata->team_id == 0)  || $userdata->roles->pluck('name')[0] == 'sales_head' ) {
            $reportingauthority = User::find($userdata->getCompany->owner);
        }
        elseif($userdata->roles->pluck('name')[0] == 'business_unit_head')
        {
            $reportingauthority = User::where('company_id',$userdata->company_id)->whereHas(
                'roles',
                function ($q) {
                    $q->where('name', 'sales_head');
                }
            )->first();
        }
        else {
            if ($userdata->is_leader == 1) {
                if($userdata->unit_id == 0)
                {
                    $reportingauthority = User::find($userdata->getCompany->owner);
                }else{
                    $reportingauthority = User::find($userdata->getUnit->unithead);
                }
            } else {
                $reportingauthority = User::find($userdata->getTeam->leader);
            }
        }
        if ($userdata->roles->pluck('name')[0] == 'superadmin' ) {
            $unithead = NULL;
        } else {
            if($userdata->unit_id == 0)
            {
                $unithead = NULL;
            }else{
                $unithead = User::find($userdata->getUnit->unithead);
            }
            
        }
        return view('profile.index', compact('reportingauthority', 'unithead', 'userdata'));
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

        if (!Hash::check($request->old_password, $updateprofile->password)) {
            return Redirect::back()->withErrors(['msg' => "The Old Password Doesn't match!"]);
        }
        $passwordobj = new Passwords;
        $passwordobj->user_id = auth()->user()->id;
        $passwordobj->password = $request->new_password;
        $passwordobj->save();
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
        if ($request->image == NULL) {
            $updateprofile->update(['name' => $request->name, 'phone' => $request->phone]);
        } else {

            $imageName = 'user/' . time() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move('images/user', $imageName);
            User::whereId(Auth::user()->id)->update([
                'name' => $request->name, 'image' => $imageName, 'phone' => $request->phone
            ]);
        }
        $successmessage = "Profile updated successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    public function additionalData(Request $request)
    {
        $updateprofile = User::find(Auth::user()->id);
        $updateprofile->setMeta('cnic', $request->cnic);
        $updateprofile->setMeta('gender', $request->gender);
        $updateprofile->setMeta('address', $request->address);
        $updateprofile->setMeta('dob', $request->dob);
        $updateprofile->setMeta('religion', $request->religion);
        $updateprofile->setMeta('emergency_name', $request->emergency_name);
        $updateprofile->setMeta('emergency_name_2', $request->emergency_name_2);
        $updateprofile->setMeta('emergency_number', $request->emergency_number);
        $updateprofile->setMeta('emergency_number_2', $request->emergency_number_2);
        $updateprofile->setMeta('emergency_relation', $request->emergency_relation);
        $updateprofile->setMeta('emergency_relation_2', $request->emergency_relation_2);
        $updateprofile->setMeta('marital', $request->marital);
        $updateprofile->setMeta('job_type', $request->job_type);
        $updateprofile->setMeta('comorbidities', $request->comorbidities);
        $updateprofile->setMeta('degree', $request->degree);
        $updateprofile->setMeta('institute_name', $request->institute_name);
        $updateprofile->setMeta('institute_from', $request->institute_from);
        $updateprofile->setMeta('institute_to', $request->institute_to);
        if($request->drvl_front != NULL)
        {
            $drvl_front = 'driving_license/' . time() . '-' . Auth::user()->id . '-drivinglicence-front.' . $request->drvl_front->extension();
            $request->drvl_front->move('images/driving_license', $drvl_front);
            $updateprofile->setMeta('drivinglicence_front',$drvl_front);
        }
        if($request->drvl_back != NULL)
        {
            $drvl_back = 'driving_license/' . time() . '-' . Auth::user()->id . '-drivinglicence-back.' . $request->drvl_back->extension();
            $request->drvl_back->move('images/driving_license', $drvl_back);
            $updateprofile->setMeta('drivinglicence_back',$drvl_back);
        }
        $successmessage = "Profile updated successfully!";
        return Redirect::back()->with('success', $successmessage);
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