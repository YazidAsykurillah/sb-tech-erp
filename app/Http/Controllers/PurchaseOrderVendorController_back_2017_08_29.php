<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePurchaseOrderVendorRequest;
use App\Http\Requests\UpdatePurchaseOrderVendorRequest;

use App\PurchaseOrderVendor;
use App\Vendor;
use App\PurchaseRequest;
use App\QuotationVendor;

class PurchaseOrderVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase-order-vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor_opts = Vendor::lists('name', 'id');
        $purchase_request_opts = PurchaseRequest::lists('code', 'id');
        $quotation_vendor_opts = QuotationVendor::lists('code', 'id');
        return view('purchase-order-vendor.create')
            ->with('vendor_opts', $vendor_opts)
            ->with('purchase_request_opts', $purchase_request_opts)
            ->with('quotation_vendor_opts', $quotation_vendor_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Sync item item_purchase_order_vendor table from STORE mode
    protected function sync_item_invoice_purchase_vendor(Request $request, $po_vendor_id){
        //Block prepare purchase order vendor items
        $data_purchase_order_vendor_items = [];
        foreach($request->item as $key=>$value){
            if($request->item[$key] != ""){
                array_push($data_purchase_order_vendor_items, [
                    'purchase_order_vendor_id'=> $po_vendor_id,
                    'item'=>$request->item[$key],
                    'quantity'=>floatval(preg_replace('#[^0-9.]#', '', $request->quantity[$key])),
                    'unit'=>$request->unit[$key],
                    'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                    'sub_amount'=>floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount[$key])),
                ]);
            }
        }
        if(count($data_purchase_order_vendor_items)){
            \DB::table('item_purchase_order_vendor')->insert($data_purchase_order_vendor_items);
        }
    }

    public function store(StorePurchaseOrderVendorRequest $request)
    {
        
        //Block build next purchase_order_vendor code
        //2017-06-13
        $today = date('Y-m-d');
        
        $this_month = substr($today, 0, 7);

        $pov_format = substr($this_month, 2, 2)."-".substr($this_month, 5, 2);
        
        $next_purchase_order_vendor_number = "";
        $purchase_order_vendors = \DB::table('purchase_order_vendors')->where('created_at', 'like', "%$this_month%");
        //if counted purchase_order_vendors created in this month is 0, simply make it 001 to the next purchase_order_vendor number param.
        if($purchase_order_vendors->count() == 0){
            $next_purchase_order_vendor_number = str_pad(1, 3, 0, STR_PAD_LEFT);
        }
        else{
            $max = $purchase_order_vendors->max('code');
            $int_max = ltrim(substr($max, -3), '0');
            $next_purchase_order_vendor_number = str_pad(($int_max+1), 3, 0, STR_PAD_LEFT);
        }

        $quotation_vendor = QuotationVendor::findOrFail($request->quotation_vendor_id);

        $purchase_order_vendor = new PurchaseOrderVendor;
        $purchase_order_vendor->code = "POV-".$pov_format."-".$next_purchase_order_vendor_number;
        $purchase_order_vendor->vendor_id = $quotation_vendor->vendor->id;
        $purchase_order_vendor->purchase_request_id = $request->purchase_request_id;
        $purchase_order_vendor->quotation_vendor_id = $request->quotation_vendor_id;
        $purchase_order_vendor->description = $request->description;
        $purchase_order_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_order_vendor->sub_amount = floatval(preg_replace('#[^0-9.]#', '', $request->total_sub_amount));
        $purchase_order_vendor->vat = $request->vat;
        $purchase_order_vendor->wht = floatval(preg_replace('#[^0-9.]#', '', $request->wht));
        $purchase_order_vendor->discount = $request->discount;
        $purchase_order_vendor->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $purchase_order_vendor->terms = $request->terms;
        $purchase_order_vendor->save();
        $new_po_vendor_id = $purchase_order_vendor->id;

        //set selected quotaiton vendor purchase_order_Vendored to TRUE;
        $quotation_vendor->purchase_order_vendored = TRUE;
        $quotation_vendor->save();

        //sync item_purchase_order_vendor_table
        $this->sync_item_invoice_purchase_vendor($request, $new_po_vendor_id);

        return redirect('purchase-order-vendor/'.$new_po_vendor_id)
            ->with('successMessage', "Purchase Order Vendor has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po_vendor = PurchaseOrderVendor::findOrFail($id);
        $items = \DB::table('item_purchase_order_vendor')->where('purchase_order_vendor_id', '=', $id)->get();
        return view('purchase-order-vendor.show')
            ->with('po_vendor', $po_vendor)
            ->with('items', $items);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $purchase_order_vendor = PurchaseOrderVendor::findOrFail($id);
        $vendor_opts = Vendor::lists('name', 'id');
        $purchase_request_opts = PurchaseRequest::lists('code', 'id');
        $quotation_vendor_opts = QuotationVendor::lists('code', 'id');
        $items = \DB::table('item_purchase_order_vendor')->where('purchase_order_vendor_id', '=', $id)->get();
        return view('purchase-order-vendor.edit')
            ->with('vendor_opts', $vendor_opts)
            ->with('purchase_request_opts', $purchase_request_opts)
            ->with('purchase_order_vendor', $purchase_order_vendor)
            ->with('quotation_vendor_opts', $quotation_vendor_opts)
            ->with('items', $items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Sync item invoice_customer_table from UPDATE mode
    protected function resync_item_purchase_order_vendor(Request $request, $purchase_order_vendor_id){

        //Delete all item_purchase_order_vendor recored where related to $purchase_order_vendor_id
        \DB::table('item_purchase_order_vendor')->where('purchase_order_vendor_id', '=', $purchase_order_vendor_id)->delete();
        //Block prepare purchase_order_vendor items
        $data_purchase_order_vendors = [];
        foreach($request->item as $key=>$value){
            if($request->item[$key] != ""){
                array_push($data_purchase_order_vendors, [
                    'purchase_order_vendor_id'=> $purchase_order_vendor_id,
                    'item'=>$request->item[$key],
                    'quantity'=>floatval(preg_replace('#[^0-9.]#', '', $request->quantity[$key])),
                    'unit'=>$request->unit[$key],
                    'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                    'sub_amount'=>floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount[$key])),
                ]);
            }
        }

        
        if(count($data_purchase_order_vendors)){
            \DB::table('item_purchase_order_vendor')->insert($data_purchase_order_vendors);
        }
    }
    public function update(UpdatePurchaseOrderVendorRequest $request, $id)
    {
        
        $quotation_vendor = QuotationVendor::findOrFail($request->quotation_vendor_id);

        $purchase_order_vendor = PurchaseOrderVendor::findOrFail($id);
        $purchase_order_vendor->vendor_id = $quotation_vendor->vendor->id;
        $purchase_order_vendor->purchase_request_id = $request->purchase_request_id;
        $purchase_order_vendor->quotation_vendor_id = $request->quotation_vendor_id;
        $purchase_order_vendor->description = $request->description;
        $purchase_order_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_order_vendor->sub_amount = floatval(preg_replace('#[^0-9.]#', '', $request->total_sub_amount));
        $purchase_order_vendor->vat = $request->vat;
        $purchase_order_vendor->wht = floatval(preg_replace('#[^0-9.]#', '', $request->wht));
        $purchase_order_vendor->discount = $request->discount;
        $purchase_order_vendor->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $purchase_order_vendor->terms = $request->terms;
        $purchase_order_vendor->save();

        //resync item_purchase_order_vendor table
        $this->resync_item_purchase_order_vendor($request, $id);

        return redirect('purchase-order-vendor/'.$id)
            ->with('successMessage', "Purchase Order Vendor has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $po_vendor = PurchaseOrderVendor::findOrFail($request->po_vendor_id);
        $po_vendor->delete();
        return redirect('purchase-order-vendor')
            ->with('successMessage', "Purchase Order Vendor $po_vendor->code has been deleted");
    }


    public function print_pdf($id)
    {   
        error_reporting(0);
        $purchase_order_vendor = PurchaseOrderVendor::findOrFail($id);
        $data['purchase_order_vendor']= $purchase_order_vendor;
        $data['item_purchase_order_vendor'] = \DB::table('item_purchase_order_vendor')->where('purchase_order_vendor_id','=', $id)->get();
        $pdf = \PDF::loadView('pdf.purchase_order_vendor', $data)->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($purchase_order_vendor->code.'.pdf');
    }
    
}
