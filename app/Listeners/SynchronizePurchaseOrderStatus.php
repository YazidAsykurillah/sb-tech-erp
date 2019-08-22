<?php

namespace App\Listeners;

use App\Events\TransferInvoiceVendor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\PurchaseOrderVendor;

class SynchronizePurchaseOrderStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TransferInvoiceVendor  $event
     * @return void
     */
    public function handle(TransferInvoiceVendor $event)
    {
        //find amount of the invoice
        $invoice_vendor_amount = $event->invoice_vendor->amount;

        //find amount of it's purchase order amount
        $purchase_order_vendor = PurchaseOrderVendor::findOrFail($event->invoice_vendor->purchase_order_vendor->id);
        $purchase_order_vendor_amount = $purchase_order_vendor->amount;
        //

        //get paid invoive vendor amount related to this PurchaseOrderVendor
        $paid_invoice_vendor_amount = $purchase_order_vendor->paid_invoice_vendor();
        if($paid_invoice_vendor_amount == $purchase_order_vendor_amount || $paid_invoice_vendor_amount > $purchase_order_vendor_amount){
            $purchase_order_vendor->status = 'completed';
            $purchase_order_vendor->save();
        }else{
            $purchase_order_vendor->status = 'uncompleted';
            $purchase_order_vendor->save();
        }

        /*if($invoice_vendor_amount == $purchase_order_vendor_amount || $invoice_vendor_amount > $purchase_order_vendor_amount){
            $purchase_order_vendor->status = 'completed';
            $purchase_order_vendor->save();
        }else{
            $purchase_order_vendor->status = 'uncompleted';
            $purchase_order_vendor->save();
        }*/
    }
}
