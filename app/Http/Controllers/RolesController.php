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
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $allroles = Role::latest();
        $totalroles = Role::count();
        
        if ($search) {
            $allroles->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $allroles = $allroles->get();
        
        return view('settings.roles',compact(['allroles','totalroles','search']));
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
    
    
    // function csvToArray($filename = '', $delimiter = ',')
    // {
    //     if (!file_exists($filename) || !is_readable($filename))
    //         return false;
    
    //     $header = null;
    //     $data = array();
    //     if (($handle = fopen($filename, 'r')) !== false)
    //     {
    //         while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
    //         {
    //             if (!$header)
    //                 $header = $row;
    //             else
    //                 $data[] = array_combine($header, $row);
    //         }
    //         fclose($handle);
    //     }
    
    //     return $data;
    // }
    
    
    // public function importCsv()
    // {
    //     $file = public_path('file/shariq.csv');
    
    //     $customerArr = $this->csvToArray($file);
    //     //return $customerArr;
    //     foreach ($customerArr as  $value) {
    //         # code...
    //         return $value;
    //         return $value['Designation'];
    //         return $value['Name'];
    //     }
    
    //     return 'Jobi done or what ever';    
    // }
}
