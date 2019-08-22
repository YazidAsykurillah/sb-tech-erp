<?php

use Illuminate\Database\Seeder;

class LockConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('lock_configurations')->delete();
        /*$data = [
        	['id'=>1, 'facility_name'=>'create_internal_request', 'user_id'=>4, 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')],
        ];
        \DB::table('lock_configurations')->insert($data);*/
    }
}
