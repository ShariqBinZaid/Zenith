<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        $totalcompanies = Company::count();
        $admins = User::whereHas(
            'roles', function($q){
                $q->where('name', 'admin');
            }
        )->get();
        return view('settings.companies',compact(['companies','totalcompanies','admins']));
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
            'owner' => 'required',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'desc' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            'owner.required' => 'Company Owner is required.',
            'logo.required' => 'Company Logo required!',
            'desc.required' => 'Company Description is required'
        ]);
      
        $companyimage = 'company/'.time().'-'.$request->name.'.'.$request->logo->extension();  
       
        $request->logo->move(public_path('images/company'), $companyimage);
        $companyobj = new Company();
        $companyobj->name = $request->name;
        
        $companyobj->logo = $companyimage;
        
        $companyobj->desc = $request->desc;
        
        $companyobj->owner = $request->owner;

        $companyobj->save();
        $successmessage = "Company saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            // 'logo' => 'required',
            'owner' => 'required',
            'desc' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            // 'logo.required' => 'Logo field is required.',
            'owner.required' => 'Owner field is required.',
            'desc.required' => 'Description already registered!',
        ]);
        $companyupdate = Company::find($request->id);
        $companyupdate->update(['name' => $request->name, 'logo' => $request->logo, 'owner' => $request->owner, 'desc' => $request->desc]);
        $successmessage = "Company updated successfully!";
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $unit = Company::find($request->id);
        $unit->delete();
        return 'success';
    }
}
