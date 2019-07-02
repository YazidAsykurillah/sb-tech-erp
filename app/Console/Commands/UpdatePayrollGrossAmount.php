<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Payroll;

class UpdatePayrollGrossAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payroll:update_gross_amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update payroll gross amount property';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->description);
        $payrolls = Payroll::all();
        $payrolls_count = $payrolls->count();
        $this->info("Found $payrolls_count payrolls");
        if($payrolls_count == 0){
            $this->info('Nothing to do');
        }else{
            foreach($payrolls as $payroll){
                $gross_amount = $this->get_gross_amount($payroll);
                Payroll::where('id','=',$payroll->id)->update(['gross_amount'=>$gross_amount]);
            }
            $this->info("$this->description finished");
        }
    }

    protected function get_gross_amount($payroll)
    {
        $gross_amount = 0;
        if($payroll){
            $gross_amount = $payroll->thp_amount;
            if($payroll->settlement_payroll->count()){
                $settlement_payroll_balance = 0;
                foreach($payroll->settlement_payroll as $settlement_payroll){
                    $balance = $settlement_payroll->settlement->internal_request->amount - $settlement_payroll->settlement->amount;
                    $settlement_payroll_balance+=$balance;
                }
                $gross_amount+=$settlement_payroll_balance;
            }
        }
        return $gross_amount;
    }
}
