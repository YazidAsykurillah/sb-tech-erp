<?php

use Illuminate\Database\Seeder;

class TimeReportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('time_reports')->delete();
        \DB::table('time_report_user')->delete();
    }
}
