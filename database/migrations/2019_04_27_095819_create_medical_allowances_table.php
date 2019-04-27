<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_allowances', function(Blueprint $table){
            $table->increments('id');
            $table->integer('period_id');
            $table->integer('user_id');
            $table->decimal('amount',20,2);
            $table->integer('multiplier');
            $table->decimal('total_amount',20,2);
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
        Schema::drop('medical_allowances');
    }
}
