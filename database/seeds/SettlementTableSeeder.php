<?php

use Illuminate\Database\Seeder;

class SettlementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settlements')->delete();
        $data = [
        	['id'=>1, 'code'=>'SET-IR-00001', 'internal_request_id'=>1, 'transaction_date'=>date_create('2017-05-03'), 'description'=>'Settlement description', 'category_id'=>1, 'sub_category_id'=>1, 'amount'=>200000, 'last_updater_id'=>1],
        ];

        \DB::table('settlements')->insert($data);
    }
}
