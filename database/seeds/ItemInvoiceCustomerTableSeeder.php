<?php

use Illuminate\Database\Seeder;

class ItemInvoiceCustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('item_invoice_customer')->delete();
    }
}
