<?php

namespace App\Listeners;

use App\Events\PayrollIsApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Cashbond;
use App\CashbondInstallment;
class SetInstallmentToPaid
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
     * @param  PayrollIsApproved  $event
     * @return void
     */
    public function handle(PayrollIsApproved $event)
    {
        $payroll = $event->payroll;
        $period = $payroll->period;
        $user = $payroll->user;
        
        //get cashbond installment from the user where the installment is within period
        /*$cashbond_installments = Cashbond::with(['cashbond_installments'])
        ->where('user_id', $user->id)
        ->whereHas('cashbond_installments', function($query) use($period){
            $query->whereBetween('installment_schedule', [$period->start_date, $period->end_date]);
            $query->where('status', '=', 'unpaid');
        })
        ->get();*/
        $cashbond_installments = CashbondInstallment::with(['cashbond'])
        ->whereHas('cashbond', function($query) use($user){
            $query->where('user_id', $user->id);
        })
        ->whereBetween('installment_schedule', [$period->start_date, $period->end_date])
        ->where('status', '=', 'unpaid')
        ->get();
        if($cashbond_installments && $cashbond_installments->count()){
            foreach($cashbond_installments as $ci){
                $cashbond_installment = CashbondInstallment::findOrFail($ci->id);
                $cashbond_installment->status = 'paid';
                $cashbond_installment->save();
            }
        }

    }
}
