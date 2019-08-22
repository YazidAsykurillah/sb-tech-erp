<?php

use Illuminate\Database\Seeder;

class InvoiceCustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('invoice_customers')->delete();
        $data = [
        	['id'=>1, 'code'=>'INV-C-00001', 'tax_number'=>'TAX-00001', 'project_id'=>1, 'amount'=>500000, 'due_date'=>date_create('2017-06-13')],
        	
        ];

        \DB::table('invoice_customers')->insert($data);
    }
}
