<?php

namespace App\Listeners;

use App\Events\InvoiceCustomerWasPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Transaction;
use App\Cash;

class RegisterTransactionFromInvoiceCustomer
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
     * @param  InvoiceCustomerWasPaid  $event
     * @return void
     */
    public function handle(InvoiceCustomerWasPaid $event)
    {
        //find the amount of the invoice
        $amount = $event->invoice_customer->amount;
        //find the cash
        $cash = Cash::findOrFail($event->invoice_customer->cash_id);


        //transaction registration
        $transaction = new Transaction;
        $transaction->cash_id = $event->invoice_customer->cash_id;
        $transaction->refference = "invoice_customer";
        $transaction->refference_id = $event->invoice_customer->id;
        $transaction->refference_number = $event->invoice_customer->code;
        $transaction->amount = floatval(preg_replace('#[^0-9.]#', '', $amount));
        $transaction->notes = $event->invoice_customer->description;
        $transaction->type = 'credit';
        $transaction->reference_amount = $cash->amount + floatval(preg_replace('#[^0-9.]#', '', $amount));
        $transaction->save();

        //synchronize cash
        $current_cash_amount = $cash->amount;
        //now update the cash_amount
        $cash->amount = $current_cash_amount + $amount;
        $cash->save();

    }
}
