<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Auth;use Redirect;
class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tax = Tax::where('company_id',Auth::user()->company_id)->get();
        $tax = Tax::where('company_id',Auth::user()->company_id)->get();
        return view('settings.tax',compact(['tax']));
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
            'from' => 'required',
            'to' => 'required',
            'amount' => 'required',
            'tax_percent' => 'required'
        ], [
            'from.required' => 'From field is required.',
            'to.required' => "To field is required.",
            'amount.required' => "Amount field is required.",
            'tax_percent.required' => "Percentage field is required."
        ]);
        $inputs = $request->all();
        $inputs['company_id'] = Auth::user()->company_id;
        Tax::create($inputs);
        $successmessage = "Tax Range saved successfully!";
        return Redirect::back()->with('success',$successmessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        $validatedData = $request->validate([
            'to' => 'required',
            'from' => 'required',
            'amount' => 'required',
            'tax_percent' => 'required',
        ], [
            'to.required' => 'To field is required.',
            'from.required' => 'From field is required.',
            'amount.required' => 'Amount is required.',
            'tax_percent.required' => 'Tax Percentage is required.',
        ]);
        $taxupdate = Tax::find($request->id);
        $taxupdate->update(['to' => $request->to, 'from' => $request->from, 'amount' => $request->amount, 'tax_percent' => $request->tax_percent]);
        $successmessage = "Tax updated successfully!";
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tax=Tax::find($request->id);
        $tax->delete();
        return 'success';
    }
}
