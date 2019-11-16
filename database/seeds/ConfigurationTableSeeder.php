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
        	['name'=>'company-logo', 'value'=>url('img/logo-sbt.jpeg')],
            ['name'=>'company-office',
                'value'=>"Jl. Raya Ciangsana, Ruko SA 1 No.24\nVilla Nusa Indah 5, Ciangsana, Gunung Putri, Kab. Bogor\nJawa Barat 16968 - Indonesia
                        "
            ],
            ['name'=>'company-worskhop',
                'value'=>"Jl. Raya Ciangsana, Ruko SA 1 No.24\nVilla Nusa Indah 5, Ciangsana, Gunung Putri, Kab. Bogor\nJawa Barat 16968 - Indonesia"
            ],
            ['name'=>'company-bank-account',
                'value'=>"Bank Syariah Mandiri Cabang Jatibening\n(IDR) Acc. No. 7891113336 : PT. Sedulang Bintang Teknik"
            ],
        ];
        \DB::table('configurations')->insert($data);
    }
}
