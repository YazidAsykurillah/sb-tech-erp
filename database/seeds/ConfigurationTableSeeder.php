<?php

use Illuminate\Database\Seeder;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('configurations')->delete();
        $data = [
        	['name'=>'estimated-cost-margin-limit', 'value'=>15],
        	['name'=>'prefix-invoice-customer', 'value'=>'INVC'],
        	['name'=>'company-logo', 'value'=>'http://localhost'],
        ];
        \DB::table('configurations')->insert($data);
    }
}
