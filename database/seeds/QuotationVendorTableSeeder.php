<?php

use Illuminate\Database\Seeder;

class QuotationVendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('quotation_vendors')->delete();
        $data = [
        	['id'=>1, 'purchase_request_id'=>1, 'code'=>'QV-00001', 'vendor_id'=>1, 'amount'=>200000, 'description'=>'Description of quotation vendor 1', 'received_date'=>date('Y-m-d')],
        ];
        \DB::table('quotation_vendors')->insert($data);
    }
}
