<?php

namespace App\Http\Controllers;
use App\Models\Finance;
use App\Models\Units;
use App\Models\Currency;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($month,$year)
    {
        $expenses = Finance::where('year','=',$year)->get();
        $currencies = Currency::all();
        $units = Units::all();
        return view('finance.index',compact(['expenses','month','year','currencies','units']));
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
