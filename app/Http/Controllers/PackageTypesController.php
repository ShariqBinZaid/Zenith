<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Packages;
use App\Models\PackageTypes;


class PackageTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $packagetypes = PackageTypes::orderBy('created_at');
        $totalpackagetypes = PackageTypes::count();
        
        if ($search) {
            $packagetypes->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $packagetypes = $packagetypes->paginate(15);
        
        return view('packagetypes.index',compact(['packagetypes','totalpackagetypes','search']));
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
            'name.required' => 'Package Types is required.',
        ]);
        $packagetypesobj = new PackageTypes();
        $packagetypesobj->name = $request->name;
        $packagetypesobj->company_id = auth()->user()->company_id;
        $packagetypesobj->save();
        $successmessage = "Package Types created successfully!";
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
        $packagetypes = PackageTypes::find($id);
        $totalpackagetypes = PackageTypes::count();
        return view('packagetypes.update',compact(['totalpackagetypes','packagetypes','id']));
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
            'name.required' => 'Package Types is required.',
        ]);
        $packagetypesupdate = PackageTypes::find($request->id);
        $packagetypesupdate->update(['name' => $request->name]);
        $successmessage = "Package Types updated successfully!";
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
        $packagetypes=PackageTypes::find($request->id);
        $packagetypes->delete();
        return 'success';
    }
}
