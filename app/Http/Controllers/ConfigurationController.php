<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Configuration;

class ConfigurationController extends Controller
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getEstimatedCostMargin()
    {
        $estimated_cost_margin_limit = Configuration::whereName('estimated-cost-margin-limit')->first();
        return view('configuration.estimated-cost-margin-limit')
        ->with('estimated_cost_margin_limit', $estimated_cost_margin_limit);
    }

    public function postEstimatedCostMargin(Request $request)
    {
        $configuration = Configuration::whereName('estimated-cost-margin-limit')->first();
        $id = $configuration->id;
        if($id){
            $estimated_cost_margin_limit = Configuration::find($id);
            $estimated_cost_margin_limit->value = $request->value;
            $estimated_cost_margin_limit->save();
            return redirect()->back()
                ->with('successMessage', "Estimated cost margin limit has been updated");
        }
    }
}
