<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreExtraPayrollPayment;

use App\ExtraPayrollPayment;

class ExtraPayrollPaymentController extends Controller
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

    public function save(StoreExtraPayrollPayment $request)
    {
        $epp = new ExtraPayrollPayment;
        $epp->payroll_id = $request->payroll_id;
        $epp->description = $request->epp_description;
        $epp->type = $request->epp_type;
        $epp->amount = floatval(preg_replace('#[^0-9.]#', '',$request->epp_amount));
        $epp->save();
        return response()->json($epp);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $epp = new ExtraPayrollPayment;
        $epp->payroll_id = $request->payroll_id;
        $epp->description = $request->epp_description;
        $epp->amount = floatval(preg_replace('#[^0-9.]#', '',$request->epp_amount));
        $epp->save();
        return redirect()->back();
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

    public function delete(Request $request)
    {
        try {
            $epp = ExtraPayrollPayment::findOrFail($request->id);
            $epp->delete();
            
        } catch (Exception $e) {
            dd($e);
        }
    
    }
}
