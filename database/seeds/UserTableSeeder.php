<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();
        $users = [
        	['id'=>1, 'name'=>'Jose Mourinho', 'email'=>'mourinho@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0001', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
        	['id'=>2, 'name'=>'Zlatan Ibrahimovic', 'email'=>'ibrahimovic@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0002', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>3, 'name'=>'Wayne Rooney', 'email'=>'rooney@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0003', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
        	['id'=>4, 'name'=>'Ander Herrera', 'email'=>'herrera@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0004', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>5, 'name'=>'Juan Mata', 'email'=>'mata@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0005' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>6, 'name'=>'Michael Carrick', 'email'=>'carrick@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0005' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>7, 'name'=>'Marouane Fellaini', 'email'=>'fellaini@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0007' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>8, 'name'=>'Marcos Rojo', 'email'=>'rojo@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0008' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>9, 'name'=>'Daley Blind', 'email'=>'blind@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0009' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>10, 'name'=>'Antony Valencia', 'email'=>'valencia@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0010' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>11, 'name'=>'Luke Shaw', 'email'=>'shaw@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0011' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>12, 'name'=>'David De Gea', 'email'=>'degea@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0012' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            
            //BMKN Trial members
            ['id'=>13, 'name'=>'Arief', 'email'=>'arief@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0013' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>14, 'name'=>'Kaisar', 'email'=>'kaisar@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0014' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>15, 'name'=>'Budi Irawan', 'email'=>'budi@email.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0015' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>16, 'name'=>'Ahmad Suharjiono', 'email'=>'ahmad.suharjiono@bintangmas-engineering.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0016' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>17, 'name'=>'Muhammad Furqon', 'email'=>'muhammad.furqon@bintangmas-engineering.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0017' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>18, 'name'=>'Irfan Nugraha', 'email'=>'irfan.nugraha@bintangmas-engineering.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0018' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>19, 'name'=>'Vikar Ghaidasurya', 'email'=>'vikar.ghaidasurya@bintangmas-engineering.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0019' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>20, 'name'=>'Irfan Ayi Hikmawan', 'email'=>'irfan.ayi@bintangmas-engineering.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0020' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>21, 'name'=>'Revrandy Hutapea', 'email'=>'revrandy.hutapea@bintangmas-engineering.com', 'password'=>bcrypt('bmkn'), 'nik'=>'A-0021' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
        ];

        \DB::table('users')->insert($users);
    }
}
