<?php

use Illuminate\Database\Seeder;

class BankAdministrationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bank_administrations')->delete();
        $data = [
        	['id'=>1, 'code'=>'BAD-00001', 'cash_id'=>1, 'refference_number'=>'BAYX123456', 'description'=>'Bank administration description', 'amount'=>10000],
        	['id'=>2, 'code'=>'BAD-00002', 'cash_id'=>2, 'refference_number'=>'BAYX654321', 'description'=>'Bank administration description', 'amount'=>20000],
        ];

        \DB::table('bank_administrations')->insert($data);
    }
}
