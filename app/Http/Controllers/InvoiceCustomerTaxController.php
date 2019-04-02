<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\InvoiceCustomerTax;
use App\Transaction;
use App\Cash;

class InvoiceCustomerTaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice-customer-tax.index');
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


    public function payInvoiceCustomerTax(Request $request)
    {
        $invoice_customer_tax = InvoiceCustomerTax::findOrFail($request->invoice_customer_tax_id);
        //find invoice customer code
        $invoice_customer_code = $invoice_customer_tax->invoice_customer->code;

        //updating process
        $invoice_customer_tax->cash_id = $request->cash_id;
        $invoice_customer_tax->status = 'paid';
        $invoice_customer_tax->save();

        return redirect('invoice-customer-tax')
            ->with('successMessage', "$invoice_customer_tax->source of $invoice_customer_code has been paid");
    }

    //the Approval of Invoice Customer Tax Pay
    public function payInvoiceCustomerTaxApproval(Request $request)
    {
        $invoice_customer_tax = InvoiceCustomerTax::findOrFail($request->invoice_customer_tax_id_to_approve);
            //find the  invoice customer code
            $invoice_customer_code = $invoice_customer_tax->invoice_customer->code;

        $this->register_to_transaction($invoice_customer_tax);
        //now update the approval of this invoice customer tax
        $invoice_customer_tax->approval = 'approved';
        $invoice_customer_tax->save();
        return redirect('invoice-customer-tax')
            ->with('successMessage', "$invoice_customer_tax->source of $invoice_customer_code has been approved");
    }

    protected function register_to_transaction($invoice_customer_tax)
    {
        $cash = Cash::find($invoice_customer_tax->cash_id);

        $transaction = new Transaction;
        $transaction->cash_id = $invoice_customer_tax->cash_id;
        $transaction->refference = 'invoice_customer_tax';
        $transaction->refference_id = $invoice_customer_tax->id;
        $transaction->refference_number = $invoice_customer_tax->invoice_customer->code;
        $transaction->type = 'debet';
        $transaction->amount = $invoice_customer_tax->amount;
        $transaction->reference_amount = $cash->amount - $invoice_customer_tax->amount;
        $transaction->save();

        //now fix the cash amount id,
        if($cash){
            $cash->amount = $cash->amount - $invoice_customer_tax->amount;
            $cash->save();
        }

    }
}
