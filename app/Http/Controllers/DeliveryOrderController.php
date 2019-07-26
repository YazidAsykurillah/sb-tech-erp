<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreDeliveryOrderRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\DeliveryOrder;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('delivery-order.index');
    }

    //Datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $deliveryOrders = DeliveryOrder::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'delivery_orders.*'
        ])->with(['project', 'creator', 'sender']);

        $data = Datatables::of($deliveryOrders)
            ->editColumn('project', function($deliveryOrders){
                return $deliveryOrders->project->code;
            })
            ->editColumn('user_id', function($deliveryOrders){
                return $deliveryOrders->creator->name;
            })
            ->editColumn('sender_id', function($deliveryOrders){
                return $deliveryOrders->sender ? $deliveryOrders->sender->name : NULL;
            })
            ->addColumn('actions', function($deliveryOrders){
                    $actions_html ='<a href="'.url('delivery-order/'.$deliveryOrders->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($deliveryOrders->status == 'draft'){
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-delivery-order" data-id="'.$deliveryOrders->id.'" data-text="'.$deliveryOrders->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';    
                    }
                    
                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data->make(true);
    }
    //END Datatables

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('delivery-order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryOrderRequest $request)
    {
        //dd($request->all());
        //init item delivery order data
        $itemDeliveryOrderData = [];
        
        //Save DeliveryOrder model
        $deliveryOrder = new DeliveryOrder;
        $deliveryOrder->code = 'DO-'.time();
        $deliveryOrder->project_id = $request->project_id;
        $deliveryOrder->user_id = \Auth::user()->id;
        $deliveryOrder->sender_id = $request->sender_id;
        $deliveryOrder->save();

        
        //Build itemDelivery order data
        foreach($request->item as $key=>$value){
            $itemDeliveryOrderData[]=[
                'delivery_order_id'=>$deliveryOrder->id,
                'item_purchase_request_id'=>$value,
                'quantity'=>$request->quantity[$key]
            ];
        }

        //Save item delivery order data
        \DB::table('item_delivery_order')->insert($itemDeliveryOrderData);



        return redirect('delivery-order')
            ->with('successMessage', "Delivery order $deliveryOrder->code has been created");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deliveryOrder = DeliveryOrder::findOrFail($id);
        $deliveryOrderItems = \DB::table('item_delivery_order')->where('delivery_order_id', '=', $id)->get();
        return view('delivery-order.show')
            ->with('deliveryOrder', $deliveryOrder)
            ->with('deliveryOrderItems', $deliveryOrderItems);
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
    public function destroy(Request $request)
    {
        $id = $request->delivery_order_id_to_delete;
        $deliveryOrder = DeliveryOrder::findOrFail($id);
        //delete delivery order model
        $deliveryOrder->delete();

        //Delete DO items
        \DB::table('item_delivery_order')->where('delivery_order_id','=', $id)->delete();
        return redirect()->back()
            ->with('successMessage', 'Delivery order has been deleted');
    }

    public function print_pdf($id)
    {
        error_reporting(0);
        $deliveryOrder = DeliveryOrder::findOrFail($id);
        $data['deliveryOrder']= $deliveryOrder;
        $data['deliveryOrderItems'] = \DB::table('item_delivery_order')->where('delivery_order_id','=', $id)->get();
        $pdf = \PDF::loadView('pdf.delivery_order', $data)->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($deliveryOrder->code.'.pdf');
    }
}
