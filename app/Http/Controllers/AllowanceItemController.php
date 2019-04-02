<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\AllowanceItem;

class AllowanceItemController extends Controller
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


    protected function count_total_amount($id)
    {
        $total_amount = 0;
        $allowanceItem = AllowanceItem::find($id);
        if($allowanceItem){
            $amount = $allowanceItem->amount;
            $multiplier = $allowanceItem->multiplier;
            $total_amount = $amount*$multiplier;

        }
        $allowanceItem->total_amount = $total_amount;
        $allowanceItem->save();
        return number_format($total_amount,2);
        
        
    }

    public function updateAmount(Request $request)
    {
        $allowanceItem = AllowanceItem::find($request->pk);
        $allowanceItem->amount = floatval(preg_replace('#[^0-9.]#', '', $request->value));
        $allowanceItem->save();
        $count_total_amount = $this->count_total_amount($allowanceItem->id);
        return response()
            ->json(['id'=>$allowanceItem->id, 'total_amount'=>$count_total_amount]);

    }

    public function updateMultiplier(Request $request)
    {
        $allowanceItem = AllowanceItem::find($request->pk);
        $allowanceItem->multiplier = abs($request->value);
        $allowanceItem->save();
        $count_total_amount = $this->count_total_amount($allowanceItem->id);
        return response()
            ->json(['id'=>$allowanceItem->id, 'total_amount'=>$count_total_amount]);
    }
}
