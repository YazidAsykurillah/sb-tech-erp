<?php

namespace App\Listeners;

use App\Events\PayrollIsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\WorkshopAllowance;

class RegisterWokshopAllowance
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

        $workshopAllowance = new WorkshopAllowance;
        $workshopAllowance->payroll_id = $payroll->id;
        if($user->has_workshop_allowance == TRUE){
            $workshopAllowance->amount = $user->workshop_allowance_amount;    
        }else{
            $workshopAllowance->amount = 0;
        }
        $workshopAllowance->multiplier = 11;
        $workshopAllowance->total_amount = 11;
        $workshopAllowance->save();
    }
}
