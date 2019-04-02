<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MedicalAllowance;

class MedicalAllowanceController extends Controller
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

    public function updateAmount(Request $request)
    {
        $medicalAllowance = MedicalAllowance::find($request->pk);
        //get the multiplier
        $multiplier = $medicalAllowance->multiplier;

        $medicalAllowance->amount = floatval(preg_replace('#[^0-9.]#', '', $request->value));
        //update total_amount based n the multiplier
        $medicalAllowance->total_amount = floatval(preg_replace('#[^0-9.]#', '', $request->value)) * $multiplier;
        $medicalAllowance->save();
        //update total_amount
        $response = ['total_medical_allowance_amount'=>$this->getTotalMedicalAllowanceAmount($medicalAllowance)];
        return response()->json($response);

    }

    public function updateMultiplier(Request $request)
    {
        $medicalAllowance = MedicalAllowance::find($request->pk);
        //get the amount
        $amount = $medicalAllowance->amount;

        $medicalAllowance->multiplier = abs($request->value);
        //update total_amount based n the multiplier
        $medicalAllowance->total_amount = abs($request->value) * $amount;
        $medicalAllowance->save();
        //update total_amount
        $response = ['total_medical_allowance_amount'=>$this->getTotalMedicalAllowanceAmount($medicalAllowance)];
        return response()->json($response);

    }



    protected function getTotalMedicalAllowanceAmount($medicalAllowance)
    {
        $medicalAllowance = MedicalAllowance::find($medicalAllowance->id);
        return number_format($medicalAllowance->total_amount,2);
    }

}
