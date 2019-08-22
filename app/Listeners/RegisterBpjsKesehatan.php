<?php

namespace App\Listeners;

use App\Events\PayrollIsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\BpjsKesehatan;

class RegisterBpjsKesehatan
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
        $bpjs_kesehatan = new BpjsKesehatan;
        $bpjs_kesehatan->payroll_id = $payroll->id;
        $bpjs_kesehatan->amount = $user->bpjs_ke;
        $bpjs_kesehatan->save();
    }
}
