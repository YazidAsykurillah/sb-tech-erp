<?php

namespace App\Listeners;

use App\Events\PayrollIsDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteAllowanceParameters
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
        $period_id = $payroll->period_id;
        $user_id = $payroll->user_id;

        //collect allowance id from allowances table
        $allowances_id_to_delete = [];
        $allowances = \DB::table('allowances')
                        ->select('id')
                        ->where('period_id','=',$period_id)
                        ->where('user_id','=',$user_id)
                        ->get();
        foreach($allowances as $allowance){
            $allowances_id_to_delete[] = $allowance->id;
        }
        //delete allowance model and also the item
        if(count($allowances_id_to_delete)){
            \DB::table('allowances')->whereIn('id',$allowances_id_to_delete)->delete();
            \DB::table('allowance_items')->whereIn('allowance_id',$allowances_id_to_delete)->delete();
            \DB::table('medical_allowances')->where('period_id','=',$period_id)->where('user_id','=',$user_id)->delete();
        }


    }
}
