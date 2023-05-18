<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;
<<<<<<< Updated upstream
use Auth;
use Illuminate\Support\Facades\Redirect;
=======

>>>>>>> Stashed changes
class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
<<<<<<< Updated upstream
        $departments = Departments::where('company_id',Auth::user()->company_id)->paginate(10);
        return view('settings.departments',compact(['departments']));
=======
        //
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
        $validatedData = $request->validate([
            'name' => 'required',
            'desc'=>'required'
        ], [
            'name.required' => 'Department Name is required.',
            'desc.required' => 'Description is required.',
        ]);
        $departobj = new Departments();
        $departobj->name = $request->name;
        $departobj->company_id = Auth::user()->company_id;
        $departobj->desc = $request->desc;
        $departobj->save();
        $successmessage = "Department created successfully!";
        return Redirect::back()->with('success',$successmessage);
        
=======
        //
>>>>>>> Stashed changes
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function show(Departments $departments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function edit(Departments $departments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
<<<<<<< Updated upstream
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'desc'=>'required'
        ], [
            'name.required' => 'Department Name is required.',
            'desc.required'=>'Department Description required'
        ]);
        $departupdate = Departments::find($request->id);
        $departupdate->update(['name' => $request->name,'desc'=>$request->desc]);
        $successmessage = "Department updated successfully!";
        return Redirect::back()->with('success',$successmessage);
=======
    public function update(Request $request, Departments $departments)
    {
        //
>>>>>>> Stashed changes
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
<<<<<<< Updated upstream
    public function destroy(Request $request)
    {
        $department=Departments::find($request->id);
        $department->delete();
        return 'success';
=======
    public function destroy(Departments $departments)
    {
        //
>>>>>>> Stashed changes
    }
}
