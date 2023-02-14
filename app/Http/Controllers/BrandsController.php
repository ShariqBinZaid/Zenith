<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brands;
use App\Models\Teams;
Use Exception;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ImagesResource;
use Image;
use File;
use Auth;
class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->roles->pluck('name')[0] == 'admin')
        {
            $brands = Brands::latest()->paginate(10);
        }else{
            $teamid = Teams::isLeader(Auth::user()->id)->pluck('id')->first();
            $brands =Brands::whereHas('teams', function ($query) use ($teamid) {
                $query->where('brands_teams.teams_id', '=', $teamid);
            })->latest()->paginate(10);
        }
        $totalbrand = Brands::count();
        return view('brands.index',compact(['brands','totalbrand']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'url' => 'required|unique:brands',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'type' => 'required',
            'initials' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            'url.required' => 'URL field is required.',
            'url.unique' => 'URL already registered!',
            'type.required' => 'Brand type is required.',
            'initials.required' => 'Initials are required'
        ]);
      
        $imageName = 'brands/'.time().'-'.$request->name.'.'.$request->image->extension();  
       
        $request->image->move(public_path('images/brands'), $imageName);
        $brandobj = new Brands();
        $brandobj->name = $request->name;
        
        $brandobj->url = $request->url;
        
        $brandobj->type = $request->type;
        
        $brandobj->image = $imageName;
        
        $brandobj->initials = $request->initials;

        $brandobj->save();
        $successmessage = "Brand saved successfully!";
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
        $branddetails = Brands::find($id);
        return view('brands.desc', compact(['branddetails']));
        
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
            'url' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'type' => 'required',
            'initials' => 'required',
        ], [
            'name.required' => 'Name field is required.',
            'url.required' => 'URL field is required.',
            'url.unique' => 'URL already registered!',
            'type.required' => 'Brand type is required.',
            'initials.required' => 'Initials are required'
        ]);
        $leadsupdate = Brands::find($request->id);
        if($request->image == NULL)
        {   
            $leadsupdate->update(['name' => $request->name , 'url' => $request->url,'type'=>$request->type,'initials'=>$request->initials]);   
        }
        else{
            $image_path = public_path().'/images/'.$request->oldlinkimage;
            unlink($image_path);
            $imageName = 'brands/'.time().'-'.$request->name.'.'.$request->image->extension();  
            $request->image->move(public_path('images/brands'), $imageName);
            $leadsupdate->update(['name' => $request->name , 'url' => $request->url,'type'=>$request->type,'initials'=>$request->initials,'image'=>$imageName]);
        }
        $successmessage = "Brand updated successfully!";
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
        $brand=Brands::find($request->id);
        $brand->leads()->delete();
        $brand->opportunities()->delete();
        $brand->packages()->delete();
        $brand->delete();
        return 'success';
    }
}
