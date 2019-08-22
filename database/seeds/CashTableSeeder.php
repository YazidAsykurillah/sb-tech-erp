<?php

use Illuminate\Database\Seeder;

class CashTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cashes')->delete();
        $data = [
        	['id'=>1, 'type'=>'bank', 'name'=>'BNI BMKN', 'account_number'=>'456789', 'description'=>'Cash on BNI bank', 'amount'=>100000000],
        	['id'=>2, 'type'=>'bank', 'name'=>'BCA BMKN', 'account_number'=>'343434', 'description'=>'Cash on BCA bank', 'amount'=>200000000],
        	['id'=>3, 'type'=>'cash', 'name'=>'Petty Cash', 'account_number'=>'00001', 'description'=>'Cash on office', 'amount'=>10000000],
        ];
        \DB::table('cashes')->insert($data);
    }
}
