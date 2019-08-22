<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('transactions')->delete();
        $data = [
        	['cash_id'=>1, 'refference'=>'internal_request', 'refference_id'=>1, 'refference_number'=>'IR-00001', 'type'=>'debet', 'amount'=>200000]
        ];

        \DB::table('transactions')->insert($data);
    }
}
