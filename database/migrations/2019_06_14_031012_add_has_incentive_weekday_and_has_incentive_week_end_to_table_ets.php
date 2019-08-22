<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasIncentiveWeekdayAndHasIncentiveWeekEndToTableEts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ets', function(Blueprint $table){
            $table->boolean('has_incentive_week_day')->default(FALSE);
            $table->boolean('has_incentive_week_end')->default(FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ets',function(Blueprint $table){
            $table->dropColumn('has_incentive_week_day');
            $table->dropColumn('has_incentive_week_end');
        });
    }
}
