<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $allpermissions = Permission::latest();
        $totalpermissions = Permission::count();
        
        if ($search) {
            $allpermissions->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $allpermissions = $allpermissions->get();
        
        return view('settings.permissions',compact(['allpermissions','totalpermissions','search']));
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
            'name' => 'required'
        ], [
            'name.required' => 'Name field is required.'
        ]);
        Permission::create(['name'=>$request->name,'guard_name'=>'api']);
        $successmessage = "Permission saved successfully!";
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
            'name' => 'required'
        ], [
            'name.required' => 'Name field is required.'
        ]);
        $updateperm = Permission::find($request->id);
        $updateperm->update(['name'=>$request->name]);
        $successmessage = "Permission saved successfully!";
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
        $permission=Permission::find($request->id);
        $permission->delete();
        return 'success';
    }
    public function unassignrole(Request $request)
    {
        $roledata = Permission::find($request->id);
        $roledata->removeRole($request->role);
        $successmessage = "Role unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function showroles($id)
    {
        $permissiondata = Permission::find($id);
        $allroles = Role::all();
        return view('settings.assign-roles',compact(['permissiondata','allroles']));
    }
    public function assignrole(Request $request)
    {
        $roledata = Permission::find($request->id);
        $roledata->assignRole($request->role);
        $successmessage = "Role assigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
}
