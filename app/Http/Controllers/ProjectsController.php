<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Projects;
use App\Models\Opportunity;
use App\Models\User;
use App\Models\Brands;
use App\Models\Packages;
use App\Models\PackageTypes;
use Auth;
class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $projects = Projects::where('status','pending')->latest()->with('getBrand')->with('getPackage')->with('getCustomer')->with('getConverter')->with('getProjectType');
        $clients = User::whereHas(
            'roles', function($q){
                $q->where('name', 'client');
            }
        )->get();
        $projecttype = PackageTypes::latest()->get();
        $brandspackages = Brands::with('packages')->get();
        
        if ($search) {
            $projects->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $projects = $projects->paginate(15);
        
        return view('projects.index',compact(['projects','clients','projecttype','brandspackages','search']));
    }

    public function convert_opportunity_to_project($id)
    {
        $opportunity = Opportunity::with('getBrand')->with('getPackage')->find($id);
        $useradded = User::create([
            'name' => $opportunity->name,
            'email' => $opportunity->email,
            'password' => bcrypt('123456789'),
            'phone'=>$opportunity->phone
        ])->assignRole('client');
        Projects::create([
            'name'=>$opportunity->getBrand->initials.'- ('.$opportunity->name.'| '.$opportunity->email.')',
            'package_id'=>$opportunity->getPackage->id,
            'customer_id'=>$useradded->id,
            'brand_id'=>$opportunity->getBrand->id,
            'desc'=>'System Created Project',
            'priority'=>'medium',
            'project_type'=>$opportunity->getPackage->package_type,
            'converted_by'=>auth()->user()->id,
            'created_from'=>'Opportunity'
        ]);
        $opportunity->delete();
        $successmessage = "Opportunity converted to Project Successfully!";
        return Redirect::back()->with('success',$successmessage);
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
            'package_id' => 'required',
            'customer_id' => 'required',
            'package_id'=>'required',
            'project_type'=>'required',
            'priority'=>'required',
            'desc'=>'required'
        ], [
            'name.required' => 'Name is required.',
            'package_id.required' => 'Package is required.',
            'customer_id.required' => 'Customer is required.',
            'package_id.required' => 'Package is required.',
            'project_type.required' => 'Package Type is required.',
            'priority.required' => 'Priority is required.',
            'desc.required' => 'Description is required.',
            'package_id.required'=>'Select Package'
        ]);
        $inputs = $request->all();
        $brand_id = Packages::where('id',$request->package_id)->pluck('brand_id')->first();
        $inputs['brand_id']= $brand_id;
        Projects::create($inputs);
        $successmessage = "Project created successfully!";
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
            'name' => 'required',
            'project_type'=>'required',
            'priority'=>'required',
            'desc'=>'required'
        ], [
            'name.required' => 'Name is required.',
            'project_type.required' => 'Package Type is required.',
            'priority.required' => 'Priority is required.',
            'desc.required' => 'Description is required.'
        ]);
        $projectupdate = Projects::find($request->id);
        $projectupdate->update([
            'name' => $request->name,
            'project_type' => $request->project_type,
            'priority' => $request->priority,
            'desc' => $request->desc,
        ]);
        $successmessage = "Package updated successfully!";
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
        $project = Projects::find($request->id);
        $project->delete();
        return 'success';
    }
}
