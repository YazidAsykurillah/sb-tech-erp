<?php

use Illuminate\Database\Seeder;

class ProjectTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('projects')->delete();
        $data = [
        	['id'=>1, 'code'=>'P-00001', 'name'=>'ERP System development', 'purchase_order_customer_id'=>1, 'sales_id'=>4],
       	];

       	\DB::table('projects')->insert($data);
    }
}
