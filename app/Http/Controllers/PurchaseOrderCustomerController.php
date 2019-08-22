<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePurchaseOrderCustomer;
use App\Http\Requests\UpdatePurchaseOrderCustomer;

use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\PurchaseOrderCustomer;
use App\Customer;
use App\QuotationCustomer;

class PurchaseOrderCustomerController extends Controller
{
    protected $purchase_order_customer_file_to_insert = NULL;
    protected $purchase_order_customer_file_to_delete = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase-order-customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_options = Customer::lists('name', 'id');
        $quotation_customer_opts = QuotationCustomer::lists('code', 'id');
        return view('purchase-order-customer.create')
            ->with('quotation_customer_opts', $quotation_customer_opts)
            ->with('customer_options', $customer_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseOrderCustomer $request)
    {
        if($request->hasFile('file')){
            $this->upload_process($request);
        }
        $new_po_customer = new PurchaseOrderCustomer;
        $new_po_customer->code = $request->code;
        $new_po_customer->customer_id = $request->customer_id;
        $new_po_customer->description = $request->description;
        $new_po_customer->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $new_po_customer->quotation_customer_id = $request->quotation_customer_id;
        $new_po_customer->received_date = $request->received_date;
        $new_po_customer->file = $this->purchase_order_customer_file_to_insert;
        $new_po_customer->save();
        $new_po_customer_id = $new_po_customer->id;
        $po_customer = PurchaseOrderCustomer::find($new_po_customer_id);

        return redirect('purchase-order-customer/'.$new_po_customer_id)
            ->with('successMessage', "Purchase Order Customer $po_customer->code has been created");
    }

    //File upload handling process
    protected function upload_process(Request $request){
        
        $file = $request->file('file');
        $upload_directory = public_path().'/files/purchase-order-customer/';
        $extension = $request->file('file')->getClientOriginalExtension();
        $this->purchase_order_customer_file_to_insert = time().'_'.$file->getClientOriginalName();

        //now move the uploaded file
        $file->move($upload_directory, $this->purchase_order_customer_file_to_insert);
        
    }
    //ENDFile upload handling process

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po_customer = PurchaseOrderCustomer::findOrFail($id);
        return view('purchase-order-customer.show')
            ->with('po_customer', $po_customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $po_customer = PurchaseOrderCustomer::findOrFail($id);
        $customer_options = Customer::lists('name', 'id');
        $quotation_customer_opts = QuotationCustomer::lists('code', 'id');
        return view('purchase-order-customer.edit')
            ->with('customer_options', $customer_options)
            ->with('quotation_customer_opts', $quotation_customer_opts)
            ->with('po_customer', $po_customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderCustomer $request, $id)
    {
        $po_customer = PurchaseOrderCustomer::findOrFail($id);
        $po_customer->code = $request->code;
        $po_customer->customer_id = $request->customer_id;
        $po_customer->description = $request->description;
        $po_customer->amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $po_customer->quotation_customer_id = $request->quotation_customer_id;
        $po_customer->save();
        return redirect('purchase-order-customer/'.$po_customer->id)
            ->with('successMessage', "Purchase Order Customer $po_customer->code has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $po_customer = PurchaseOrderCustomer::findOrFail($request->po_customer_id);
        $po_customer->delete();
        return redirect('purchase-order-customer')
            ->with('successMessage', "Purchase Order Customer $po_customer->code has been deleted");
    }

    public function downloadFile(Request $request)
    {
        $header = array();
        $file_name = $request->file_name;
        $pathToFile = public_path().'/files/purchase-order-customer/'.$file_name;
        
        $extension = \File::extension($pathToFile);
        if($extension == 'pdf'){
            $header = array('application/pdf');
            return response()->file($pathToFile, $header);
        }
        else if($extension == 'doc' || $extension == 'docx' || $extension == 'xlsx'){
            return response()->download($pathToFile);
        }
        else{
            echo "File not found";
        }
        
    }
    


    //PURCHASE ORDER CUSTOMER datatables
    public function dataTables(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $user_role = \Auth::user()->roles->first()->code;
        if($user_role == 'SUP' || $user_role == 'ADM' || $user_role == 'FIN'){
            $po_customers = PurchaseOrderCustomer::with('customer', 'quotation_customer', 'quotation_customer.sales', 'project')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_order_customers.*'
            ]);  
        }
        else{
            $po_customers = PurchaseOrderCustomer::with('customer', 'quotation_customer', 'quotation_customer.sales', 'project')->select([
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_order_customers.*'
            ])
            ->whereHas('quotation_customer', function($query){
                $query->where('sales_id', '=', \Auth::user()->id);
            });
        }
        

        $data_po_customers = Datatables::of($po_customers)
            ->editColumn('customer_id', function($po_customers){
                return $po_customers->customer ? $po_customers->customer->name : '';
            })
            ->editColumn('amount', function($po_customers){
                return number_format($po_customers->amount);
            })
            ->editColumn('quotation_customer', function($po_customers){
                if($po_customers->quotation_customer){
                    return $po_customers->quotation_customer->code;
                }
                return NULL;
            })
            ->editColumn('sales', function($po_customers){
                if($po_customers->quotation_customer && $po_customers->quotation_customer->sales){
                    return $po_customers->quotation_customer->sales->name;
                }
                return NULL;
            })
            ->editColumn('project_code', function($po_customers){
                if($po_customers->project){
                    return $po_customers->project->code;
                }else{
                    return NULL;
                }
            })
            ->addColumn('actions', function($po_customers){
                    $actions_html ='<a href="'.url('purchase-order-customer/'.$po_customers->id.'').'" class="btn btn-primary btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('purchase-order-customer/'.$po_customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this purchase-order-customer">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order-customer" data-id="'.$po_customers->id.'" data-text="'.$po_customers->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_po_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_po_customers->make(true);
    }
    //END PURCHASE ORDER CUSTOMER datatables
}
