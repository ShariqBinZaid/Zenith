<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Auth;
use Redirect;
class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'text' => 'required',
            'added_by'=>'required',
            'announcement_type'=>'required'
        ], [
            'text.required' => 'Announcement is required.',
            'added_by.required' => 'Added By is required.',
            'announcement_type.required' => 'Announcement Type is required.'
        ]);
        $announcementobj = new Announcements();
        $announcementobj->text = $request->text;
        $announcementobj->added_by = $request->added_by;
        $announcementobj->announcement_type = $request->announcement_type;
        $announcementobj->announcement_id = $request->announcement_id;
        $announcementobj->company_id = Auth::user()->company_id;
        $announcementobj->save();
        $successmessage = "Department created successfully!";
        return Redirect::back()->with('success',$successmessage);
        
    }
    public function addCompanyAnnouncement(Request $request)
    {
        $validatedData = $request->validate([
            'text'=>'required'
        ], [
            'text.required' => 'Announcement Text is required'
        ]);
        $company = Company::find(Auth::user()->company_id);
        $company->announcement()->create(['text'=>$request->text,'added_by'=>Auth::user()->id]);
        $successmessage = "Announcement created successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function show(Announcements $announcements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcements $announcements)
    {
        $validatedData = $request->validate([
            'text' => 'required',
            'added_by'=>'required',
            'announcement_type'=>'required'
        ], [
            'text.required' => 'Announcement is required.',
            'added_by.required' => 'Added By is required.',
            'announcement_type.required' => 'Announcement Type is required.'
        ]);
        $announcementupdate = Announcements::find($request->id);
        $announcementupdate->update(['text' => $request->text,'added_by'=>$request->added_by,'announcement_type'=>$request->announcement_type]);
        $successmessage = "Announcement updated successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcements $announcements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcements  $announcements
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcements $announcements, Request $request)
    {
        $announcements=DepartmeAnnouncementsnts::find($request->id);
        $announcements->delete();
        return 'success';
    }
    
    public function unitAnnouncements(Announcements $announcements)
    {
        $unitannouncements = Announcements::where('company_id',Auth::user()->company_id)->get();
        
         return view('announcements.unit', compact(['unitannouncements']));
    }
    
    public function teamAnnouncements(Announcements $announcements)
    {
        $teamannouncements = Announcements::where('company_id',Auth::user()->company_id)->get();
        
         return view('announcements.team', compact(['teamannouncements']));
    }
    
    public function companyAnnouncements()
    {
        $companyannouncements = Announcements::where('announcement_type',Company::class)->where('announcement_id',Auth::user()->company_id)->get();
        $data = array();
        foreach($companyannouncements as $companyannouncement)
        {
            $company = Company::find($companyannouncement->announcement_id);
            $user = User::find($companyannouncement->added_by);
            $singledata = [
                'username'=>$user->name,
                'userid'=>$user->id,
                'image'=>$user->image,
                'announcement'=>$companyannouncement->text,
                'company_name'=>$company->name,
                'company_id'=>$company->id,
                'company_image'=>$company->logo
                ];
            array_push($data,(object) $singledata);
        }
        return view('announcements.company', compact(['data']));
    }
    public function departAnnouncements(Announcements $announcements)
    {
        $departannouncements = Announcements::where('company_id',Auth::user()->company_id)->get();
        
         return view('announcements.depart', compact(['departannouncements']));
    }
    
}
