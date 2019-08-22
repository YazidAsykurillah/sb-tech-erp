<?php

use Illuminate\Database\Seeder;

class QuotationCustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('quotation_customers')->delete();
        $data = [
        	['id'=>1, 'code'=>'QC-00001', 'customer_id'=>1, 'sales_id'=>1, 'amount'=>2000000, 'description'=>'ERP System development']
        ];
        \DB::table('quotation_customers')->insert($data);
    }
}
