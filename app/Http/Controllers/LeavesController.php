<?php

namespace App\Http\Controllers;

use App\Models\Leaves;
use App\Models\LeaveTypes;
use App\Models\Attendance;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Models\Activity;
use Auth;
use DB;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $totalleave = Leaves::where('userid', auth()->user()->id)->count();
        $leaves = Leaves::where('userid', auth()->user()->id)->with('leavetype')->latest();
        $leavetypes = LeaveTypes::all();
        $personal = 1;
        $username = auth()->user()->name;

        if ($search) {
            $leaves->where(function ($query) use ($search) {
                $query->where('date', 'like', '%' . $search . '%');
                $query->where('type', 'like', '%' . $search . '%');
                $query->where('reson', 'like', '%' . $search . '%');
            });
        }        
        
        
        $leaves = $leaves->paginate(15);

        return view('leaves.index', compact(['totalleave', 'leaves', 'leavetypes', 'personal', 'username', 'search']));
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
        $leavesShow = $request->validate([
            'start_date' => 'required',
            'reason' => 'required'
        ], [
            'start_date.required' => "Date field is required.",
            'Reason.required' => "Reason field is required."
        ]);
        $LeaveStore = Leaves::all();
        $year = date('Y', strtotime($request->start_date));
        $typedays = LeaveTypes::where('id', $request->type)->pluck('days')->first();
        $typename = LeaveTypes::where('id', $request->type)->pluck('name')->first();
        $takendays = Leaves::where(['type' => $request->type, 'userid' => auth()->user()->id, 'year' => date('Y')])->count();

        if ($request->half_day == NULL) {
            $halfday = 0;
        } else {
            $halfday = 1;
        }
        if ($request->end_date == NULL) {
            if ($takendays >= $typedays) {
                $message = $typename . " are completely availed by you!";
                $msgstatus = 'error';
            } else {
                Leaves::updateOrCreate(
                    ['date' =>  strtotime($request->start_date), 'year' => $year, 'userid' => auth()->user()->id, 'unit_id' => Auth::user()->unit_id, 'company_id' => Auth::user()->company_id],
                    ['type' => $request->type, 'reason' => $request->reason, 'half_day' => $halfday]
                );
                $message = "Leave applied successfully!";
                $msgstatus = 'success';
            }
        } else {
            $startdate = strtotime($request->start_date);
            $enddate = strtotime($request->end_date);
            for ($i = $startdate; $i <= $enddate; $i += 86400) {
                if ($takendays == $typedays) {
                    $message = $typename . " are completely availed by you!";
                    $msgstatus = 'error';;
                } else {
                    Leaves::updateOrCreate(
                        ['date' =>  $i, 'year' => $year, 'userid' => auth()->user()->id],
                        ['type' => $request->type, 'reason' => $request->reason, 'half_day' => $halfday, 'unit_id' => Auth::user()->unit_id, 'company_id' => Auth::user()->company_id]
                    );
                    $message = "Leave applied successfully!";
                    $msgstatus = 'success';
                }
            }
        }
        return Redirect::back()->with($msgstatus, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function show(Leaves $leaves)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function edit(Leaves $leaves)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leaves $leaves)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leaves  $leaves
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leaves $leaves)
    {
        //
    }
    public function userleaves($id)
    {
        if ($id != Auth::user()->id && !Auth::user()->can('view users leaves')) {
            return abort(403, "You cannot view other's leaves");
        } else {
            if (Auth::user()->roles->pluck('name')[0] == 'human_resource_manager' || Auth::user()->roles->pluck('name')[0] == 'human_resource_executive' || Auth::user()->roles->pluck('name')[0] == 'admin' || Auth::user()->roles->pluck('name')[0] == 'superadmin' || $id == Auth::user()->id) {
            } elseif (Auth::user()->roles->pluck('name')[0] == 'business_unit_head') {
                if ((Units::where('unithead', Auth::user()->id)->count() > 0) && (User::where('id', $id)->pluck('unit_id')->first() == Units::where('unithead', Auth::user()->id)->pluck('id')->first())) {
                } else {
                    return abort(403, "You cannot view other's leaves");
                }
            } else {
                if ((Auth::user()->is_leader == 1) && (User::where('id', $id)->pluck('team_id')->first() == Auth::user()->team_id)) {
                } else {
                    return abort(403, "You cannot view other's attendancess");
                }
            }
        }
        $leaves = Leaves::where('userid', $id)->with('leavetype')->latest()->paginate(10);
        $leavetypes = LeaveTypes::all();
        $personal = NULL;
        $username = User::where('id', $id)->pluck('name')->first();
        return view('leaves.index', compact(['leaves', 'leavetypes', 'personal', 'username']));
    }

    public function activitylogs()
    {
        $lastLoggedActivity = Activity::all()->last();
        dd($lastLoggedActivity->description);
    }
    public function allleaves(Request $request)
    {
        $allleaves = Leaves::latest();
        $filteruser = $request->input('user');
        $start_date = strtotime($request->input('start_date'));
        $end_date = strtotime($request->input('end_date'));
        $final_status = ($request->input('final_status'));

        if (!empty($filteruser)) {
            $allleaves->whereIn('userid', $filteruser);
        }
        if (!empty($start_date) && !empty($end_date)) {
            $allleaves->whereBetween('date', [$start_date, $end_date]);
        }
        if (!empty($final_status)) {
            $allleaves->where('final_status', $final_status);
        }
        $allleaves = $allleaves->paginate(20);
        if (Auth::user()->unit_id == 0) {
            $users = User::where('id', '!=', 1)->get();
        } else {
            $users = User::where('unit_id', Auth::user()->unit_id)->get();
        }
        return view('leaves.all', compact(['allleaves', 'users']));
    }

    public function approve(Request $request)
    {
        $leave = Leaves::find($request->id);
        $leave->update(['final_status' => 'approved', 'hr_status' => 'approved']);
        return 'success';
    }

    public function reject(Request $request)
    {
        $leave = Leaves::find($request->id);
        $leave->update(['final_status' => 'rejected', 'hr_status' => 'rejected']);
        return 'success';
    }

    public function companyleaves(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $companyleaves = Leaves::where('company_id', Auth::user()->company_id)->latest();
        
        if ($status) {
            $companyleaves->where('final_status', $status);
        }
        else {
            $companyleaves->where('final_status', 'pending');
        }
        $companyleaves = $companyleaves->paginate(15);
        return view('leaves.company_leaves', compact(['companyleaves','search','status']));
    }
    
    public function approvelead(Request $request)
    {
        $leave = Leaves::find($request->id);
        $leave->update(['lead_status' => 'approved']);
        return 'success';
    }

    public function rejectlead(Request $request)
    {
        $leave = Leaves::find($request->id);
        $leave->update(['lead_status' => 'rejected']);
        return 'success';
    }

    public function leadLeaves(Request $request)
    {
        $userid = Auth::user()->id;
        $leadleaves = DB::table('leaves')->join('users', 'users.id', '=', 'leaves.userid')->select('leaves.*', 'users.name','users.image')->where('users.reporting_authority', $userid)->paginate(15);
        return view('leaves.lead_leaves', compact(['leadleaves']));
    }
    public function leaverequestajax(Request $request)
    {
        $date = $request->date;
        $year = date('Y', $request->date);
        if($request->halfday == NULL){$halfday = 0;}else{$halfday = 1;}
        $typedays = LeaveTypes::where('id', $request->type)->pluck('days')->first();
        $typename = LeaveTypes::where('id', $request->type)->pluck('name')->first();
        $takendays = Leaves::where(['type' => $request->type, 'userid' => auth()->user()->id, 'year' => date('Y')])->count();
        if($typedays == $takendays || $takendays > $typedays)
        {
            $message = $typename.' are completely availed by you';
            $msgstatus = 'error';
        }
        else{
            $leave = new Leaves;
            $leave->date = $date;
            $leave->year = $year;
            $leave->userid = Auth::user()->id;
            $leave->type = $request->type;
            $leave->reason = $request->desc;
            $leave->half_day = $halfday;
            $leave->unit_id = Auth::user()->unit_id;
            $leave->company_id = Auth::user()->company_id;
            $leave->save();
            $message = "Leave applied successfully!";
            $msgstatus = 'success';
        }
        return $responce = [$message,$msgstatus];
    }
}
