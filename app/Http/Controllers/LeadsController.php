<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use App\Models\User;
use App\Models\Brands;
use App\Models\Teams;
use App\Models\Units;
use App\Models\Notify;
use App\Models\Dispositions;
use App\Models\Company;
use Exception;
use Validator;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\LeadAssignNotification;
use App\Notifications\NewLeadNotification;
use App\Events\LeadAssign;
use App\Events\NewLead;
use App\Events\LeadDisposition;
class LeadsController extends Controller
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
            $leads = Leads::latest()
                ->with('getBrand');
        } elseif (Auth::user()->roles->pluck('name')[0] == 'admin' ) {
            $leads = Leads::whereHas('getCompany', function ($query) {
                $query->where('owner', '=', Auth::user()->id);
            });
        }elseif(Auth::user()->roles->pluck('name')[0] == 'sales_head'){
            $leads = Leads::where('company_id',Auth::user()->company_id);
        }
        elseif (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
            $unitid = Units::where('unithead', Auth::user()->id)->with('brands')->first();
            $brands = array();
            foreach ($unitid->brands as $thisbrand) {
                array_push($brands, $thisbrand->id);
            }
            $leads = Leads::whereIn('brand_id', $brands);
        } else {
            $user = Auth::user();
            $leads = Leads::whereHas('users', function ($query) use ($user) {
                $query->where('leads_user.user_id', '=', $user->id);
            });
        }

        if ($search) {
            $leads->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $leads = $leads->paginate(10);
        $dispositions = Dispositions::where('company_id', Auth::user()->company_id)->get();
        $allbrands = Brands::latest()->get();
        $totalleads = Leads::count();
        return view('leads.index', compact(['leads', 'totalleads', 'allbrands','search','dispositions']));
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
            'email' => 'required|email|unique:leads',
            'phone' => 'required|unique:leads',
            'brand_id' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must contain the email address.',
            'email.unique' => 'Email already registered as a lead!',
            'phone.required' => 'Phone field is required.',
            'brand_id.required' => 'Select Brand',
            'phone.unique' => 'Phone already registered as a lead!'
        ]);
        $inputs = $request->all();
        $inputs['created_by'] = auth()->user()->id;
        $inputs['url'] = "www.google.com";
        $inputs['company_id'] = Brands::where('id', $inputs['brand_id'])->pluck('company_id')->first();
        $inputs['unit_id'] = Brands::where('id', $inputs['brand_id'])->pluck('unit_id')->first();
        Leads::create($inputs);
        $successmessage = "Lead saved successfully!";
        return Redirect::back()->with('success', $successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lead = Leads::find($id);
        return view('leads.show', compact(['lead']));
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
    public function assignLead($id)
    {
        $lead = Leads::find($id);
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
        // } elseif (Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'sales_head') {
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
        return view('leads.assign_lead', compact(['lead', 'users']));
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
            'brand_id' => 'required'
        ], [
            'name.required' => 'Name field is required.',
            'brand_id.required' => 'Select Brand',
        ]);
        $leadsupdate = Leads::find($request->id);
        $companyid = Brands::where('id', $request->brand_id)->pluck('company_id')->first();
        $unitid = Brands::where('id', $request->brand_id)->pluck('unit_id')->first();
        $leadsupdate->update(['name' => $request->name, 'brand_id' => $request->brand_id, 'company_id' => $companyid, 'unit_id' => $unitid]);
        $successmessage = "Lead updated successfully!";
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
        $lead = Leads::find($request->id);
        $lead->delete();
        return 'success';
    }
    public function assignLeadSubmit(Request $request)
    {
        $lead = Leads::find($request->leads_id);
        if ($lead->users->contains($request->user_id)) {
            $successmessage = "Lead already assigned to this user!";
        } else {
            $lead->users()->attach($request->user_id);
            $successmessage = "Lead assigned successfully!";
        }
        $assignedto = User::find($request->user_id);
        $assignedto->notify(new LeadAssignNotification($lead));
        $url = env('APP_URL').'salesforce/leads/'.$request->leads_id;
        $lead->notifyalert()->create(['for' => $request->user_id, 'message' => Auth::user()->name . ' assigned you the Lead!','url'=>$url, 'data' => serialize(['url'=>$url,'assigneeId' => Auth::user()->id, 'assignedAt' => time()])]);
        $notify = Notify::where('for', $request->user_id)->where('notifiable_type', Leads::class)->latest()->first();
        $notificationfor = $request->user_id;
        event(new LeadAssign($notify, $notificationfor));
        return Redirect::back()->with('success', $successmessage);
    }
    public function unassignLeadSubmit(Request $request)
    {
        $lead = Leads::find($request->leads_id);
        $lead->users()->detach($request->user_id);
        $successmessage = "Lead unassigned successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function addDisposition(Request $request)
    {
        $lead = Leads::find($request->lead_id);
        $lead->disposition()->create(['user_id'=>Auth::user()->id,'disposition_id'=>$request->disposition_id,'feedback'=>$request->feedback]);
        $notifyusers = array();
        $saleshead = 32;
        array_push($notifyusers,$saleshead);
        $teamlead = User::find(Auth::user()->id);
        if($teamlead->reporting_authority == $saleshead)
        {}else{
            array_push($notifyusers,$teamlead->reporting_authority);
        }
        foreach($notifyusers as $thisnotifyuser){
            $theurl = 'salesforce/leads/dispositions/'.$request->lead_id;
            $lead->notifyalert()->create(['for' => $thisnotifyuser, 'message' => Auth::user()->name.' added the disposition to the lead.', 'data' => serialize(['url'=>$theurl,'lead_id' => $request->lead_id, 'assignedAt' => time()])]);
            $notify = Notify::where('for', $thisnotifyuser)->where('notifiable_type', Leads::class)->latest()->first();
            $url = config('app.url').$theurl;
            event(new LeadDisposition($notify, $thisnotifyuser,$url));
        }
        $successmessage = "Disposition added successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
    public function dispositions($id)
    {
        $lead = Leads::find($id);
        return view('leads.dispositions', compact(['lead']));
    }
    public function addLeadApi(Request $request)
    {
        $input = $request->all();
        $branddetail = Brands::where('id', $input['brand_id'])->first();
        $input['company_id'] = $branddetail->company_id;
        $input['unit_id'] = $branddetail->unit_id;
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            return $this->sendError('Validation Error.', $errors);
        }
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
        foreach($frontusers as $thisuser)
        {
            array_push($notifyusers,$thisuser->id);
        }
        $lead = Leads::create($input);
        foreach($notifyusers as $thisnotifyuser)
        {
            $unitheaddata = User::find($thisnotifyuser);
            $notificationfor = $thisnotifyuser;
            $url = 'salesforce/leads';
            $unitheaddata->notify(new NewLeadNotification($lead));
            $lead->notifyalert()->create(['for' => $notificationfor, 'message' => $branddetail->name.' got a new Lead!', 'data' => serialize(['url'=>$url,'brand_id' => $input['brand_id'], 'assignedAt' => time()])]);
            $notify = Notify::where('for', $thisnotifyuser)->where('notifiable_type', Leads::class)->latest()->first();
            event(new LeadAssign($notify, $notificationfor));
        }
        return response()->json([
            "success" => true,
            "message" => "Lead created successfully.",
            "data" => $lead
        ]);
    }
    public function pinguser($userid,$lead_id)
    {
        $url = env('APP_URL').'salesforce/leads/'.$lead_id;
        $user = User::find($userid);
        $lead = Leads::find($lead_id);
        $lead->notifyalert()->create(['for' => $userid, 'message' => Auth::user()->name.' Pinged you for the lead!','url'=>$url, 'data' => serialize(['url'=>$url,'lead_id'=>$lead_id,'assignedAt' => time()])]);
        $notify = Notify::where('for', $userid)->where('notifiable_type', Leads::class)->latest()->first();
        event(new LeadAssign($notify, $userid));
        $successmessage = $user->name." pinged successfully!";
        return Redirect::back()->with('success', $successmessage);
    }
}
