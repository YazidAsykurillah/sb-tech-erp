<?php

use Illuminate\Database\Seeder;

class PeriodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('periods')->delete();
        $data = [
        	['id'=>1, 'code'=>'PER-00001', 'the_year'=>'2017', 'the_month'=>'may', 'start_date'=>date_create('2017-05-23'), 'end_date'=>date_create('2017-06-22')]
        ];

        \DB::table('periods')->insert($data);
    }
}
