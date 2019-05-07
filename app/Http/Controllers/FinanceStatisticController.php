<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Project;
use App\InvoiceCustomer;
use App\InvoiceVendor;
use App\PurchaseRequest;
use App\PurchaseOrderVendor;
use App\Cash;
use App\InvoiceCustomerTax;
use App\InvoiceVendorTax;

class FinanceStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //total invoice due from projects
        $tot_not_invoiced_from_pro = $this->tot_not_invoiced_from_pro();


        //total invoice customer with status of pending
        $tot_pending_invoice_customer = $this->tot_pending_invoice_customer();

        //total invoice vendor with status of pending
        $tot_pending_invoice_vendor = $this->tot_pending_invoice_vendor();

        //total amount of purchase order vendor that has no invoice vendor
        $tot_purchase_order_vendor_amount = $this->tot_purchase_order_vendor_amount();
        $tot_invoice_vendor_amount = $this->tot_invoice_vendor_amount();
        $tot_un_invoiced_po_vendor = $this->tot_un_invoiced_po_vendor();

        //total amount from all cashes
        $tot_cash_amounts = $this->tot_cash_amounts();

        //invoice customer taxes amount
        $tot_invoice_customer_tax_amount = $this->tot_invoice_customer_tax_amount();

        //invoice vendor taxes amount
        $tot_invoice_vendor_tax_amount = $this->tot_invoice_vendor_tax_amount();

        $tax_balance = abs($tot_invoice_vendor_tax_amount - $tot_invoice_customer_tax_amount);


        //now get the balance
        $balance = $tot_not_invoiced_from_pro+$tot_cash_amounts-$tot_pending_invoice_vendor-$tot_un_invoiced_po_vendor+$tot_pending_invoice_customer-$tax_balance;

        return view('finance-statistic.index')
            ->with('tot_not_invoiced_from_pro', $tot_not_invoiced_from_pro)
            ->with('tot_pending_invoice_customer', $tot_pending_invoice_customer)
            ->with('tot_pending_invoice_vendor', $tot_pending_invoice_vendor)
            ->with('tot_invoice_vendor_amount', $tot_invoice_vendor_amount)
            ->with('tot_purchase_order_vendor_amount', $tot_purchase_order_vendor_amount)
            ->with('tot_un_invoiced_po_vendor', $tot_un_invoiced_po_vendor)
            ->with('tot_cash_amounts', $tot_cash_amounts)
            ->with('tot_invoice_customer_tax_amount', $tot_invoice_customer_tax_amount)
            ->with('tot_invoice_vendor_tax_amount', $tot_invoice_vendor_tax_amount)
            ->with('tax_balance', $tax_balance)
            ->with('balance', $balance);

    }

    protected function tot_invoice_vendor_tax_amount()
    {
        $result = InvoiceVendorTax::sum('amount');
        return $result;

    }

    protected function tot_invoice_customer_tax_amount()
    {
        $result = InvoiceCustomerTax::sum('amount');
        return $result;

    }

    protected function tot_invoice_vendor_amount()
    {
        $result = InvoiceVendor::sum('amount');
        return $result;
    }
    protected function tot_purchase_order_vendor_amount()
    {
        $total_amount_purchase_request_arr = [];
        $purchase_order_vendors = PurchaseOrderVendor::all();
        foreach($purchase_order_vendors as $purchase_order_vendor){
            $total_amount_purchase_request_arr[] = $purchase_order_vendor->purchase_request ? $purchase_order_vendor->purchase_request->amount : 0;
        }
        $result = array_sum($total_amount_purchase_request_arr);
        return $result;
    }

    protected function tot_cash_amounts()
    {
        $result = Cash::sum('amount');
        return $result;
    }

    protected function tot_un_invoiced_po_vendor()
    {
        $tot_invoice_vendor_amount = $this->tot_invoice_vendor_amount();
        $tot_purchase_order_vendor_amount = $this->tot_purchase_order_vendor_amount();
        return $tot_purchase_order_vendor_amount - $tot_invoice_vendor_amount;
    }

    protected function tot_pending_invoice_vendor()
    {
        $result = InvoiceVendor::where('status', '=', 'pending')->sum('amount');
        return $result;
    }

    protected function tot_pending_invoice_customer()
    {
        $result = InvoiceCustomer::where('status', '=', 'pending')->sum('amount');
        return $result;
    }

    
            
    /*protected function tot_not_invoiced_from_pro()
    {
        $result = 0;
        $tot_not_invoiced_from_pro_arr = [];
        $projects = Project::all();
        if($projects){
           foreach($projects as $project){
                $po_customer_amount = $project->purchase_order_customer ? $project->purchase_order_customer->amount : 0;
                $total_paid_invoice = $project->paid_invoice_customer() ? $project->paid_invoice_customer() : 0;
                $total_pending_invoice = $project->pending_invoice_customer() ? $project->pending_invoice_customer() : 0;
                $invoiced = ($total_paid_invoice+$total_pending_invoice);
                $tot_not_invoiced_from_pro_arr[] = $po_customer_amount - $invoiced;
            } 
        }
        if(count($tot_not_invoiced_from_pro_arr)){
            $result = array_sum($tot_not_invoiced_from_pro_arr);
        }
        return $result;
    }*/

    protected function tot_not_invoiced_from_pro()
    {
        $result = 0;
        $tot_not_invoiced_from_pro_arr = [];
        //$projects = Project::all();
        $projects = Project::where('is_completed', FALSE)->get();
        if($projects){
           foreach($projects as $project){
                $po_customer_amount = $project->purchase_order_customer ? $project->purchase_order_customer->amount : 0;
                $total_paid_invoice = $project->paid_invoice_customer() ? $project->paid_invoice_customer() : 0;
                $total_pending_invoice = $project->pending_invoice_customer() ? $project->pending_invoice_customer() : 0;
                $invoiced = ($total_paid_invoice+$total_pending_invoice);
                $tot_not_invoiced_from_pro_arr[] = $po_customer_amount - $invoiced;
                //$tot_not_invoiced_from_pro_arr[] = $po_customer_amount - $total_pending_invoice;
                
            } 
        }
        if(count($tot_not_invoiced_from_pro_arr)){
            $result = array_sum($tot_not_invoiced_from_pro_arr);
        }
        return $result;
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
}
