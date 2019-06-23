<?php

namespace App\Listeners;

use App\Events\PayrollIsDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\IncentiveWeekEnd;
class DeleteIncentiveWeekEnd
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
        IncentiveWeekEnd::where('payroll_id','=', $payroll->id)->delete();
    }
}
