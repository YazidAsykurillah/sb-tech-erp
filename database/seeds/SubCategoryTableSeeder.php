<?php

use Illuminate\Database\Seeder;

class SubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sub_categories')->delete();
        $data = [
        	['id'=>1, 'name'=>'Sub Category 1', 'description'=>'Description of sub category 1', 'category_id'=>1],
        	['id'=>2, 'name'=>'Sub Category 2', 'description'=>'Description of sub category 2', 'category_id'=>1],
        	['id'=>3, 'name'=>'Sub Category 3', 'description'=>'Description of sub category 3', 'category_id'=>2],
        ];

        \DB::table('sub_categories')->insert($data);
    }
}
