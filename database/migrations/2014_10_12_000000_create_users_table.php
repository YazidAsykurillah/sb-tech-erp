<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nik')->comment("As NOMOR Karyawan");
            $table->enum('type', ['office', 'outsource'])->default('office');
            $table->decimal('salary', 20, 2)->nullable();
            $table->decimal('man_hour_rate', 20, 2)->nullable();
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->string('profile_picture')->nullable();
            $table->decimal('eat_allowance', 20, 2)->default(0)->comment('Uang makan per hari');
            $table->decimal('transportation_allowance', 20, 2)->default(0)->comment('Transportasi per hari');
            $table->decimal('medical_allowance', 20, 2)->default(0)->comment('Tunjangan kesehatan perbulan');
            $table->decimal('bpjs_tk', 20, 2)->default(0)->comment('BPJS Ketenagakerjaan');
            $table->decimal('bpjs_ke', 20, 2)->default(0)->comment('BPJS Kesehatan');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
