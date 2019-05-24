<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Http\Requests\StoreInvoiceCustomerRequest;
use App\Http\Requests\UpdateInvoiceCustomerRequest;



use App\InvoiceCustomer;
use App\Project;
use App\User;
use App\InvoiceCustomerTax;
use App\Cash;

use Event;
use App\Events\InvoiceCustomerWasPaid;

class InvoiceCustomerController extends Controller
{
    
    protected $invoice_customer_file_to_insert = NULL;
    protected $invoice_customer_file_to_delete = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice-customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $total_paid_invoice = $this->get_total_paid_invoice($project);
        $total_invoice_due = $this->get_total_invoice_due($project);
        return view('invoice-customer.create')
            ->with('project', $project)
            ->with('total_paid_invoice', $total_paid_invoice)
            ->with('total_invoice_due', $total_invoice_due);
    }

    protected function get_total_paid_invoice($project)
    {
        $total_paid_invoice = 0;
        //check if project has already invoice
        if($project->invoice_customer->count())
        {
            $total_paid_invoice = floatval(\DB::table('invoice_customers')->where('project_id', $project->id)->where('status', 'paid')->sum('amount'));
           
        }
        return $total_paid_invoice;
    }

    protected function get_total_invoice_due($project)
    {
        //check if project has already invoice
        if($project->invoice_customer->count())
        {
            $po_customer_amount = $project->purchase_order_customer ? $project->purchase_order_customer->amount : 0;
            //get sum of the PAID invoice customer based on this project
            $paid_invoice_amount = floatval(\DB::table('invoice_customers')->where('project_id', $project->id)->where('status', 'paid')->sum('amount'));
            $total_invoice_due = $po_customer_amount-$paid_invoice_amount;
            return $total_invoice_due;
        }
        else{
            if($project->purchase_order_customer){
                return $project->purchase_order_customer->amount;
            }
            else{
                return 0;
            }
            
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceCustomerRequest $request)
    {

        if($request->hasFile('file')){
            $this->upload_process($request);
        }
        //Block build next invoice_customer code
        $today = date('Y-m-d');
        
        $this_month = substr($today, 0, 7);

        $ivc_format = substr($this_month, 2, 2)."-".substr($this_month, 5, 2);
        
        $next_invoice_customer_number = "";
        $invoice_customers = \DB::table('invoice_customers')->where('created_at', 'like', "%$this_month%")->where('code','like',"%BMKN-%");
        //if counted invoice_customers created in this month is 0, simply make it 001 to the next invoice_customer number param.
        if($invoice_customers->count() == 0){
            $next_invoice_customer_number = str_pad(1, 3, 0, STR_PAD_LEFT);
        }
        else{
            $max = $invoice_customers->max('code');
            $int_max = ltrim(substr($max, -3), '0');
            $next_invoice_customer_number = str_pad(($int_max+1), 3, 0, STR_PAD_LEFT);
        }
        /*echo $next_invoice_customer_number;
        exit();*/
        $invoice_customer = new InvoiceCustomer;
        $invoice_customer->code = "BMKN-INV-".$ivc_format."-".$next_invoice_customer_number;
        $invoice_customer->project_id = $request->project_id;
        $invoice_customer->sub_amount = floatval(preg_replace('#[^0-9.]#', '',$request->total_sub_amount));
        $invoice_customer->vat = floatval(preg_replace('#[^0-9.]#', '',$request->vat));
        $invoice_customer->wht = floatval(preg_replace('#[^0-9.]#', '',$request->wht));
        $invoice_customer->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $invoice_customer->description = $request->description ? $request->description : NULL;

        $discount = floatval(preg_replace('#[^0-9.]#', '',$request->discount));
        $invoice_customer->discount = $discount;
        $invoice_customer->discount_value = ($discount/100) * floatval(preg_replace('#[^0-9.]#', '',$request->total_sub_amount));

        $invoice_customer->after_discount = floatval(preg_replace('#[^0-9.]#', '',$request->after_discount));
        $invoice_customer->down_payment = floatval(preg_replace('#[^0-9.]#', '',$request->down_payment));
        $invoice_customer->down_payment_value = floatval(preg_replace('#[^0-9.]#', '',$request->down_payment_value));
        $invoice_customer->type = $request->type;
        $invoice_customer->vat_value = floatval(preg_replace('#[^0-9.]#', '',$request->vat_value));
        $invoice_customer->posting_date = date_create($request->posting_date);
        $invoice_customer->tax_number = $request->tax_number;
        $invoice_customer->tax_date = date_create($request->tax_date);
        $invoice_customer->due_date = date_create($request->due_date);
        $invoice_customer->file = $this->invoice_customer_file_to_insert;
        $invoice_customer->save();
        $last_inserted_id = $invoice_customer->id;

        //sync item_invoice_customer_table
        $this->sync_item_invoice_customer($request, $last_inserted_id);

        return redirect('invoice-customer/'.$last_inserted_id)
            ->with('successMessage', "Invoice Customer has been saved");            
       
    }

    //File upload handling process
    protected function upload_process(Request $request){
        
        $file = $request->file('file');
        $upload_directory = public_path().'/files/invoice-customer/';
        $extension = $request->file('file')->getClientOriginalExtension();
        $this->invoice_customer_file_to_insert = time().'_'.$file->getClientOriginalName();

        //now move the uploaded file
        $file->move($upload_directory, $this->invoice_customer_file_to_insert);
        
    }
    //ENDFile upload handling process

    //Sync item invoice_customer_table from STORE mode
    protected function sync_item_invoice_customer(Request $request, $invoice_customer_id){
        //Block prepare invoice customer items
        $data_invoice_items = [];
        foreach($request->item as $key=>$value){
            if($request->item[$key] != ""){
                array_push($data_invoice_items, [
                    'invoice_customer_id'=> $invoice_customer_id,
                    'item'=>$request->item[$key],
                    'quantity'=>floatval(preg_replace('#[^0-9.]#', '', $request->quantity[$key])),
                    'unit'=>$request->unit[$key],
                    'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                    'sub_amount'=>floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount[$key])),
                ]);
            }
        }
        if(count($data_invoice_items)){
            \DB::table('item_invoice_customer')->insert($data_invoice_items);
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
        $invoice_customer = InvoiceCustomer::findOrFail($id);
        $items = \DB::table('item_invoice_customer')->where('invoice_customer_id', '=', $id)->get();
        $cash_opts = Cash::where('type','bank')->lists('name', 'id');
        return view('invoice-customer.show')
            ->with('invoice_customer', $invoice_customer)
            ->with('cash_opts', $cash_opts)
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
        
        $invoice_customer = InvoiceCustomer::findOrFail($id);
        $items = \DB::table('item_invoice_customer')->where('invoice_customer_id', '=', $id)->get();
        $project_opts = Project::lists('code', 'id');
        $project = Project::findOrFail($invoice_customer->project->id);

        $total_paid_invoice = $this->get_total_paid_invoice($project);
        $total_invoice_due = $this->get_total_invoice_due($project);

        $preparator_opts = User::lists('name', 'id');

        return view('invoice-customer.edit')
            ->with('project', $project)
            ->with('project_opts', $project_opts)
            ->with('total_paid_invoice', $total_paid_invoice)
            ->with('total_invoice_due', $total_invoice_due)
            ->with('invoice_customer', $invoice_customer)
            ->with('items', $items)
            ->with('preparator_opts', $preparator_opts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceCustomerRequest $request, $id)
    {
        $invoice_customer = InvoiceCustomer::findOrFail($id);
        $invoice_customer->project_id = $request->project_id;
        $invoice_customer->sub_amount = floatval(preg_replace('#[^0-9.]#', '',$request->total_sub_amount));
        $invoice_customer->vat = floatval(preg_replace('#[^0-9.]#', '',$request->vat));
        $invoice_customer->wht = floatval(preg_replace('#[^0-9.]#', '',$request->wht));
        $invoice_customer->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $invoice_customer->description = $request->description;
        $invoice_customer->prepared_by = $request->prepared_by;
        $invoice_customer->discount = floatval(preg_replace('#[^0-9.]#', '',$request->discount));
        $invoice_customer->discount_value = ($request->discount/100) * floatval(preg_replace('#[^0-9.]#', '',$request->total_sub_amount));
        $invoice_customer->after_discount = floatval(preg_replace('#[^0-9.]#', '',$request->after_discount));
        $invoice_customer->down_payment = floatval(preg_replace('#[^0-9.]#', '',$request->down_payment));
        $invoice_customer->down_payment_value = floatval(preg_replace('#[^0-9.]#', '',$request->down_payment_value));
        $invoice_customer->type = $request->type;
        $invoice_customer->vat_value = floatval(preg_replace('#[^0-9.]#', '',$request->vat_value));
        $invoice_customer->posting_date = date_create($request->posting_date);
        $invoice_customer->tax_number = $request->tax_number;
        $invoice_customer->tax_date = date_create($request->tax_date);
        $invoice_customer->due_date = date_create($request->due_date);
        $invoice_customer->save();
        //sync item_invoice_customer_table
        $this->resync_item_invoice_customer($request, $id);

        return redirect('invoice-customer/'.$id)
            ->with('successMessage', "Invoice has been updated");
    }

    //Sync item invoice_customer_table from UPDATE mode
    protected function resync_item_invoice_customer(Request $request, $invoice_customer_id){
        //Delete all item_invoice_customer recored where related to $invoice_customer_id
        \DB::table('item_invoice_customer')->where('invoice_customer_id', '=', $invoice_customer_id)->delete();
        //Block prepare invoice customer items
        $data_invoice_items = [];
        foreach($request->item as $key=>$value){
            if($request->item[$key] != ""){
                array_push($data_invoice_items, [
                    'invoice_customer_id'=> $invoice_customer_id,
                    'item'=>$request->item[$key],
                    'quantity'=>floatval(preg_replace('#[^0-9.]#', '', $request->quantity[$key])),
                    'unit'=>$request->unit[$key],
                    'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                    'sub_amount'=>floatval(preg_replace('#[^0-9.]#', '', $request->sub_amount[$key])),
                ]);
            }
        }
        if(count($data_invoice_items)){
            \DB::table('item_invoice_customer')->insert($data_invoice_items);
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
        $invoice_customer = InvoiceCustomer::findOrFail($request->invoice_customer_id);
        $invoice_customer->delete();
        return redirect('invoice-customer')
            ->with('successMessage', "Invoice $invoice_customer->code has been deleted");
    }

    public function select2ProjectForInvoiceCustomer(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = \DB::table("projects")
                    ->select("id","code")
                    ->where('code','LIKE',"%$search%")
                    ->get();
        }
        else{
            $search = $request->q;
            $data = \DB::table("projects")
                    ->select("id","code")
                    ->get();
        }
        return response()->json($data);
    }


    public function setPaidInvoiceCustomer(Request $request)
    {
        $invoice_customer = InvoiceCustomer::findOrFail($request->invoice_customer_id);
            //Block register to tax lists
            if($invoice_customer->vat !=0){
                $this->register_to_tax_list_from_vat($invoice_customer);
            }
            if($invoice_customer->wht !=0){
                $this->register_to_tax_list_from_wht($invoice_customer);
            }
            //ENDBlock register to tax lists
        $invoice_customer->status = 'paid';
        $invoice_customer->accounted = true;
        $invoice_customer->cash_id = $request->cash_id;

        $invoice_customer->save();

        //Fire the event transver invoice vendor
        Event::fire(new InvoiceCustomerWasPaid($invoice_customer));

        return redirect()->back()
            ->with('successMessage', "Invoice has been marked as PAID");

            
    }


    protected function register_to_tax_list_from_vat($invoice_customer){
        $invoice_customer_tax = new InvoiceCustomerTax;
        $invoice_customer_tax->tax_number = $invoice_customer->tax_number;
        $invoice_customer_tax->invoice_customer_id = $invoice_customer->id;
        $invoice_customer_tax->source = 'vat';
        $invoice_customer_tax->percentage = $invoice_customer->vat;
        $invoice_customer_tax->amount = $invoice_customer->vat_value;
        $invoice_customer_tax->save();
    }

     protected function register_to_tax_list_from_wht($invoice_customer){
        $invoice_customer_tax = new InvoiceCustomerTax;
        $invoice_customer_tax->tax_number = $invoice_customer->tax_number;
        $invoice_customer_tax->invoice_customer_id = $invoice_customer->id;
        $invoice_customer_tax->source = 'wht';
        $invoice_customer_tax->amount = $invoice_customer->wht;
        $invoice_customer_tax->save();
    }

    public function in_week_overdue()
    {
        $now_date = Carbon::now();
        $from = $now_date->toDateString();
        $next_week = $now_date->addDays(7)->toDateString();

        return view('invoice-customer.in_week_overdue')
            ->with('from', $from)
            ->with('next_week', $next_week);
    }

    public function over_last_week_overdue()
    {
        $now_date = Carbon::now();
        $last_week = $now_date->subWeek(1)->toDateString();

        return view('invoice-customer.over_last_week_overdue')
            ->with('last_week', $last_week);
    }


    public function print_pdf($id)
    {   
        error_reporting(0);
        $invoice_customer = InvoiceCustomer::findOrFail($id);
        $data['invoice_customer']= $invoice_customer;
        $data['item_invoice_customer'] = \DB::table('item_invoice_customer')->where('invoice_customer_id','=', $id)->get();
        $pdf = \PDF::loadView('pdf.invoice_customer', $data)->setPaper('a4', 'portrait')->setWarnings(false);
        return $pdf->stream($invoice_customer->code.'.pdf');
    }

    public function downloadFile(Request $request)
    {
        $header = array();
        $file_name = $request->file_name;
        $pathToFile = public_path().'/files/invoice-customer/'.$file_name;
        
        $extension = \File::extension($pathToFile);
        if($extension == 'pdf'){
            $header = array('application/pdf');
            return response()->file($pathToFile, $header);
        }
        else if($extension == 'doc' || $extension == 'docx' || $extension == 'xlsx'){
            return response()->download($pathToFile);
        }
        elseif ($extension == 'jpg' || $extension=='jpeg' || $extension == 'png') {
            return response()->file($pathToFile);
        }
        else{
            echo "File not found";
        }
        
    }

    //INVOICE CUSTOMER datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_customers = InvoiceCustomer::with('project','project.purchase_order_customer', 'project.purchase_order_customer.customer')->select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'invoice_customers.*',
        ]);


        $data_invoice_customers = Datatables::of($invoice_customers)
            ->editColumn('project_id', function($invoice_customers){

                //return $invoice_customers->project->code;return $invoice_customers->project->code;
                if($invoice_customers->project){
                    return $invoice_customers->project->code;
                }

            })
            ->addColumn('po_customer', function($invoice_customers){
                if($invoice_customers->project){
                    return $invoice_customers->project->purchase_order_customer ? $invoice_customers->project->purchase_order_customer->code : null;
                }
                
            })
            ->addColumn('customer_name', function($invoice_customers){
                if($invoice_customers->project){
                    if($invoice_customers->project->purchase_order_customer){
                        return $invoice_customers->project->purchase_order_customer->customer ? $invoice_customers->project->purchase_order_customer->customer->name : '';
                    }
                    return null;
                    
                }
            })
            ->editColumn('sub_amount', function($invoice_customers){
                return number_format($invoice_customers->sub_amount);
            })
            ->editColumn('amount', function($invoice_customers){
                return number_format($invoice_customers->amount);
            })
            ->editColumn('accounted', function($invoice_customers){
                return $invoice_customers->accounted == TRUE ? '<i class="fa fa-check" title="Accounted"></i>' : '<i class="fa fa-hourglass" title="Not acounted yet"></i>';
            })
            ->addColumn('actions', function($invoice_customers){
                    $actions_html ='<a href="'.url('invoice-customer/'.$invoice_customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    if($invoice_customers->status !='paid'){
                        $actions_html .='<a href="'.url('invoice-customer/'.$invoice_customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-customer">';
                        $actions_html .=    '<i class="fa fa-edit"></i>';
                        $actions_html .='</a>&nbsp;';
                    }
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-customer" data-id="'.$invoice_customers->id.'" data-text="'.$invoice_customers->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_customers->make(true);
    }
    //END INVOICE CUSTOMER datatables
}
