<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Shifts;
use DB;
use App\Models\Teams;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allRoles = Role::all();
        $totalusers = User::count();
        $users = User::paginate(10);
        $charaterstic = 'Active';
        $allshifts = Shifts::latest()->get();
        return view('users.index',compact(['allRoles','totalusers','users','charaterstic','allshifts']));
    }
    public function inactiveusers()
    {
        $allRoles = Role::all();
        $totalusers = User::onlyTrashed()->count();
        $users = User::onlyTrashed()->paginate(10);
        $charaterstic = 'In-Active';
        return view('users.index',compact(['allRoles','totalusers','users','charaterstic']));
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
            'email' => 'required|email|unique:users'
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as a user!'
        ]);
        $inputs = $request->all();
        $inputs['password']= Hash::make('123456789');
        $createuser = User::create(['name'=>$inputs['name'],'email'=>$inputs['email'],'password'=>$inputs['password'],'phone'=>$inputs['phone']]);
        $createuser->assignRole($inputs['role']);
        $createuser->setMeta('gender',$inputs['gender']);
        
        $createuser->setMeta('shift',$inputs['shift']);
        $createuser->setMeta('shift_name', Shifts::where('id',$inputs['shift'])->pluck('name')->first()." (".Shifts::where('id',$inputs['shift'])->pluck('timing')->first().")");
        $createuser->setMeta('joining',$inputs['joining']);
        if(!isset($inputs['probation']))
        {
            $employmentstatus = 'Permanent';
        }
        else{
            $employmentstatus = 'Probation';
        }
        $createuser->setMeta('employment_status',$employmentstatus);
        $successmessage = "User created successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function addClient(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone'=>'required|unique:users'
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as a user!',
            'phone.unique' => 'Phone already registered as a user!',
            'phone.required' => 'Phone field is required.'
        ]);
        $inputs = $request->all();
        $inputs['password']= Hash::make('123456789');
        $createuser = User::create($inputs);
        $createuser->assignRole('client');
        $successmessage = "Client created successfully!";
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teams = DB::table('teams_user')->where('user_id',$id)->get();
        $reportingauthority = array();
        foreach($teams as $thisteam)
        {
            $leader = Teams::where('id','=',$thisteam->teams_id)->with('getLeader')->first();
            $user = User::find($leader->getLeader->id);
            array_push($reportingauthority,$user);
        }
        $admin = User::whereHas(
            'roles', function($q){
                $q->where('name', 'admin');
            }
        )->get();
        if($reportingauthority == NULL)
        {
            foreach($admin as $thisadmin)
            {
                array_push($reportingauthority,$thisadmin);
            }
        }
        $userdata = User::where('id',$id)->first();
        $allshifts = Shifts::latest()->get();
        return view('users.show',compact(['userdata','reportingauthority','allshifts']));
    }
    public function changepassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $updateprofile = User::find($request->id);
        #Match The Old Password

        if(!Hash::check($request->old_password,$updateprofile->password)){
            return Redirect::back()->withErrors(['msg' => "The Old Password Doesn't match!"]);
        }
        #Update the new Password
        User::whereId($request->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return Redirect::back()->with("success", "Password changed successfully!");
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
        
        $updateprofile = User::find($request->id);
        if($request->image == NULL)
        {   
            $updateprofile->update(['name' => $request->name,'phone'=>$request->phone ]);  
        }
        else{
            
            $imageName = 'user/'.time().'-'.$request->name.'.'.$request->image->extension();
            $request->image->move(public_path('images/user'), $imageName);
            User::whereId($request->id)->update([
                'name' => $request->name,'image' => $imageName,'phone'=>$request->phone
            ]);
        }
        $updateprofile->setMeta('joining', $request->joining);
        $updateprofile->setMeta('shift', $request->shift);
        $updateprofile->setMeta('shift_name', Shifts::where('id',$request->shift)->pluck('name')->first()." (".Shifts::where('id',$request->shift)->pluck('timing')->first().")");
        $updateprofile->setMeta('gender', $request->gender);
        if(!isset($request->probation))
        {
            $employmentstatus = 'Permanent';
        }
        else{
            $employmentstatus = 'Probation';
        }
        $updateprofile->setMeta('employment_status', $employmentstatus);
        $successmessage = "Profile updated successfully!";
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
        $user=User::find($request->id);
        $user->delete();
        return 'success';
    }
    public function activateUser(Request $request)
    {
        User::where('id', $request->id)->withTrashed()->restore();
        return 'success';
    }
    public function rolesandpermissions($id)
    {
        $userdata = User::find($id);
        $allroles = Role::all();
        $allperms = Permission::all();
        return view('users.rolesandpermission',compact(['userdata','allroles','allperms']));
    }
    public function assignRoletoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->assignRole($request->role);
        $successmessage = "Role assigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignRoletoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->removeRole($request->role);
        $successmessage = "Role unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function assignPermtoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->givePermissionto($request->perm);
        $successmessage = "Permission assigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignPermtoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->revokePermissionto($request->perm);
        $successmessage = "Permission unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    
}
