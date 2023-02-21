<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Units;
use App\Models\Company;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        $unitheads = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'business_unit_head');
            }
        )->get();
        $totalunits = Units::count();
        $units = Units::all();
        return view('settings.units', compact(['companies', 'unitheads', 'totalunits', 'units']));
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
            'company_id' => 'required',
            'unithead' => 'required|unique:units',
            'desc' => 'nullable'
        ], [
            'name.required' => 'Name field is required.',
            'company_id.required' => 'Select Company',
            'unithead.required' => 'Select Unit Head',
            'unithead.unique' => 'Unit Head already having a unit.'
        ]);
        Units::create($request->all());
        $successmessage = "Lead saved successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function show(Units $units)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function edit(Units $units)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'company_id' => 'required',
            'unithead' => 'required',
            'desc' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            'company_id.required' => 'Company field is required.',
            'unithead.required' => 'Unit Head field is required.',
            'desc.required' => 'Description already registered!',
        ]);
        $unitupdate = Units::find($request->id);
        $unitupdate->update(['name' => $request->name, 'company_id' => $request->company_id, 'unithead' => $request->unithead, 'desc' => $request->desc]);
        $successmessage = "Unit updated successfully!";
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function destroy(Units $units)
    {
        $unit = Units::find($request->id);
        $unit->delete();
        return 'success';
    }
}
