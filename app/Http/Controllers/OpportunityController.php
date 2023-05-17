<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Opportunity;
use App\Models\Brands;
use App\Models\Teams;
use App\Models\User;
use App\Models\Units;
use App\Models\Packages;
use App\Models\Dispositions;
use App\Models\Company;
use App\Models\Notify;
use App\Events\OpportunityAssign;
use App\Events\OpportunityDisposition;
use Auth;
use Validator;
use App\Notifications\OpportunityAssignNotification;
use App\Notifications\NewOpportunityNotification;
class OpportunityController extends Controller
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
            $opportunities = Opportunity::latest()
                ->with('getBrand')
                ->with('getPackage')
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
                })
                ->paginate(10);
        }
        elseif(Auth::user()->roles->pluck('name')[0] == 'sales_head'){
            $opportunities = Opportunity::where('company_id',Auth::user()->company_id)->paginate(10);;
        }elseif (Auth::user()->roles->pluck('name')[0] == 'admin') {
            $opportunities = Opportunity::whereHas('getCompany', function ($query) {
                $query->where('owner', '=', Auth::user()->id);
            })
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->paginate(10);
        } elseif (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $unitid = Units::where('unithead', Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach ($unitid->brands as $thisbrand) {
                array_push($brands, $thisbrand->id);
            }
            $opportunities = Opportunity::whereIn('brand_id', $brands)
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
                })
                ->paginate(10);
        } else {
            $user = Auth::user();
            $opportunities = Opportunity::whereHas('users', function ($query) use ($user) {
                $query->where('opportunity_user.user_id', '=', $user->id);
            })
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->paginate(10);
        }
        $dispositions = Dispositions::where('company_id', Auth::user()->company_id)->get();
        $brandspackages = Brands::latest()->with('packages.getCurrency')->get();
        return view('opportunities.index', compact(['opportunities', 'brandspackages', 'search','dispositions']));
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
            'email' => 'required|email|unique:opportunity',
            'phone' => 'required|unique:opportunity',
            'package_id'=>'required'
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as an opportunity!',
            'phone.required' => 'Phone field is required.',
            'phone.unique' => 'Phone Number already registered as an opportunity!',
            'package_id.required'=>'Select Package'
        ]);
        $inputs = $request->all();
        $inputs['url']= "www.google.com";
        $brand_id = Packages::where('id',$request->package_id)->pluck('brand_id')->first();
        $inputs['brand_id']= $brand_id;
        $inputs['company_id'] = Brands::where('id',$brand_id)->pluck('company_id')->first();
        $inputs['unit_id'] = Brands::where('id',$brand_id)->pluck('unit_id')->first();
        Opportunity::create($inputs);
        $successmessage = "Opportunity saved successfully!";
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
        $opportunity = Opportunity::find($id);
        return view('opportunities.show', compact(['opportunity']));
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
            'package_id' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'package_id' => 'Select Package'
        ]);
        $opportunityupdate = Opportunity::find($request->id);
        $brand_id = Packages::where('id',$request->package_id)->pluck('brand_id')->first();
        $opportunityupdate->update(['name' => $request->name , 'brand_id' => $brand_id ,'package_id' => $request->package_id]);
        $successmessage = "Opportunity updated successfully!";
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
        $opportunity=Opportunity::find($request->id);
        $opportunity->delete();
        return 'success';
    }
    public function assignOpportunity($id)
    {
        

        $opportunity = Opportunity::find($id);
        // if (Auth::user()->roles->pluck('name')[0] == 'superadmin') {
        //     $users = User::whereHas(
        //         'roles',
        //         function ($q) {
        //             $q->where('name', 'business_unit_head');
        //             $q->orWhere('name', 'admin');
        //             $q->orWhere('name', 'front_sales_manager');
        //             $q->orWhere('name', 'front_sales_executive');
        //         }
        //     )->get();
        // } elseif (Auth::user()->roles->pluck('name')[0] == 'admin') {
        //     $users = User::whereHas(
        //         'roles',
        //         function ($q) {
        //             $q->where('name', 'business_unit_head');
        //             $q->orWhere('name', 'front_sales_manager');
        //             $q->orWhere('name', 'front_sales_executive');
        //         }
        //     )->where('company_id', Auth::user()->company_id)->get();
        // } elseif (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
        //     $unitid = Units::where('unithead',Auth::user()->id)->pluck('id')->first();
        //     $users = User::whereHas(
        //         'roles',
        //         function ($q) {
        //             $q->where('name', 'front_sales_manager');
        //             $q->orWhere('name', 'front_sales_executive');
        //         }
        //     )->where(['company_id' => Auth::user()->company_id, 'unit_id' => $unitid])->get();
        // } else {
        //     $users = User::whereHas(
        //         'roles',
        //         function ($q) {
        //             $q->orWhere('name', 'front_sales_executive');
        //         }
        //     )->where(['company_id' => Auth::user()->company_id, 'unit_id' => Auth::user()->unit_id])->get();
        // }
        $users = User::where('depart_id',1)->where('company_id',Auth::user()->company_id)->get();
        return view('opportunities.assign_opportunity',compact(['opportunity','users']));
    }
    public function assignOpportunitySubmit(Request $request)
    {
        $opportunity = Opportunity::find($request->opportunity_id);
        if($opportunity->users->contains($request->user_id))
        {
            $successmessage = "Opportunity already assigned to this user!";
        }else{
            $opportunity->users()->attach($request->user_id);
            $successmessage = "Opportunity assigned successfully!";
        }
        $assignedto = User::find($request->user_id);
        $url = env('APP_URL').'salesforce/opportunities/'.$request->opportunity_id;
        $assignedto->notify(new OpportunityAssignNotification($opportunity));
        $opportunity->notifyalert()->create(['for'=>$request->user_id,'message'=>Auth::user()->name.' assigned you the Opportunity!','url'=>$url,'data'=>serialize(['url'=>$url,'assigneeId'=>Auth::user()->id,'assignedAt'=>time()])]);
        $notify = Notify::where('notifiable_type',Opportunity::class)->latest()->first();
        $notificationfor = $request->user_id;
        event(new OpportunityAssign($notify,$notificationfor));
        return Redirect::back()->with('success',$successmessage);
    }
    public function unassignOpportunitySubmit(Request $request)
    {
        $opportunity = Opportunity::find($request->opportunity_id);
        $opportunity->users()->detach($request->user_id);
        $successmessage = "Opportunity unassigned successfully!";
        return Redirect::back()->with('success',$successmessage);
    }
    public function addOpportunityApi(Request $request)
    {
        $input = $request->all();
        $branddetail = Brands::where('id', $input['brand_id'])->first();
        $input['company_id'] = $branddetail->company_id;
        $input['unit_id'] = $branddetail->unit_id;
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'package_id'=>'required',
        ]);
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            return $this->sendError('Validation Error.', $errors);
        }
        $opportunity = Opportunity::create($input);
        $unithead = Units::where('id',$branddetail->unit_id)->pluck('unithead')->first();
        $companyOwner = Company::where('id',$branddetail->company_id)->pluck('owner')->first();
        $saleshead = 32;
        $notifyusers = [$unithead,$companyOwner,$saleshead];
        $frontusers = User::where('unit_id',$branddetail->unit_id)->whereHas(
                'roles',
                function ($q) {
                    $q->where('name', 'front_sales_manager');
                }
            )->get();
        foreach($notifyusers as $thisnotifyuser)
        {
            $unitheaddata = User::find($thisnotifyuser);
            $unitheaddata->notify(new NewOpportunityNotification($opportunity));
            $url = env('APP_URL').'salesforce/opportunities/'.$opportunity->id;
            $opportunity->notifyalert()->create(['for' => $thisnotifyuser, 'message' => $branddetail->name.' got a new Opportunity!','url'=>$url, 'data' => serialize(['url'=>$url,'brand_id' => $input['brand_id'],'package_id'=>$input['package_id'],'assignedAt' => time()])]);
            $notify = Notify::where('for', $thisnotifyuser)->where('notifiable_type', Opportunity::class)->latest()->first();
            event(new OpportunityAssign($notify, $thisnotifyuser));
        }
        return response()->json([
            "success" => true,
            "message" => "Opportunity created successfully.",
            "data" => $opportunity
        ]);
    }
    public function dispositions($id)
    {
        $opportunity = Opportunity::find($id);
        return view('opportunities.dispositions', compact(['opportunity']));
    }
    public function addDisposition(Request $request)
    {
        $oportunity = Opportunity::find($request->opportunity_id);
        $oportunity->disposition()->create(['user_id'=>Auth::user()->id,'disposition_id'=>$request->disposition_id,'feedback'=>$request->feedback]);
        $notifyusers = array();
        $saleshead = 32;
        array_push($notifyusers,$saleshead);
        if(getuserRole() == 'admin' || getuserRole() == 'superadmin'){
        }
        else{
            if(Auth::user()->is_leader == 0 && Auth::user()->unit_id == 0 && Auth::user()->team_id == NULL)
            {
                $companyOwner = Company::where('id',Auth::user()->company_id)->pluck('owner')->first();
                array_push($notifyusers,$companyOwner);
            }
            elseif(Auth::user()->is_leader == 0 && Auth::user()->unit_id != 0 && Auth::user()->team_id == NULL){
                $companyOwner = Company::where('id',Auth::user()->company_id)->pluck('owner')->first();
                $unithead = Units::where('id',Auth::user()->unit_id)->pluck('unithead')->first();
                array_push($notifyusers,$unithead,$companyOwner);
            }else{
                $unithead = Units::where('id',Auth::user()->unit_id)->pluck('unithead')->first();
                array_push($notifyusers,$unithead);
                if(Auth::user()->is_leader == 1)
                {
                    
                }else{
                    $team_lead = Teams::where('id',Auth::user()->team_id)->pluck('leader')->first();
                    array_push($notifyusers,$team_lead);
                }
                
            }
        }
        foreach($notifyusers as $thisnotifyuser)
        {
            $addurl = 'salesforce/opportunities/dispositions/'.$request->opportunity_id;
            $oportunity->notifyalert()->create(['for' => $thisnotifyuser, 'message' => Auth::user()->name.' added the disposition to the opportunity.', 'data' => serialize(['url'=>$addurl,'opportunity_id' => $request->opportunity_id, 'assignedAt' => time()])]);
            $notify = Notify::where('for', $thisnotifyuser)->where('notifiable_type', Opportunity::class)->latest()->first();
            $url = config('app.url').$addurl;
            event(new OpportunityDisposition($notify, $thisnotifyuser,$url));
        }
        $successmessage = "Disposition added successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function pinguser($userid,$opportunity_id)
    {
        $url = env('APP_URL').'salesforce/opportunities/'.$opportunity_id;
        $user = User::find($userid);
        $opportunity = Opportunity::find($opportunity_id);
        $opportunity->notifyalert()->create(['for' => $userid, 'message' => Auth::user()->name.' Pinged you for the opportunity!','url'=>$url, 'data' => serialize(['url'=>$url,'opportunity_id'=>$opportunity_id,'assignedAt' => time()])]);
        $notify = Notify::where('for', $userid)->where('notifiable_type', Opportunity::class)->latest()->first();
        event(new OpportunityAssign($notify, $userid));
        $successmessage = $user->name." pinged successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
}