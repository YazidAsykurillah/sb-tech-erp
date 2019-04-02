<?php

use Illuminate\Database\Seeder;

class PurchaseOrderVendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('purchase_order_vendors')->delete();
        $data = [
        	['id'=>1, 'vendor_id'=>1, 'code'=>'POV-00001', 'purchase_request_id'=>1, 'description'=>'Purchase order vendor description 1', 'amount'=>100000, 'quotation_vendor_id'=>1],
        ];
        \DB::table('purchase_order_vendors')->insert($data);
    }
}
