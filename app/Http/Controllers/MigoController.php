<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

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
        return view('migo.index');
    }

    //Migo datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $migo = Migo::with('purchase_request', 'creator')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'migos.*'
        ]);

        $data_migo = Datatables::of($migo)
            ->addColumn('purchase_request_code', function($migo){
                $purchase_request_code = NULL;
                if($migo->purchase_request){
                    $purchase_request_code = $migo->purchase_request->code;
                }
                return $purchase_request_code;
            })
            ->addColumn('creator_name', function($migo){
                $creator_name = NULL;
                if($migo->creator){
                    $creator_name = $migo->creator->name;
                }
                return $creator_name;
            })
            ->addColumn('actions', function($migo){
                $actions_html ='<a href="'.url('migo/'.$migo->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link"></i>';
                $actions_html .='</a>&nbsp;';
                return $actions_html;
            });

        if($keyword = $request->get('search')['value']) {
            $data_migo->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_migo->make(true);
    }
    //END Migo datatables

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
