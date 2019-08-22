<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('customers')->delete();
        $data = [
        	['id'=>1, 'name'=>'Microsot', 'address'=>'Microsot street', 'contact_number'=>'012345678'],
        	['id'=>2, 'name'=>'Appl', 'address'=>'Appl street', 'contact_number'=>'012345679'],
        ];

        \DB::table('customers')->insert($data);
    }
}
