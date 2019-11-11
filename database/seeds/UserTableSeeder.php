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
            //Super admin
        	['id'=>1, 'name'=>'Solksjaer', 'email'=>'solksjaer@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0001', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],

            //Admin
        	['id'=>2, 'name'=>'Zlatan Ibrahimovic', 'email'=>'ibrahimovic@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0002', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],

            //Finance
            ['id'=>3, 'name'=>'Wayne Rooney', 'email'=>'rooney@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0003', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],

            //Warehouse
        	['id'=>4, 'name'=>'Ander Herrera', 'email'=>'herrera@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0004', 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],

            //Marketing
            ['id'=>5, 'name'=>'Juan Mata', 'email'=>'mata@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0005' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],

            //Sales
            ['id'=>6, 'name'=>'Michael Carrick', 'email'=>'carrick@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0005' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],

            //Engineers
            ['id'=>7, 'name'=>'Marouane Fellaini', 'email'=>'fellaini@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0007' , 'type'=>'office', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>8, 'name'=>'Marcos Rojo', 'email'=>'rojo@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0008' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>9, 'name'=>'Daley Blind', 'email'=>'blind@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0009' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>10, 'name'=>'Antony Valencia', 'email'=>'valencia@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0010' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>11, 'name'=>'Luke Shaw', 'email'=>'shaw@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0011' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            ['id'=>12, 'name'=>'David De Gea', 'email'=>'degea@email.com', 'password'=>bcrypt('12345'), 'nik'=>'A-0012' , 'type'=>'outsource', 'salary'=>5000000, 'man_hour_rate'=>10000],
            
            
        ];

        \DB::table('users')->insert($users);
    }
}
