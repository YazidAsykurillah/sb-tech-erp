<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncentiveWeekDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentive_week_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_id');
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
        Schema::drop('incentive_week_days');
    }
}
