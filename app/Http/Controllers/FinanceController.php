<?php

namespace App\Http\Controllers;
use App\Models\Finance;
use App\Models\Units;
use App\Models\Currency;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($month,$year,$unit=NULL)
    {
        if(!Auth::user()->can('view finances'))
        {
            return abort('403','You do not have permission to access this page!');
        }
        if(Auth::user()->roles->pluck('name')[0] == 'superadmin')
        {
            if($unit == NULL){
                $conditions = ['year'=>$year,'month'=>$month];
                $unitdetail = NULL;
            }else{
                $conditions = ['year'=>$year,'month'=>$month,'unitid'=>$unit];
                $unitdetail = Units::find($unit);
                if($unitdetail == NULL)
                {
                    return abort( 403 );
                }
            }
        }
        else{
            if($unit == NULL){
                $conditions = ['year'=>$year,'month'=>$month];
                $unitdetail = NULL;
            }else{
                $conditions = ['year'=>$year,'month'=>$month,'unitid'=>$unit];
                $unitdetail = Units::find($unit);
                if($unitdetail->company_id == Auth::user()->company_id){}else{
                        return abort( 403 );
                }
            }
        }
        $expenses = Finance::where($conditions)->with('getCurrency')->with('getUnit')->with('getCompany')->with('AddedBy')->get();
        $currencies = Currency::all();
        if(Auth::user()->roles->pluck('name')[0] == 'superadmin')
        {$units = Units::all();}else{$units = Units::where('company_id',Auth::user()->company_id)->get();}
        
        //sql query after launch
        $totalofexpenses = array();
        foreach($currencies as $thiscurrency)
        {
            if($unit == NULL){
                $singlecondition = ['year'=>$year,'month'=>$month,'currencyid'=>$thiscurrency->id];
            }else{
                $singlecondition = ['year'=>$year,'month'=>$month,'currencyid'=>$thiscurrency->id,'unitid'=>$unit];
            }
            $currencyexpense = Finance::where($singlecondition)->with('getCurrency')->sum('amount');
            $singleexpense = ['amount' => $currencyexpense,'symbol'=>$thiscurrency->symbol,'name'=>$thiscurrency->name];
            array_push($totalofexpenses,$singleexpense);
        }
        return view('finance.index',compact(['expenses','month','year','currencies','units','totalofexpenses','unit','unitdetail']));
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
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required',
            'currencyid' => 'required',
            'desc' => 'required',
            'unitid' => 'required'
        ], [
            'month.required' => 'Month field is required.',
            'year.required' => 'Year field is required.',
            'amount.required' => 'Amount field is required',
            'currencyid.required' => 'Select Currency!',
            'desc.required' => 'Description field is required.',
            'unitid.required' => 'Select Unit.'
        ]);
        $financeobj = new Finance();
        $userid = auth()->user()->id;
        $companyid= Units::where('id',$request->unitid)->pluck('company_id')->first();
        $financeobj->month = $request->month;
        
        $financeobj->year = $request->year;
        
        $financeobj->amount = $request->amount;
        
        $financeobj->currencyid = $request->currencyid;

        $financeobj->desc = $request->desc;

        $financeobj->userid = $userid;
        $financeobj->unitid = $request->unitid;
        $financeobj->companyid = $companyid;
        $financeobj->save();
        $successmessage = "Finance Amount saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show(Finance $finance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
