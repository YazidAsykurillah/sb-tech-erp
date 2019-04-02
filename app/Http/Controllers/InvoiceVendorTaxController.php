<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\InvoiceVendorTax;
use App\Transaction;
use App\Cash;

class InvoiceVendorTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice-vendor-tax.index');
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
        //
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

    public function payInvoiceVendorTax(Request $request)
    {
        $invoice_vendor_tax = InvoiceVendorTax::findOrFail($request->invoice_vendor_tax_id);
        /*print_r($invoice_vendor_tax);
        exit();*/
        //find invoice vendor code
        $invoice_vendor_code = $invoice_vendor_tax->invoice_vendor->code;

        //updating process
        $invoice_vendor_tax->cash_id = $request->cash_id;
        $invoice_vendor_tax->status = 'paid';
        $invoice_vendor_tax->save();

        return redirect('invoice-vendor-tax')
            ->with('successMessage', "$invoice_vendor_tax->source of $invoice_vendor_code has been paid");
    }


    //the Approval of Invoice Vendor Tax Pay
    public function payInvoiceVendorTaxApproval(Request $request)
    {
        $invoice_vendor_tax = InvoiceVendorTax::findOrFail($request->invoice_vendor_tax_id_to_approve);
        // print_r($invoice_vendor_tax);
        // exit();
            //find the  invoice vendor code
            $invoice_vendor_code = $invoice_vendor_tax->invoice_vendor->code;

        $this->register_to_transaction($invoice_vendor_tax);
        //now update the approval of this invoice vendor tax
        $invoice_vendor_tax->approval = 'approved';
        $invoice_vendor_tax->save();
        return redirect('invoice-vendor-tax')
            ->with('successMessage', "$invoice_vendor_tax->source of $invoice_vendor_code has been approved");
    }

    protected function register_to_transaction($invoice_vendor_tax)
    {
        $cash = Cash::find($invoice_vendor_tax->cash_id);

        $transaction = new Transaction;
        $transaction->cash_id = $invoice_vendor_tax->cash_id;
        $transaction->refference = 'invoice_vendor_tax';
        $transaction->refference_id = $invoice_vendor_tax->id;
        $transaction->refference_number = $invoice_vendor_tax->invoice_vendor->code;
        $transaction->type = 'debet';
        $transaction->amount = $invoice_vendor_tax->amount;
        $transaction->reference_amount = $cash->amount - $invoice_vendor_tax->amount;
        $transaction->save();

        //now fix the cash amount id,
        if($cash){
            $cash->amount = $cash->amount - $invoice_vendor_tax->amount;
            $cash->save();
        }

    }
}
