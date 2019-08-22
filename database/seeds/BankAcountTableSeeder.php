<?php

use Illuminate\Database\Seeder;

class BankAcountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('bank_accounts')->delete();
        $bank_accounts = [
        	['id'=>1, 'user_id'=>1, 'name'=>'Mandiri', 'account_number'=>'12345678'],
        	['id'=>2, 'user_id'=>1, 'name'=>'BNI', 'account_number'=>'987654321']
        ];

        \DB::table('bank_accounts')->insert($bank_accounts);
    }
}
