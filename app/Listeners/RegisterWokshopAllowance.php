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
        //initiate workhsop allowance properties
        //workshop allowance amount
        $wa_amount = $this->getWaAmount($user);
        //workshop allowance multiplier

        //Build workshop allowance multiplier
        $wa_multiplier = $this->getWaMultiplier($user->id, $payroll->period_id);
            

        

        $workshopAllowance = new WorkshopAllowance;
        $workshopAllowance->payroll_id = $payroll->id;
        $workshopAllowance->amount = $wa_amount;
        $workshopAllowance->multiplier = $wa_multiplier;
        $workshopAllowance->total_amount = $wa_amount*$wa_multiplier;
        $workshopAllowance->save();
    }

    protected function getWaAmount($user)
    {
        //Build workshop allowance amount
        $wa_amount = 0;
        if($user->has_workshop_allowance == TRUE){
            $wa_amount = $user->workshop_allowance_amount; 
        }else{
            $wa_amount = 0;
        }
        return $wa_amount;
    }

    protected function getWaMultiplier($user_id, $period_id)
    {
        return \DB::table('ets')
                ->where('period_id','=',$period_id)
                ->where('user_id','=',$user_id)
                ->where('location','=','workshop')
                ->count('id');
    }
}
