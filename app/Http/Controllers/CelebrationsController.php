<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
class CelebrationsController extends Controller
{
    public function birthdays()
    {
        $month = date('m');
        $monthname = date('F');
        $date = date('d');
        $userswithdob = User::whereHasMeta('dob')->get();
        $thismonthbirthdays = array();
        $todaysbirthdays = array();
        foreach($userswithdob as $thisuserdob)
        {
            $dob = strtotime($thisuserdob->getMeta('dob'));
            if($month == date('m',$dob))
            {
                $userdata = User::find($thisuserdob->id);
                $userdataarray = [
                    'name'=>$userdata->name,
                    'email'=>$userdata->email,
                    'id'=>$userdata->id,
                    'dob'=>$userdata->getMeta('dob'),
                    'department'=>$userdata->getDepart->name,
                    'designation'=>$userdata->getMeta('designation'),
                    'image'=>$userdata->image,
                    'employee_status'=>$userdata->getMeta('employment_status')
                ];
                if($date == date('d',$dob))
                {
                    array_push($todaysbirthdays,$userdataarray);
                    array_push($thismonthbirthdays,$userdataarray);
                }else{
                    array_push($thismonthbirthdays,$userdataarray);
                }
            }
        }
        return view('celebrations.birthdays',compact('todaysbirthdays','thismonthbirthdays','monthname'));
    }
}