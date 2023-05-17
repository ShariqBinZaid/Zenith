<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Packages;
use App\Models\Brands;
use App\Models\Currency;
use App\Models\PackageTypes;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $packages = Packages::orderBy('created_at','desc')->with('getBrand')->with('getCurrency')->with('getPackageType');
        $totalpackages = Packages::count();
        $allbrands = Brands::all();
        $currencies = Currency::all();
        $packagetypes = PackageTypes::all();
        
        if ($search) {
            $packages->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('package_type', 'like', '%' . $search . '%')
                    ->orWhere('brand_id', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%');
            });
        }

        $packages = $packages->paginate(15);


        return view('packages.index',compact(['packages','totalpackages','allbrands','currencies','packagetypes','search']));
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
            'package_type' => 'required',
            'price' => 'required',
            'cut_price'=>'required',
            'currency'=>'required',
            'brand_id'=>'required',
            'description'=>'required'
        ], [
            'name.required' => 'Package Name is required.',
            'package_type.required' => 'Select Package Type',
            'price.required' => 'Price is required',
            'cut_price.required' => 'Cut Price is required',
            'currency.required' => 'Select the currency',
            'brand_id.required' => 'Select Brand',
            'description.required' => 'Package Description is required'
        ]);
        $desc = $request->description;
        $desc = str_replace("<ul>","",$desc);
        $desc = str_replace("</ul>","",$desc);
        $packagesobj = new Packages();
        $packagesobj->name = $request->name;
        $packagesobj->price = $request->price;
        $packagesobj->cut_price = $request->cut_price;
        $packagesobj->description = $desc;
        $packagesobj->currency = $request->currency;
        $packagesobj->brand_id = $request->brand_id;
        if($request->discount == NULL)
        {
            $request->discount = 0;
        }
        $packagesobj->discount = $request->discount;
        $packagesobj->package_type = $request->package_type;
        $packagesobj->save();
        $successmessage = "Package created successfully!";
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
        $allbrands = Brands::all();
        $currencies = Currency::all();
        $packagetypes = PackageTypes::all();
        $packagedata = Packages::find($id);
        $totalpackages = Packages::count();
        return view('packages.update',compact(['packagedata','allbrands','currencies','packagetypes','id','totalpackages']));
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
            'package_type' => 'required',
            'price' => 'required',
            'cut_price'=>'required',
            'currency'=>'required',
            'brand_id'=>'required',
            'description'=>'required'
        ], [
            'name.required' => 'Package Name is required.',
            'package_type.required' => 'Select Package Type',
            'price.required' => 'Price is required',
            'cut_price.required' => 'Cut Price is required',
            'currency.required' => 'Select the currency',
            'brand_id.required' => 'Select Brand',
            'description.required' => 'Package Description is required'
        ]);
        $packageupdate = Packages::find($request->id);
        $packageupdate->update(['name' => $request->name ,
         'package_type' => $request->package_type,
         'price' => $request->price,
         'cut_price' => $request->cut_price,
         'currency' => $request->currency,

         'brand_id' => $request->brand_id,
         'description' => $request->description
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
        $package=Packages::find($request->id);
        $package->delete();
        return 'success';
    }
}