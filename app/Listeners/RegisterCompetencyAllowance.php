<?php

namespace App\Listeners;

use App\Events\PayrollIsCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\CompetencyAllowance;

class RegisterCompetencyAllowance
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
        $competency_allowance = new CompetencyAllowance;
        $competency_allowance->payroll_id = $payroll->id;
        $competency_allowance->amount = $user->competency_allowance;
        $competency_allowance->save();
    }
}
