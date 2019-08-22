<?php

namespace App\Listeners;

use App\Events\PayrollIsDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\SettlementPayroll;
class DeleteSettlementPayroll
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
     * @param  PayrollIsDeleted  $event
     * @return void
     */
    public function handle(PayrollIsDeleted $event)
    {
        $payroll = $event->payroll;
        SettlementPayroll::where('payroll_id','=',$payroll->id)->delete();
    }
}
