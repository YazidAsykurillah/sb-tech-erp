<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();

        $data = [
        	['id'=>1, 'name'=>'Category 1', 'description'=>'Description of Category 1'],
        	['id'=>2, 'name'=>'Category 2', 'description'=>'Description of Category 2'],
        ];

        \DB::table('categories')->insert($data);
    }
}
