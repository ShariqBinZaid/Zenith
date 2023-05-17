<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Shifts;
use App\Models\Units;
use App\Models\Departments;

use DB;
use Auth;
use App\Models\Teams;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        if (Auth::user()->roles->pluck('name')[0] == 'superadmin') {
            $users = User::where('deleted_at', NULL);
            $allRoles = Role::where('name', '!=', 'superadmin')->get();
        } elseif (Auth::user()->roles->pluck('name')[0] == 'admin') {

            $users = User::whereHas(
                'roles',
                function ($q) {
                    $q->where('name', '!=', 'superadmin');
                    $q->orWhere('name', '!=', 'admin');
                }
            )->where('company_id', Auth::user()->company_id);
            $allRoles = Role::whereNotIn('name', ['superadmin', 'admin'])->get();
        } elseif (Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $users = User::where('company_id', Auth::user()->company_id);
            $allRoles = Role::whereNotIn('name', ['superadmin', 'admin', 'human_resource_manager', 'business_unit_head', 'sales_head'])->get();
        } else {
            $allRoles = Role::whereNotIn('name', ['superadmin', 'admin', 'human_resource_manager', 'business_unit_head', 'sales_head', Auth::user()->roles->pluck('name')[0]])->get();
            $users = User::where('company_id', Auth::user()->company_id);
        }
        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        $users = $users->paginate(20);
        $charaterstic = 'Active';
        $allshifts = Shifts::latest()->get();
        if (Auth::user()->roles->pluck('name')[0] == 'superadmin') {
            $units = Units::all();
        } else if (Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'human_resource_depart') {
            $units = Units::where('company_id', Auth::user()->company_id)->get();
        } else if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $units = Units::where('id', Units::where('unithead', Auth::user()->id)->pluck('id')->first())->get();
        } else {
            $units = Units::where('unithead', Auth::user()->id)->with('getCompany')->get();
        }
        if (Auth::user()->company_id == 0) {
            $departments = Departments::latest()->get();
        } else {
            $departments = Departments::where('company_id', Auth::user()->company_id)->latest()->get();
        }
        $allusers = User::where('company_id', Auth::user()->company_id)->get();
        return view('users.index', compact(['allRoles', 'users', 'charaterstic', 'allshifts', 'units', 'search', 'departments', 'allusers']));
    }
    public function inactiveusers(Request $request)
    {
        $search = $request->input('search');
        if (Auth::user()->roles->pluck('name')[0] == 'superadmin') {
            $users = User::where('deleted_at', NULL);
            $allRoles = Role::where('name', '!=', 'superadmin')->get();
        } elseif (Auth::user()->roles->pluck('name')[0] == 'admin') {

            $users = User::whereHas(
                'roles',
                function ($q) {
                    $q->where('name', '!=', 'superadmin');
                    $q->orWhere('name', '!=', 'admin');
                }
            )->where('company_id', Auth::user()->company_id);
            $allRoles = Role::whereNotIn('name', ['superadmin', 'admin'])->get();
        } elseif (Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $users = User::where('company_id', Auth::user()->company_id);
            $allRoles = Role::whereNotIn('name', ['superadmin', 'admin', 'human_resource_manager', 'business_unit_head', 'sales_head'])->get();
        } else {
            $allRoles = Role::whereNotIn('name', ['superadmin', 'admin', 'human_resource_manager', 'business_unit_head', 'sales_head', Auth::user()->roles->pluck('name')[0]])->get();
            $users = User::where('company_id', Auth::user()->company_id);
        }
        if ($search) {
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        $users = $users->onlyTrashed()->paginate(20);
        $charaterstic = 'In-Active';
        $allshifts = Shifts::latest()->get();
        if (Auth::user()->roles->pluck('name')[0] == 'superadmin') {
            $units = Units::all();
        } else if (Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'human_resource_depart') {
            $units = Units::where('company_id', Auth::user()->company_id)->get();
        } else if (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $units = Units::where('id', Units::where('unithead', Auth::user()->id)->pluck('id')->first())->get();
        } else {
            $units = Units::where('unithead', Auth::user()->id)->with('getCompany')->get();
        }
        if (Auth::user()->company_id == 0) {
            $departments = Departments::latest()->get();
        } else {
            $departments = Departments::where('company_id', Auth::user()->company_id)->latest()->get();
        }
        $allusers = User::where('company_id', Auth::user()->company_id)->get();
        return view('users.index', compact(['allRoles', 'users', 'charaterstic', 'allshifts', 'units', 'search', 'departments', 'allusers']));
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
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'unit_id' => 'required',
            'depart_id' => 'required',
            'reporting_authority' => 'required',
            'role' => 'required',
            'salary' => 'required',
            'joining' => 'required',
            'shift' => 'required',
            'gender' => 'required'

        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as a user!',
            'phone.required' => 'Phone field is required.',
            'unit_id.required' => 'Unit Required,if not affiliated to unit choose Centralized!',
            'depart_id.required' => 'Choose the Department!',
            'reporting_authority.required' => 'Choose the Reporting Authority!',
            'role.required' => 'Role is required',
            'salary.required' => 'Salary is required',
            'joining.required' => 'Joining Date is required',
            'shift.required' => 'Shift Timing is required',
            'gender.required' => 'Gender is required'
        ]);
        $inputs = $request->all();
        $inputs['password'] = Hash::make('123456789');
        if (!isset($inputs['unit_id']) || $inputs['unit_id'] == 0) {
            $company_id = Auth::user()->company_id;
            $unitid = 0;
        } else {
            $company_id = Units::where('id', $inputs['unit_id'])->pluck('company_id')->first();
            $unitid = $inputs['unit_id'];
        }
        if ($inputs['gender'] == 'male') {
            $image = 'user/man_avatar3.jpg';
        } else {
            $image = 'user/female.jpg';
        }
        $createuser = User::create(['name' => $inputs['name'], 'email' => $inputs['email'], 'password' => $inputs['password'], 'phone' => $inputs['phone'], 'unit_id' => $unitid, 'company_id' => $company_id, 'depart_id' => $inputs['depart_id'], 'team_id' => 0, 'reporting_authority' => $inputs['reporting_authority'], 'image' => $image]);
        $createuser->assignRole($inputs['role']);
        $createuser->setMeta('gender', $inputs['gender']);
        $createuser->setMeta('salary', $inputs['salary']);
        $createuser->setMeta('designation', $inputs['designation']);
        $createuser->setMeta('emp_id', $inputs['emp_id']);

        $createuser->setMeta('cnic', $inputs['cnic']);
        // $createuser->setMeta('address',$inputs['address']);
        $createuser->setMeta('shift', $inputs['shift']);
        $createuser->setMeta('shift_name', Shifts::where('id', $inputs['shift'])->pluck('name')->first() . " (" . Shifts::where('id', $inputs['shift'])->pluck('timing')->first() . ")");
        $createuser->setMeta('joining', $inputs['joining']);
        if (!isset($inputs['probation'])) {
            $employmentstatus = 'Permanent';
        } else {
            $employmentstatus = 'Probation';
        }
        $createuser->setMeta('employment_status', $employmentstatus);
        $successmessage = "User created successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function addClient(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users'
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as a user!',
            'phone.unique' => 'Phone already registered as a user!',
            'phone.required' => 'Phone field is required.'
        ]);
        $inputs = $request->all();
        $inputs['password'] = Hash::make('123456789');
        $inputs['unit_id'] = Auth::user()->unit_id;
        $inputs['company_id'] = Auth::user()->company_id;
        $createuser = User::create($inputs);
        $createuser->assignRole('client');
        $successmessage = "Client created successfully!";
        return Redirect::back()->with('success', $successmessage);
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
        $reportingauthority = 0;
        $userdata = User::where('id', $id)->first();
        if ($userdata->roles->pluck('name')[0] == 'admin' || $userdata->roles->pluck('name')[0] == 'superadmin') {
            $reportingauthority = NULL;
        } elseif ($userdata->roles->pluck('name')[0] == 'human_resource_manager' || ($userdata->is_leader == 0 && $userdata->team_id == 0) || $userdata->roles->pluck('name')[0] == 'sales_head') {
            $reportingauthority = User::find($userdata->getCompany->owner);
        } elseif ($userdata->roles->pluck('name')[0] == 'business_unit_head') {
            $reportingauthority = User::where('company_id', $userdata->company_id)->whereHas(
                'roles',
                function ($q) {
                    $q->where('name', 'sales_head');
                }
            )->first();
        } else {
            if ($userdata->unit_id == 0) {
                $reportingauthority = User::find($userdata->getCompany->owner);
            } else {
                if ($userdata->is_leader == 1) {
                    if ($userdata->unit_id == 0) {
                        $reportingauthority = User::find($userdata->getCompany->owner);
                    } else {
                        $reportingauthority = User::find($userdata->getUnit->unithead);
                    }
                } else {
                    $reportingauthority = User::find($userdata->getTeam->leader);
                }
            }
        }

        $allshifts = Shifts::latest()->get();
        if (Auth::user()->roles->pluck('name')[0] == 'superadmin') {
            $units = Units::all();
        } else if (Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'human_resource_manager') {
            $units = Units::where('company_id', Auth::user()->company_id)->get();
        } else {
            $units = Units::where('unithead', Auth::user()->id)->with('getCompany')->get();
        }
        if ($userdata->unit_id == 0) {
            $unithead = NULL;
        } else {
            $unithead = User::find($userdata->getUnit->unithead);
        }
        $allRoles = Role::where('name', '!=', 'superadmin')->get();
        if (Auth::user()->company_id == 0) {
            $departments = Departments::latest()->get();
        } else {
            $departments = Departments::where('company_id', Auth::user()->company_id)->latest()->get();
        }
        $users = User::where('company_id', Auth::user()->company_id)->get();
        return view('users.show', compact(['userdata', 'allshifts', 'units', 'reportingauthority', 'unithead', 'allRoles', 'departments', 'users']));
    }
    public function changepassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $updateprofile = User::find($request->id);
        #Match The Old Password

        if (!Hash::check($request->old_password, $updateprofile->password)) {
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

        if ($request->unit_id == NULL) {
            $unitid = 0;
        } else {
            $unitid = $request->unit_id;
        }
        if ($request->image == NULL) {
            $updateprofile->update(['name' => $request->name, 'phone' => $request->phone, 'unit_id' => $unitid, 'depart_id' => $request->depart_id, 'reporting_authority' => $request->reporting_authority]);
        } else {

            $imageName = 'user/' . time() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move('images/user', $imageName);
            User::whereId($request->id)->update(['name' => $request->name, 'image' => $imageName, 'phone' => $request->phone, 'unit_id' => $unitid, 'reporting_authority' => $request->reporting_authority]);
        }
        $updateprofile->setMeta('joining', $request->joining);
        $updateprofile->setMeta('shift', $request->shift);
        $updateprofile->setMeta('shift_name', Shifts::where('id', $request->shift)->pluck('name')->first() . " (" . Shifts::where('id', $request->shift)->pluck('timing')->first() . ")");
        $updateprofile->setMeta('gender', $request->gender);
        $updateprofile->setMeta('salary', $request->salary);
        $updateprofile->setMeta('designation', $request->designation);
        $updateprofile->setMeta('religion', $request->religion);
        $updateprofile->setMeta('dob', $request->dob);
        $updateprofile->setMeta('father_name', $request->father_name);
        $updateprofile->setMeta('emp_id', $request->emp_id);
        $updateprofile->setMeta('psuedo', $request->psuedo);
        $updateprofile->setMeta('cnic', $request->cnic);
        $updateprofile->setMeta('address', $request->address);
        $updateprofile->removeRole($updateprofile->roles[0]);
        $updateprofile->assignRole($request->role);
        if (!isset($request->probation)) {
            $employmentstatus = 'Permanent';
        } else {
            $employmentstatus = 'Probation';
        }
        $updateprofile->setMeta('employment_status', $employmentstatus);
        $successmessage = "Profile updated successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
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
        return view('users.rolesandpermission', compact(['userdata', 'allroles', 'allperms']));
    }
    public function assignRoletoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->assignRole($request->role);
        $successmessage = "Role assigned successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function unassignRoletoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->removeRole($request->role);
        $successmessage = "Role unassigned successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function assignPermtoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->givePermissionto($request->perm);
        $successmessage = "Permission assigned successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function unassignPermtoUser(Request $request)
    {
        $user = User::find($request->id);
        $user->revokePermissionto($request->perm);
        $successmessage = "Permission unassigned successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function UserCSV(Request $request)
    {
        $user = User::where('company_id', Auth::user()->company_id)->whereNotIn('id', [2, 3])->get();
        $userdata = array();
        foreach ($user as $thisuser) {
            $singleuser = [
                'id' => $thisuser->id,
                'name' => $thisuser->name,
                'email' => $thisuser->email,
                'phone' => $thisuser->phone,
                'department' => $thisuser->getDepart->name,
                'company' => $thisuser->getCompany->name,
                'reporting' => $thisuser->getReportingAuthority->name,
                'designation' => $thisuser->getMeta('designation'),
                'gender' => $thisuser->getMeta('gender'),
                'marital' => $thisuser->getMeta('marital'),
                'salary' => $thisuser->getMeta('salary'),
                'emp_id' => $thisuser->getMeta('emp_id'),
                'shift_name' => $thisuser->getMeta('shift_name'),
                'joining' => $thisuser->getMeta('joining'),
                'employment_status' => $thisuser->getMeta('employment_status'),
                'religion' => $thisuser->getMeta('religion'),
                'dob' => $thisuser->getMeta('dob'),
                'father_name' => $thisuser->getMeta('father_name'),
                'address' => $thisuser->getMeta('address'),
                'emergency_name' => $thisuser->getMeta('emergency_name'),
                'emergency_number' => $thisuser->getMeta('emergency_number'),
                'emergency_relation' => $thisuser->getMeta('emergency_relation'),
                'degree' => $thisuser->getMeta('degree'),
                'institute_name' => $thisuser->getMeta('institute_name'),
                'institute_from' => $thisuser->getMeta('institute_from'),
                'institute_to' => $thisuser->getMeta('institute_to'),
                'created_at' => $thisuser->created_at,
            ];

            array_push($userdata, $singleuser);
        }
        $headers = array("Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=Users-" . date('d-M-Y') . ".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0");
        $columns = array('ID', 'Name', 'Email', 'Phone', 'Department', 'Company', 'Reporting Authority', 'Designation', 'Gender', 'Marital', 'Salary', 'Employee Id', 'Shift', 'Joining', 'Employment Status', 'Religion', 'Date Of Birth', 'Father Name', 'Address', 'Emergency Name', 'Emergency Number', 'Emergency Relationship', 'Degree', 'Institute Name', 'Institute From', 'Institute To', 'Created At');
        $callback = function () use ($userdata, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($userdata as $row) {
                $data = array($row['id'], $row['name'], $row['email'], $row['phone'], $row['department'], $row['company'], $row['reporting'], $row['designation'], $row['gender'], $row['marital'], $row['salary'], $row['emp_id'], $row['shift_name'], $row['joining'], $row['employment_status'], $row['religion'], $row['dob'], $row['father_name'], $row['address'], $row['emergency_name'], $row['emergency_number'], $row['emergency_relation'], $row['degree'], $row['institute_name'], $row['institute_from'], $row['institute_to'], $row['created_at']);
                fputcsv($file, $data);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
