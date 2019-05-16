<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePurchaseRequestRequest;
use App\Http\Requests\UpdatePurchaseRequestRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\PurchaseRequest;
use App\Project;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase-request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $project_opts = Project::lists('code', 'id');
        return view('purchase-request.create')
            ->with('project_opts', $project_opts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequestRequest $request)
    {
        //Block build next purchase_request code
        $count_purchase_request_id = \DB::table('purchase_requests')->count();
        if(count($count_purchase_request_id)){
            $max = \DB::table('purchase_requests')->max('code');
            $int_max = ltrim(preg_replace('#[^0-9]#', '', $max),'0');
            $next_purchase_request_code = str_pad(($int_max+1), 5, 0, STR_PAD_LEFT);
        }
        else{
           $next_purchase_request_code = str_pad(1, 5, 0, STR_PAD_LEFT);
        }
        //ENDBlock build next purchase_request code
        $purchase_request = new PurchaseRequest;
        $purchase_request->code = 'PR-'.$next_purchase_request_code;
        $purchase_request->project_id = $request->project_id;
        $purchase_request->quotation_vendor_id = $request->quotation_vendor_id;
        $purchase_request->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_request->sub_amount = floatval(preg_replace('#[^0-9.]#', '', $request->total_sub_amount));
        $purchase_request->vat = $request->vat;
        $purchase_request->wht = floatval(preg_replace('#[^0-9.]#', '', $request->wht));
        $purchase_request->discount = $request->discount;
        $purchase_request->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $purchase_request->terms = $request->terms;
        $purchase_request->user_id = \Auth::user()->id;
        $purchase_request->save();
        $stored_id = $purchase_request->id;

        //sync item_purchase_request_table
        $this->sync_item_purchase_request($request, $stored_id);

        return redirect('purchase-request')
            ->with('successMessage', "Purchase Request has been created");
    }

    //Sync item invoice_customer_table from STORE mode
    protected function sync_item_purchase_request(Request $request, $purchase_request_id){
        //Block prepare invoice customer items
        $data_invoice_items = [];
        foreach($request->item as $key=>$value){
            if($request->item[$key] != ""){
                array_push($data_invoice_items, [
                    'purchase_request_id'=> $purchase_request_id,
                    'item'=>$request->item[$key],
                    'quantity'=>floatval(preg_replace('#[^0-9.]#', '', $request->quantity[$key])),
                    'unit'=>$request->unit[$key],
                    'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                    'sub_amount'=>floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount[$key])),
                ]);
            }
        }
        if(count($data_invoice_items)){
            \DB::table('item_purchase_request')->insert($data_invoice_items);
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
        $purchase_request = PurchaseRequest::findOrFail($id);
        $status_opts = ['pending'=>'Pending', 'approved'=>'Approved'];
        $items = \DB::table('item_purchase_request')->where('purchase_request_id', '=', $id)->get();
        return view('purchase-request.show')
            ->with('status_opts', $status_opts)
            ->with('purchase_request', $purchase_request)
            ->with('items', $items);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_request = PurchaseRequest::findOrFail($id);
        $project_opts = Project::lists('code', 'id');
        $items = \DB::table('item_purchase_request')->where('purchase_request_id', '=', $id)->get();
        return view('purchase-request.edit')
            ->with('purchase_request', $purchase_request)
            ->with('project_opts', $project_opts)
            ->with('items', $items);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequestRequest $request, $id)
    {
        $purchase_request = PurchaseRequest::findOrFail($id);
        $purchase_request->project_id = $request->project_id;
        $purchase_request->quotation_vendor_id = $request->quotation_vendor_id;
        $purchase_request->description = $request->description;
        $purchase_request->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_request->sub_amount = floatval(preg_replace('#[^0-9.]#', '', $request->total_sub_amount));
        $purchase_request->vat = $request->vat;
        $purchase_request->wht = floatval(preg_replace('#[^0-9.]#', '', $request->wht));
        $purchase_request->discount = $request->discount;
        $purchase_request->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $purchase_request->terms = $request->terms;
        $purchase_request->save();

        //resync item_purchase_request table
        $this->resync_item_purchase_request($request, $id);

        return redirect('purchase-request/'.$id)
            ->with('successMessage', "Purchase Request $purchase_request->code has been updated");
    }


    //Sync item invoice_customer_table from UPDATE mode
    protected function resync_item_purchase_request(Request $request, $purchase_request_id){

        //Delete all item_purchase_request recored where related to $purchase_request
        \DB::table('item_purchase_request')->where('purchase_request_id', '=', $purchase_request_id)->delete();
        //Block prepare purchase_request items
        $data_purchase_request_items = [];
        foreach($request->item as $key=>$value){
            if($request->item[$key] != ""){
                array_push($data_purchase_request_items, [
                    'purchase_request_id'=> $purchase_request_id,
                    'item'=>$request->item[$key],
                    'quantity'=>floatval(preg_replace('#[^0-9.]#', '', $request->quantity[$key])),
                    'unit'=>$request->unit[$key],
                    'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                    'sub_amount'=>floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount[$key])),
                ]);
            }
        }

        
        if(count($data_purchase_request_items)){
            \DB::table('item_purchase_request')->insert($data_purchase_request_items);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        $delete = $purchase_request->delete();
        return redirect('purchase-request')
            ->with('successMessage', "Purchase request $purchase_request->code has been deleted");
    }


    public function changeStatus(Request $request)
    {
        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        $purchase_request->status = $request->status;
        $purchase_request->save();
        return redirect('purchase-request/'.$request->id)
            ->with('successMessage', "Purchase request status has been changed");
    }

    public function getPurchaseRequestItems(Request $request)
    {
        $data = [];
        $data = \DB::table('item_purchase_request')->where('purchase_request_id', $request->purchase_request_id)->get();
        return $data;
    }


    public function updateItemPurchaseRequestIsReceived(Request $request)
    {
        $id = $request->ipr_id;
        $mode = $request->mode;
        if($mode == "checked"){
           return \DB::table('item_purchase_request')->where('id', $id)->update(['is_received'=>TRUE]);
        }else{
           return \DB::table('item_purchase_request')->where('id', $id)->update(['is_received'=>FALSE]);
        }
    }

    //PURCHASE REQUEST dataTables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM' || $user_role =='FIN'){
           $purchase_requests = PurchaseRequest::with('project', 'project.purchase_order_customer.customer', 'user', 'quotation_vendor', 'quotation_vendor.vendor', 'purchase_order_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_requests.*',
            ]);
       }else{
            //exit();
            $purchase_requests = PurchaseRequest::with('project', 'project.purchase_order_customer.customer', 'user', 'quotation_vendor', 'quotation_vendor.vendor', 'purchase_order_vendor')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_requests.*',
            ])->where('purchase_requests.user_id', \Auth::user()->id);
       }
        

        $data_purchase_requests = Datatables::of($purchase_requests)
            ->addColumn('user', function($purchase_requests){
                if($purchase_requests->user){
                    return $purchase_requests->user->name;
                }
                else{
                    return NULL;
                }
                
            })
            ->editColumn('code', function($purchase_requests){
                $link  = '';
                $link .= '<a href="'.url('purchase-request/'.$purchase_requests->id.'').'">';
                $link .=    $purchase_requests->code;
                $link .= '</a>';
                return $link;
            })
            ->editColumn('project_id', function($purchase_requests){
                if($purchase_requests->project){
                    return $purchase_requests->project->code;
                }
                
            })
            ->addColumn('quotation_vendor', function($purchase_requests){
                if($purchase_requests->quotation_vendor){
                    return $purchase_requests->quotation_vendor->code;
                }else{
                    return NULL;
                }
            })
            ->addColumn('vendor_name', function($purchase_requests){
                if($purchase_requests->quotation_vendor){
                    return $purchase_requests->quotation_vendor->vendor->name;
                }else{
                    return NULL;
                }
            })
            ->editColumn('description', function($purchase_requests){
                return str_limit($purchase_requests->description, 50);
            })
            ->editColumn('amount', function($purchase_requests){
                return number_format($purchase_requests->amount);
            })
            ->editColumn('created_at', function($settlements){
                return jakarta_date_time($settlements->created_at);
            })
            ->addColumn('purchase_order_vendor', function($purchase_requests){
                if($purchase_requests->purchase_order_vendor){
                    return $purchase_requests->purchase_order_vendor->code;    
                }
                return NULL;
                
            })
            ->addColumn('actions', function($purchase_requests){
                    $actions_html ='<a href="'.url('purchase-request/'.$purchase_requests->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($purchase_requests->status == 'pending'){
                        $actions_html .='<a href="'.url('purchase-request/'.$purchase_requests->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this purchase-request">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-request" data-id="'.$purchase_requests->id.'" data-text="'.$purchase_requests->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';    
                    }

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_purchase_requests->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_purchase_requests->make(true);
    }
    //END PURCHASE REQUEST dataTables

    public function select2Items(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("item_purchase_request")
                    ->where('item', 'LIKE', "%$search%")
                    ->select('id', 'item')
                    ->get();
        }
        else{
            $data = \DB::table('item_purchase_request')
                    ->where('is_received','=', TRUE)
                    ->select('id', 'item')
                    ->get();
        }
        return response()->json($data);
    }
}
