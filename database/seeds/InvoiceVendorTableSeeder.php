<?php

use Illuminate\Database\Seeder;

class InvoiceVendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('invoice_vendors')->delete();
        $data = [
        	['id'=>1, 'code'=>'INV-V-00001', 'tax_number'=>'FGHIX5', 'amount'=>10000, 'project_id'=>1, 'purchase_order_vendor_id'=>1, 'due_date'=>date_create('2017-06-10'), 'status'=>'pending'],
        	
        ];
        \DB::table('invoice_vendors')->insert($data);
    }
}
