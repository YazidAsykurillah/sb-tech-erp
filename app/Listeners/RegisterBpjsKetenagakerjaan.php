<?php

namespace App\Listeners;

use App\Events\PayrollIsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\BpjsKetenagakerjaan;
class RegisterBpjsKetenagakerjaan
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
     * @param  PayrollIsCreated  $event
     * @return void
     */
    public function handle(PayrollIsCreated $event)
    {
        $payroll = $event->payroll;
        $user = $payroll->user;
        $bpjs_kesehatan = new BpjsKetenagakerjaan;
        $bpjs_kesehatan->payroll_id = $payroll->id;
        $bpjs_kesehatan->amount = $user->bpjs_tk;
        $bpjs_kesehatan->save();
    }
}
