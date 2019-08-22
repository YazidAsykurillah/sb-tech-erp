<?php

use Illuminate\Database\Seeder;

class PurchaseRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('purchase_requests')->delete();

        $data = [
        	['id'=>1, 'code'=>'PR-00001', 'project_id'=>1, 'description'=>'Description test', 'amount'=>1000],
        ];

        \DB::table('purchase_requests')->insert($data);
    }
}
