<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Units;
use App\Models\Company;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;

class UnitsController extends Controller
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
            $companies = Company::all();
            $units = Units::latest();
        } else {
            $companies = Company::where('id', Auth::user()->company_id);
            $units = Units::where('company_id', Auth::user()->company_id);
        }
        $unitheads = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'business_unit_head');
            }
        )->get();

        if ($search) {
            $units->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $units = $units->paginate(15);
        return view('settings.units', compact(['companies', 'unitheads', 'units', 'search']));
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
            'unithead' => 'required|unique:units',
            'desc' => 'nullable'
        ], [
            'name.required' => 'Name field is required.',
            'unithead.required' => 'Select Unit Head',
            'unithead.unique' => 'Unit Head already having a unit.'
        ]);
        $inputs = $request->all();
        $inputs['company_id'] = User::where('id', $request->unithead)->pluck('company_id')->first();
        Units::create($inputs);
        $successmessage = "Unit saved successfully!";
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
            'unithead' => 'required',
            'desc' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            'unithead.required' => 'Unit Head field is required.',
            'desc.required' => 'Description already registered!',
        ]);
        $unitupdate = Units::find($request->id);
        $unitupdate->update(['name' => $request->name, 'unithead' => $request->unithead, 'desc' => $request->desc]);
        $successmessage = "Unit updated successfully!";
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $unit = Units::find($request->id);
        $unit->delete();
        return 'success';
    }
}
