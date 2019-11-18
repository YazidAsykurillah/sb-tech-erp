<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePurchaseOrderVendorRequest;
use App\Http\Requests\UpdatePurchaseOrderVendorRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

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
        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        $quotation_vendor_id = $purchase_request->quotation_vendor ? $purchase_request->quotation_vendor->id : NULL;
        $quotation_vendor = $quotation_vendor_id ? QuotationVendor::findOrFail($quotation_vendor_id) : NULL;

        $purchase_order_vendor = new PurchaseOrderVendor;
        $purchase_order_vendor->code = "POV-".$pov_format."-".$next_purchase_order_vendor_number;
        $purchase_order_vendor->vendor_id = $quotation_vendor ? $quotation_vendor->vendor->id : NULL;
        $purchase_order_vendor->quotation_vendor_id = $quotation_vendor ? $quotation_vendor->id : NULL;
        $purchase_order_vendor->purchase_request_id = $request->purchase_request_id;
        $purchase_order_vendor->description = $request->description;
        $purchase_order_vendor->sub_amount = floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount));
        $purchase_order_vendor->discount = floatval(preg_replace('#[^0-9.]#', '', $request->discount));
        $purchase_order_vendor->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $purchase_order_vendor->vat = floatval(preg_replace('#[^0-9.]#', '', $request->vat));
        $purchase_order_vendor->wht = floatval(preg_replace('#[^0-9.]#', '', $request->wht));
        $purchase_order_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_order_vendor->terms = $request->terms;
        $purchase_order_vendor->save();
        $new_po_vendor_id = $purchase_order_vendor->id;

        //set selected quotaiton vendor purchase_order_Vendored to TRUE;
        if($quotation_vendor != NULL){
            $quotation_vendor->purchase_order_vendored = TRUE;
            $quotation_vendor->save();    
        }
        

        /*//sync item_purchase_order_vendor_table
        $this->sync_item_invoice_purchase_vendor($request, $new_po_vendor_id);*/

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
        $purchase_request = $po_vendor->purchase_request;
        if($purchase_request){
            $items = \DB::table('item_purchase_request')->where('purchase_request_id', '=', $po_vendor->purchase_request->id)->get();    
        }else{
            $items = [];
        }
        //get the item from purchase request
        
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
        
        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        $quotation_vendor_id = $purchase_request->quotation_vendor ? $purchase_request->quotation_vendor->id : NULL;
        $quotation_vendor = $quotation_vendor_id != NULL ? QuotationVendor::findOrFail($quotation_vendor_id) : NULL;

        $purchase_order_vendor = PurchaseOrderVendor::findOrFail($id);
        $purchase_order_vendor->vendor_id = $quotation_vendor_id != NULL ? $quotation_vendor->vendor->id : NULL;
        $purchase_order_vendor->purchase_request_id = $request->purchase_request_id;
        $purchase_order_vendor->description = $request->description;
        $purchase_order_vendor->sub_amount = floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount));
        $purchase_order_vendor->discount = floatval(preg_replace('#[^0-9.]#', '', $request->discount));
        $purchase_order_vendor->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $purchase_order_vendor->vat = floatval(preg_replace('#[^0-9.]#', '', $request->vat));
        $purchase_order_vendor->wht = floatval(preg_replace('#[^0-9.]#', '', $request->wht));
        $purchase_order_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_order_vendor->terms = $request->terms;
        $purchase_order_vendor->save();

        /*
        //resync item_purchase_order_vendor table
        $this->resync_item_purchase_order_vendor($request, $id);
        */

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


    public function changeStatus(Request $request)
    {
        $po_vendor = PurchaseOrderVendor::findOrFail($request->purchase_order_vendor_id);
        if($request->status == 'completed'){
            //run comparation to ralated invoice vendor that has been paid
            $po_vendor_amount = $po_vendor->amount;
            $paid_invoice_vendor = $po_vendor->paid_invoice_vendor();
            if($paid_invoice_vendor == $po_vendor_amount || $paid_invoice_vendor > $po_vendor_amount){
                $po_vendor->status = 'completed';
                $po_vendor->save();
            }
            else{
                //raise eror warning tell that the paid invoice vendor amount is not matched the po vendor amount
                return redirect()->back()
                 ->with('errorMessage', "Failed to complete the status, the paid invoice vendor is less than Purchase Order Amount");
            }
            
        }else{
            $po_vendor->status = $request->status;
            $po_vendor->save();
        }
        
        return redirect()->back()
        ->with('successMessage', "Status has been changed to $request->status");
    }


    public function print_pdf($id)
    {   
        error_reporting(0);
        $purchase_order_vendor = PurchaseOrderVendor::findOrFail($id);
        $data['purchase_order_vendor']= $purchase_order_vendor;
        //purchase order vendor items is grabbed from the item purchase requests
        $data['item_purchase_order_vendor'] = \DB::table('item_purchase_request')->where('purchase_request_id','=', $purchase_order_vendor->purchase_request->id)->get();
        $data['company_office'] = \DB::table('configurations')->where('name', '=', 'company-office')->first()->value;
        $pdf = \PDF::loadView('pdf.purchase_order_vendor', $data)->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($purchase_order_vendor->code.'.pdf');
    }
    

    //PURCHASE ORDER VENDOR datatables
    public function dataTables(Request $request)
    {
        $user_role = \Auth::user()->roles->first()->code;
        
        \DB::statement(\DB::raw('set @rownum=0'));
        if($user_role == "SUP" || $user_role == "ADM"){
            $po_vendors = PurchaseOrderVendor::with('vendor', 'purchase_request', 'purchase_request.project', 'purchase_request.migo', 'quotation_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_order_vendors.*'
            ]);    
        }else{
            $po_vendors = PurchaseOrderVendor::with('vendor', 'purchase_request', 'purchase_request.project', 'purchase_request.migo', 'quotation_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_order_vendors.*'
            ])
            ->whereHas('purchase_request', function($query){
                $query->where('user_id', '=', \Auth::user()->id);
            });
        }
        

        $data_po_vendors = Datatables::of($po_vendors)
            ->editColumn('vendor_id', function($po_vendors){
                return $po_vendors->vendor ? $po_vendors->vendor->name : NULL;
            })
            ->editColumn('code', function($po_vendors){
                $link ='<a href="'.url('purchase-order-vendor/'.$po_vendors->id.'').'" class="btn btn-link" title="Click to view the detail">';
                $link .=    $po_vendors->code;
                $link .='</a>';
                return $link;
            })
            ->addColumn('project_code', function($po_vendors){
                if($po_vendors->purchase_request){
                    return $po_vendors->purchase_request->project ? $po_vendors->purchase_request->project->code : NULL;    
                }
                return NULL;
                
            })
            ->addColumn('project_name', function($po_vendors){
                if($po_vendors->purchase_request){
                    $project_name = $po_vendors->purchase_request->project ? $po_vendors->purchase_request->project->name : NULL;
                    return substr($project_name, 0, 100);
                }
                return NULL;
                
            })
            ->addColumn('migo_code', function($po_vendors){
                $migo_code = NULL;
                if($po_vendors->purchase_request){
                    $migo_code = $po_vendors->purchase_request->migo ? $po_vendors->purchase_request->migo->code : NULL;
                }
                return $migo_code;
                
            })
            ->editColumn('purchase_request', function($po_vendors){
                if($po_vendors->purchase_request){
                    $link  ='<a href="'.url('purchase-request/'.$po_vendors->purchase_request->id).'">';
                    $link .=    $po_vendors->purchase_request->code;
                    $link .= '</a>';
                    return $link;
                }
                
            })
            ->editColumn('quotation_vendor', function($po_vendors){
                if($po_vendors->quotation_vendor){
                    return $po_vendors->quotation_vendor->code;
                }
                
            })
            ->editColumn('description', function($po_vendors){
               return str_limit($po_vendors->description, 100);
            })
            ->editColumn('amount', function($po_vendors){
                //return $po_vendors->purchase_request ? number_format($po_vendors->purchase_request->amount) : 0;
                //return number_format($po_vendors->amount);
                $amount = 0;
                if($po_vendors->amount != NULL){
                    $amount=$po_vendors->amount;
                }else{
                    $amount = $po_vendors->purchase_request->amount;
                }
                
                return number_format($amount);
            })
            ->addColumn('paid_invoice_vendor', function($po_vendors){
                return $po_vendors->paid_invoice_vendor() ? number_format($po_vendors->paid_invoice_vendor()) : 0;
            })
            ->addColumn('balance', function($po_vendors){
                $amount = $po_vendors->purchase_request ?($po_vendors->purchase_request->amount) : 0;
                $paid_invoice_vendor = $po_vendors->paid_invoice_vendor() ?($po_vendors->paid_invoice_vendor()) : 0;
                $balance = $amount - $paid_invoice_vendor;
                return number_format($balance, 2);

            })
            ->addColumn('actions', function($po_vendors){
                    $actions_html ='<a href="'.url('purchase-order-vendor/'.$po_vendors->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($po_vendors->status != 'completed'){
                        if(\Auth::user()->can('edit-purchase-order-vendor')){
                            $actions_html .='<a href="'.url('purchase-order-vendor/'.$po_vendors->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this purchase-order-vendor">';
                            $actions_html .=    '<i class="fa fa-edit"></i>';
                            $actions_html .='</a>&nbsp;';
                        }
                        if(\Auth::user()->can('delete-purchase-order-vendor')){
                            $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order-vendor" data-id="'.$po_vendors->id.'" data-text="'.$po_vendors->code.'">';
                            $actions_html .=    '<i class="fa fa-trash"></i>';
                            $actions_html .='</button>';
                        }
                    }
                    return $actions_html;
            });

        if($keyword = $request->get('search')['value']) {
            $data_po_vendors->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_po_vendors->make(true);
    }
    //END PURCHASE ORDER VENDOR datatables


    public function getItems(Request $request)
    {
        $purchaseOrderVendor = PurchaseOrderVendor::findOrFail($request->purchase_order_vendor_id);
        $purchaseRequest = $purchaseOrderVendor->purchase_request;
        $items = \DB::table('item_purchase_request')
            ->where('purchase_request_id', $purchaseRequest->id)
            ->where('is_received', TRUE)
            ->get();
        return response()->json($items);
    }
}
