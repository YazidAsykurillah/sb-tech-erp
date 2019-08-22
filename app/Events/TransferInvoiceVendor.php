<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\InvoiceVendor;

class TransferInvoiceVendor extends Event
{
    use SerializesModels;

    public $invoice_vendor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(InvoiceVendor $invoice_vendor)
    {
        $this->invoice_vendor = $invoice_vendor;
        
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
