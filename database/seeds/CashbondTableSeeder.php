<?php

use Illuminate\Database\Seeder;

class CashbondTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cashbonds')->delete();
        $data = [
        	['id'=>1, 'code'=>'CB-00001', 'user_id'=>1, 'amount'=>100000, 'description'=>'Buy medicine']
        ];
        \DB::table('cashbonds')->insert($data);

    }
}
