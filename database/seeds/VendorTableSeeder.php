<?php

use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vendors')->delete();
        $data = [
        	['id'=>1, 'name'=>'Vendor 1', 'product_name'=>'Vendor 1 product'],
        	['id'=>2, 'name'=>'Vendor 2', 'product_name'=>'Vendor 2 product'],
        ];

        \DB::table('vendors')->insert($data);
    }
}
