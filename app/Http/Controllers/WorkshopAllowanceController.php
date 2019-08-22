<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\WorkshopAllowance;

class WorkshopAllowanceController extends Controller
{
    public function updateAmount(Request $request)
    {
    	$workshopAllowance = WorkshopAllowance::find($request->pk);
        //get the multiplier
        $multiplier = $workshopAllowance->multiplier;

        $workshopAllowance->amount = floatval(preg_replace('#[^0-9.]#', '', $request->value));
        //update total_amount based n the multiplier
        $workshopAllowance->total_amount = floatval(preg_replace('#[^0-9.]#', '', $request->value)) * $multiplier;
        $workshopAllowance->save();
        //update total_amount
        $response = ['total_workshop_allowance_amount'=>$this->getTotalworkshopAllowanceAmount($workshopAllowance)];
        return response()->json($response);
    }


    public function updateMultiplier(Request $request)
    {
        $workshopAllowance = WorkshopAllowance::find($request->pk);
        //get the amount
        $amount = $workshopAllowance->amount;

        $workshopAllowance->multiplier = abs($request->value);
        //update total_amount based n the multiplier
        $workshopAllowance->total_amount = abs($request->value) * $amount;
        $workshopAllowance->save();
        //update total_amount
        $response = ['total_workshop_allowance_amount'=>$this->getTotalworkshopAllowanceAmount($workshopAllowance)];
        return response()->json($response);

    }

    protected function getTotalworkshopAllowanceAmount($workshopAllowance)
    {
        $workshopAllowance = WorkshopAllowance::find($workshopAllowance->id);
        return number_format($workshopAllowance->total_amount,2);
    }
}
