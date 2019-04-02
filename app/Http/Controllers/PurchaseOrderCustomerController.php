<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StorePurchaseOrderCustomer;
use App\Http\Requests\UpdatePurchaseOrderCustomer;

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
    
}
