<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('period_id');
            $table->date('the_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('description');
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
        Schema::drop('ets');
    }
}
