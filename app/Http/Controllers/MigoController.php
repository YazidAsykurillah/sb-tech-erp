<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Migo;
use App\PurchaseRequest;

class MigoController extends Controller
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

        $purchase_request = PurchaseRequest::findOrFail($request->pr_id);
        //check if received items of purchase request is same with purchase request item
        if($purchase_request->item_purchase_request){
            $count_item_purchase_request = $purchase_request->item_purchase_request->count();
            $count_received_item_purchase_request = $purchase_request->received_item_purchase_request->count();
            if($count_item_purchase_request==$count_received_item_purchase_request){
                $migo = new Migo;
                $migo->code = 'MGO-'.time();
                $migo->description = $request->description;
                $migo->creator_id = \Auth::user()->id;
                $migo->purchase_request_id = $purchase_request->id;
                $migo->save();
                return redirect()->back()
                    ->with('successMessage', "Migo has been registed");
            }else{
                return redirect()->back()
                    ->with('errorMessage', 'All items should be received');
            }
        }

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
}
