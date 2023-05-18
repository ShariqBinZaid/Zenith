<?php

namespace App\Http\Controllers;

use App\Models\Dispositions;
use Illuminate\Http\Request;
<<<<<<< Updated upstream
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

=======
>>>>>>> Stashed changes

class DispositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
<<<<<<< Updated upstream
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $dispositions = Dispositions::latest();
        $dispositionstypes = Dispositions::orderBy('created_at','desc');
        $totaldispositionstypes = Dispositions::count();
        
        if ($search) {
            $dispositionstypes->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $dispositionstypes = $dispositionstypes->paginate(15);
        
        return view('settings.dispositions',compact(['dispositionstypes','totaldispositionstypes','dispositions','search']));
=======
    public function index()
    {
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
            'name' => 'required'
        ], [
            'name.required' => 'Dispositions Types is required.',
        ]);
        $dispositionsobj = new Dispositions();
        $dispositionsobj->name = $request->name;
        $dispositionsobj->company_id = auth()->user()->company_id;
        $dispositionsobj->save();
        $successmessage = "Dispositions Types created successfully!";
        return Redirect::back()->with('success',$successmessage);
=======
        //
>>>>>>> Stashed changes
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dispositions  $dispositions
     * @return \Illuminate\Http\Response
     */
    public function show(Dispositions $dispositions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dispositions  $dispositions
     * @return \Illuminate\Http\Response
     */
<<<<<<< Updated upstream
    public function edit($id)
    {
        $dispositionstypes = Dispositions::find($id);
        $totaldispositionstypes = Dispositions::count();
        return view('settings.dispositions',compact(['dispositionstypes','totaldispositionstypes','id']));
=======
    public function edit(Dispositions $dispositions)
    {
        //
>>>>>>> Stashed changes
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dispositions  $dispositions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dispositions $dispositions)
    {
<<<<<<< Updated upstream
        $validatedData = $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Dispositions Types is required.',
        ]);
        $dispositionstypesupdate = Dispositions::find($request->id);
        $dispositionstypesupdate->update(['name' => $request->name]);
        $successmessage = "Dispositions Types updated successfully!";
        return Redirect::back()->with('success',$successmessage);
=======
        //
>>>>>>> Stashed changes
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dispositions  $dispositions
     * @return \Illuminate\Http\Response
     */
<<<<<<< Updated upstream
    public function destroy(Request $request)
    {
        $dispositionstypes=Dispositions::find($request->id);
        $dispositionstypes->delete();
        return 'success';
=======
    public function destroy(Dispositions $dispositions)
    {
        //
>>>>>>> Stashed changes
    }
}
