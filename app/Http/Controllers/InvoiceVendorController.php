<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreInvoiceVendorRequest;
use App\Http\Requests\UpdateInvoiceVendorRequest;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\InvoiceVendor;
use App\InvoiceVendorTax;
use App\Project;
use App\PurchaseOrderVendor;
use App\TheLog;

class InvoiceVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice-vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project_opts = Project::lists('code', 'id');
        $purchase_order_vendor_opts = PurchaseOrderVendor::lists('code', 'id');
        return view('invoice-vendor.create')
            ->with('project_opts', $project_opts)
            ->with('purchase_order_vendor_opts', $purchase_order_vendor_opts);
    }

    public function createFromPOV(Request $request)
    {   
        
        $purchase_order_vendor = PurchaseOrderVendor::findOrFail($request->pov_id);
        return view('invoice-vendor.create_from_pov')
            ->with('purchase_order_vendor', $purchase_order_vendor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceVendorRequest $request)
    {
        // dd($request->all());
        $invoice_vendor = new InvoiceVendor;
        $invoice_vendor->code = $request->code;
        $invoice_vendor->tax_number = $request->tax_number;
        $invoice_vendor->project_id = $request->project_id;
        $invoice_vendor->purchase_order_vendor_id = $request->purchase_order_vendor_id;        
        $invoice_vendor->sub_total = floatval(preg_replace('#[^0-9.]#', '', $request->sub_total));
        $invoice_vendor->discount = floatval(preg_replace('#[^0-9.]#', '', $request->discount));
        $invoice_vendor->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $invoice_vendor->vat = floatval(preg_replace('#[^0-9.]#', '', $request->vat));
        $invoice_vendor->vat_amount = floatval(preg_replace('#[^0-9.]#', '', $request->vat_amount));
        $invoice_vendor->wht_amount = floatval(preg_replace('#[^0-9.]#', '', $request->wht_amount));

        $invoice_vendor->amount_before_type = floatval(preg_replace('#[^0-9.]#', '', $request->amount_before_type));
        $invoice_vendor->type = $request->type;
        $invoice_vendor->type_percent = $request->type_percent;
        $invoice_vendor->amount_from_type = floatval(preg_replace('#[^0-9.]#', '', $request->amount_from_type));
        
        $invoice_vendor->bill_amount = floatval(preg_replace('#[^0-9.]#', '', $request->bill_amount));
        $invoice_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $invoice_vendor->received_date = date_create($request->received_date);
        $invoice_vendor->due_date = date_create($request->due_date);
        $invoice_vendor->tax_date = date_create($request->tax_date);
        $invoice_vendor->save();
        $inserted_id = $invoice_vendor->id;
        
        //register to the_logs table;
        $log_description = "&nbsp;";
        $log = $this->register_to_the_logs('invoice_vendor', 'create', $inserted_id, $log_description );

        return redirect('invoice-vendor/'.$inserted_id)
            ->with('successMessage', "Invoice vendor has been created");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($id);
        $the_logs = TheLog::where('source', '=', 'invoice_vendor')
                    ->where('refference_id','=', $id)->get();
        return view('invoice-vendor.show')
            ->with('invoice_vendor', $invoice_vendor)
            ->with('the_logs', $the_logs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($id);
        $project_opts = Project::lists('code', 'id');
        $purchase_order_vendor_opts = PurchaseOrderVendor::lists('code', 'id');
        return view('invoice-vendor.edit')
            ->with('project_opts', $project_opts)
            ->with('purchase_order_vendor_opts', $purchase_order_vendor_opts)
            ->with('invoice_vendor', $invoice_vendor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceVendorRequest $request, $id)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($id);
        $invoice_vendor->code = $request->code;
        $invoice_vendor->tax_number = $request->tax_number;
        $invoice_vendor->project_id = $request->project_id;
        $invoice_vendor->purchase_order_vendor_id = $request->purchase_order_vendor_id;        
        $invoice_vendor->sub_total = floatval(preg_replace('#[^0-9.]#', '', $request->sub_total));
        $invoice_vendor->discount = floatval(preg_replace('#[^0-9.]#', '', $request->discount));
        $invoice_vendor->after_discount = floatval(preg_replace('#[^0-9.]#', '', $request->after_discount));
        $invoice_vendor->vat = floatval(preg_replace('#[^0-9.]#', '', $request->vat));
        $invoice_vendor->vat_amount = floatval(preg_replace('#[^0-9.]#', '', $request->vat_amount));
        $invoice_vendor->wht_amount = floatval(preg_replace('#[^0-9.]#', '', $request->wht_amount));

        $invoice_vendor->amount_before_type = floatval(preg_replace('#[^0-9.]#', '', $request->amount_before_type));
        $invoice_vendor->type = $request->type;
        $invoice_vendor->type_percent = $request->type_percent;
        $invoice_vendor->amount_from_type = floatval(preg_replace('#[^0-9.]#', '', $request->amount_from_type));
        
        $invoice_vendor->bill_amount = floatval(preg_replace('#[^0-9.]#', '', $request->bill_amount));
        $invoice_vendor->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $invoice_vendor->received_date = date_create($request->received_date);
        $invoice_vendor->due_date = date_create($request->due_date);
        $invoice_vendor->tax_date = date_create($request->tax_date);
        $invoice_vendor->save();
        return redirect('invoice-vendor/'.$id)
            ->with('successMessage', "Invoice vendor has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice_vendor = InvoiceVendor::findOrFail($request->invoice_vendor_id);
        $invoice_vendor->delete();

        //delete related invoice_vendor_taxes
        $delete_invoice_vendor_taxes = \DB::table('invoice_vendor_taxes')->where('invoice_vendor_id', '=', $request->invoice_vendor_id)->delete();
        
        return redirect('invoice-vendor')
            ->with('successMessage', "Invoice Vendor $invoice_vendor->code has been deleted");
    }

    


    public function in_week_overdue()
    {
        $now_date = Carbon::now();
        $from = $now_date->toDateString();
        $next_week = $now_date->addDays(7)->toDateString();

        return view('invoice-vendor.in_week_overdue')
            ->with('from', $from)
            ->with('next_week', $next_week);
    }

    public function changeInvoiceVendorStatus(Request $request)
    {
        $id = $request->invoice_vendor_id;
        $invoice_vendor = InvoiceVendor::findOrFail($id);
        //get old internal request status.
        $old_status = $invoice_vendor->status;

        $invoice_vendor->status = $request->status;
        $invoice_vendor->save();

        //register to the_logs table;
        $log_description = "Change status from $old_status to $request->status";
        $log = $this->register_to_the_logs('invoice_vendor', 'update', $id, $log_description );

        return redirect()->back()
            ->with('successMessage', "Internal request status has been changed to $request->status");
    }

    protected function register_to_the_logs($source = NULL,  $mode = NULL, $refference_id = NULL, $description = NULL)
    {
        $the_log = new TheLog;
        $the_log->source = $source;
        $the_log->mode = $mode;
        $the_log->refference_id = $refference_id;
        $the_log->user_id = \Auth::user()->id;
        $the_log->description = $description;
        $the_log->save();
       
    }
    

    //INVOICE VENDOR datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_vendors = InvoiceVendor::with('project', 'purchase_order_vendor', 'purchase_order_vendor.vendor')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_vendors.*',
        ]);

        $data_invoice_vendors = Datatables::of($invoice_vendors)
            ->editColumn('type', function($invoice_vendors){
                $disp = '';
                $disp .= '<p>';
                $disp .=    ucwords($invoice_vendors->type);     
                $disp .= '</p>';
                if($invoice_vendors->type == 'billing'){
                    $disp .= number_format($invoice_vendors->bill_amount);
                }else{
                    $disp .= $invoice_vendors->type_percent .'%';
                }
                return $disp;
            })
            ->editColumn('project_id', function($invoice_vendors){
                if($invoice_vendors->project){
                    return $invoice_vendors->project->code;
                }
                
            })
            ->editColumn('purchase_order_vendor_id', function($invoice_vendors){
                if($invoice_vendors->purchase_order_vendor){
                    return $invoice_vendors->purchase_order_vendor->code;
                }
            })
            ->editColumn('amount', function($invoice_vendors){
                return number_format($invoice_vendors->amount,2);
            })
            ->addColumn('vendor', function($invoice_vendors){
                if($invoice_vendors->purchase_order_vendor){
                    if($invoice_vendors->purchase_order_vendor->vendor){
                        return $invoice_vendors->purchase_order_vendor->vendor->name;
                    }
                    return NULL;
                }
                return NULL;

                
            })
            ->editColumn('status', function($invoice_vendors){
                $status_disp = "";
                if($invoice_vendors->status == 'paid'){
                    $status_disp .= $invoice_vendors->status .'<br/>';
                    if($invoice_vendors->remitter_bank){
                        $status_disp .= "(";
                        $status_disp .= $invoice_vendors->remitter_bank->name;
                        $status_disp .= ")";
                    }
                    

                }
                else{
                    $status_disp = $invoice_vendors->status;
                }
                return $status_disp;
            })
            ->editColumn('accounted', function($invoice_vendors){
                return $invoice_vendors->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($invoice_vendors){
                    $actions_html ='<a href="'.url('invoice-vendor/'.$invoice_vendors->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($invoice_vendors->status !='paid'){
                        $actions_html .='<a href="'.url('invoice-vendor/'.$invoice_vendors->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-vendor">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                        $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-vendor" data-id="'.$invoice_vendors->id.'" data-text="'.$invoice_vendors->code.'">';
                        $actions_html .=    '<i class="fa fa-trash"></i>';
                        $actions_html .='</button>';
                    }
                    

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_vendors->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_vendors->make(true);
    }
    //END INVOICE VENDOR datatables
}
