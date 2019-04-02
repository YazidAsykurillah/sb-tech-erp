<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_reports', function(Blueprint $table){
            $table->increments('id');
            $table->integer('period_id');
            $table->date('the_date');
            $table->enum('type', ['usual', 'week_end', 'day_off']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('time_reports');
    }
}
