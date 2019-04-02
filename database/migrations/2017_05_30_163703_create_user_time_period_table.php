<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTimePeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_report_user', function(Blueprint $table){
            $table->increments('id');
            $table->integer('period_id');
            $table->integer('time_report_id');
            $table->integer('user_id');
            $table->enum('incentive', ['non', 'week_day', 'week_end']);
            $table->boolean('allowance');
            $table->boolean('non_allowance');
            $table->boolean('off_allowance');
            $table->integer('normal_time')->nullable();
            $table->integer('overtime_one')->nullable();
            $table->integer('overtime_two')->nullable();
            $table->integer('overtime_three')->nullable();
            $table->integer('overtime_four')->nullable();
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
        Schema::drop('time_report_user');
    }
}
