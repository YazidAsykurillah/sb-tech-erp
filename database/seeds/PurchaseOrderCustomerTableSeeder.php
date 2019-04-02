<?php

use Illuminate\Database\Seeder;

class PurchaseOrderCustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('purchase_order_customers')->delete();
        
        $data = [
        	['id'=>1, 'code'=>'PO-0001', 'customer_id'=>1, 'description'=>'ERP System development', 'amount'=>1500000, 'quotation_customer_id'=>1],
        ];

        \DB::table('purchase_order_customers')->insert($data);
    }
}
