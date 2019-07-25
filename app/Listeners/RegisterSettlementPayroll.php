<?php

namespace App\Listeners;

use App\Events\PayrollIsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;
use App\Settlement;
use App\SettlementPayroll;

class RegisterSettlementPayroll
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
        $period = $payroll->period;
        $user = $payroll->user;
        //get user's settlements
        $end_period_date = Carbon::parse($period->end_date)->addDay(4);
        $settlements = Settlement::with('internal_request')
            ->where('status','=','approved')
            ->where('accounted', FALSE)
            //->whereBetween('updated_at', [$period->start_date->format('Y-m-d H:i:s'), $end_period_date->format('Y-m-d H:i:s')])
            ->orWhereBetween('transaction_date', [$period->start_date, $end_period_date->format('Y-m-d')])
            ->whereHas('internal_request', function($query) use($user, $period){
                $query->where('requester_id', '=', $user->id);
                //$query->whereBetween('transaction_date', [$period->start_date, $period->end_date]);
            })->get();

        if($settlements->count()){
            foreach($settlements as $settlement){
                //create SettlementPayroll
                $settlementPayroll = new SettlementPayroll;
                $settlementPayroll->settlement_id = $settlement->id;
                $settlementPayroll->payroll_id = $payroll->id;
                $settlementPayroll->save();
            }
        }
    }
}
