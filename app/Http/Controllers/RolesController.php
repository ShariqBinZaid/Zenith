<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allroles = Role::get();
        $totalroles = Role::count();
        return view('settings.roles',compact(['allroles','totalroles']));
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
        Role::create(['name'=>$request->name,'guard_name'=>'api']);
        $successmessage = "Roles saved successfully!";
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
        $updaterole = Role::find($request->id);
        $updaterole->update(['name'=>$request->name]);
        $successmessage = "Roles saved successfully!";
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
        $roles=Role::find($request->id);
        $roles->delete();
        return 'success';
    }
    public function showpermissions($id)
    {
        $roledata = Role::find($id);
        $allpermissions = Permission::all();
        return view('settings.assign-permission',compact(['roledata','allpermissions']));
    }
    public function assignpermission(Request $request)
    {
        $roledata = Role::find($request->id);
        $roledata->givePermissionTo($request->permission);
        $successmessage = "Permission assigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignpermission(Request $request)
    {
        $roledata = Role::find($request->id);
        $roledata->revokePermissionTo($request->permission);
        $successmessage = "Permission unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
}
