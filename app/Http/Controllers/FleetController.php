<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use DB;

class FleetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $vendorsearch = $request->input('vendor');
        
        $fleet = Fleet::orderBy('created_at');
        $totalfleet = Fleet::count();
        $alluser = User::all();
        $vendor = DB::select('SELECT vendor FROM fleets group by vendor');
        
        if ($search) {
            $fleet->where(function ($query) use ($search) {
                $query->where('car_name', 'like', '%' . $search . '%');
                $query->Orwhere('model', 'like', '%' . $search . '%');
            });
        }
        
        if($vendorsearch) {
            $fleet->where(function ($query) use ($vendorsearch) {
                $query->where('vendor', 'like', '%' . $vendorsearch . '%');
            });
        }

        $fleet = $fleet->paginate(15);
        
        return view('fleet.index', compact(['fleet', 'totalfleet', 'alluser', 'search', 'vendor','vendorsearch']));
    }
    public function fleetCSV(Request $request)
    {
        $search = $request->input('search');
        $vendorsearch = $request->input('vendor');
        $fleet = Fleet::orderBy('created_at');
        $vendor = DB::select('SELECT vendor FROM fleets group by vendor');
        
        if ($search) {
            $fleet->where(function ($query) use ($search) {
                $query->where('car_name', 'like', '%' . $search . '%');
                $query->Orwhere('model', 'like', '%' . $search . '%');
            });
        }
        
        if($vendorsearch) {
            $fleet->where(function ($query) use ($vendorsearch) {
                $query->where('vendor', 'like', '%' . $vendorsearch . '%');
            });
        }

        $fleet = $fleet->get();
        $headers = array( "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=fleet-".$vendorsearch."-".date('d-M-Y').".csv", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0" ); 
        $columns = array( 'Employee ID', 'Username','Engine', 'Rent', 'Car Name', 'Vendor Name', 'Vendor Phone Number', 'Engine', 'Assign Date','Car Number','Car Model','Kilo Meters Driven','Engine Number','Chassis Number' );
        $callback = function() use ($fleet, $columns) { $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        foreach($fleet as $thisfleet) { 
            $data = array( $thisfleet->user->getMeta('emp_id'), $thisfleet->user->name,$thisfleet->cc.' CC','RS '.$thisfleet->rent,$thisfleet->car_name,$thisfleet->vendor,$thisfleet->vendor_number,$thisfleet->engine_number,date('d-M-Y',strtotime($thisfleet->assign_date)),$thisfleet->car_number,$thisfleet->model,$thisfleet->km,$thisfleet->engine_number,$thisfleet->chassis_number ); fputcsv($file, $data);
        } fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    
    public function myFleet(Request $request)
    {
        $myfleet = Fleet::where('user_id', auth()->user()->id)->latest()->get();
        
        return view('fleet.my_fleet', compact(['myfleet']));
    }
    
    public function updateKilometer(Request $request)
    {
        $myfleet = Fleet::find($request->id);
        $myfleet->update([
            'km' => $request->km,
        ]);
        $successmessage = "Kilometer updated successfully!";
        return Redirect::back()->with('success', $successmessage);
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
            'car_name' => 'required',
            'cc'=>'required',
            'model' => 'required',
            'km' => 'required',
            'car_number' => 'required',
            'vendor' => 'required',
            'rent' => 'required',
            'assign_date'=>'required'
        ], [
            'car_name.required' => 'Car Name is required.',
            'cc.required' => 'CC is required.',
            'vendor.required' => 'Vendor is required.',
            'vendor_number.required' => 'Vendor Number is required.',
            'model.required' => 'Car Model is required.',
            'km.required' => 'Car Kilo Meter is required.',
            'rent.required' => 'Rent is required.'
        ]);

        $carobj = new Fleet();
        $carobj->car_name = $request->car_name;
        $carobj->cc = $request->cc;
        $carobj->vendor = $request->vendor;
        $carobj->vendor_number = $request->vendor_number;
        $carobj->model = $request->model;
        $carobj->km = $request->km;
        $carobj->chassis_number = $request->chassis_number;
        $carobj->engine_number = $request->engine_number;
        $carobj->car_number = $request->car_number;
        $carobj->assign_date = $request->assign_date;
        $carobj->video = $request->video;
        $carobj->rent = $request->rent;
        $carobj->company_id = auth()->user()->company_id;
        $carobj->user_id = $request->user_id;
        
        $carobj->save();
        
        $successmessage = "Fleet created successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function show(Fleet $fleet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fleet = Fleet::find($id);
        $totalfleet = Fleet::count();
        $alluser = User::all();
        return view('fleet.update', compact(['fleet', 'totalfleet', 'alluser', 'id']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fleet $fleet)
    {
        $validatedData = $request->validate([
            'car_name' => 'required',
            'cc' => 'required',
            'vendor' => 'required',
            'vendor_number' => 'required',
            'model' => 'required',
            'km' => 'required',
            'engine_number' => 'required',
            'car_number' => 'required',
            'rent' => 'required'
        ], [
            'car_name.required' => 'Car Name is required.',
            'cc.required' => 'CC is required.',
            'vendor.required' => 'Vendor is required.',
            'vendor_number.required' => 'Vendor Number is required.',
            'model.required' => 'Car Model is required.',
            'km.required' => 'Car Kilo Meter is required.',
            'engine_number.required' => 'Engine Number is required.',
            'car_number.required' => 'Car Number is required.',
            'assign_date.required' => 'Assign Date is required.',
            'rent.required' => 'Rent is required.',
        ]);

        $fleetupdate = Fleet::find($request->id);
        $fleetupdate->update([
            'car_name' => $request->car_name,
            'cc' => $request->cc,
            'vendor' => $request->vendor,
            'vendor_number' => $request->vendor_number,
            'model' => $request->model,
            'km' => $request->km,
            'chassis_number' => $request->chassis_number,
            'engine_number' => $request->engine_number,
            'car_number' => $request->car_number,
            'assign_date' => $request->assign_date,
            'rent' => $request->rent
        ]);

        $successmessage = "Fleet updated successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fleet  $fleet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fleet = Fleet::find($request->id);
        $fleet->delete();
        return 'success';
    }
}
