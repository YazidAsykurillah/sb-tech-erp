<?php

use Illuminate\Database\Seeder;

class InternalRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('internal_requests')->delete();

        $data = [
        	['id'=>1, 'code'=>'IR-00001', 'description'=>'Internal request description', 'amount'=>200000, 'remitter_bank_id'=>1, 'beneficiary_bank_id'=>2, 'project_id'=>1, 'requester_id'=>3, 'status'=>'approved', 'settled'=>true, 'accounted'=>true],
        	
        ];

        \DB::table('internal_requests')->insert($data);
    }
}
