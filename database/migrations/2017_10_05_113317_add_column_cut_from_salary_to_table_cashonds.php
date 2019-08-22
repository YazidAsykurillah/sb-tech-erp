<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCutFromSalaryToTableCashonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbonds', function(Blueprint $table){
            $table->boolean('cut_from_salary')->default(FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbonds', function(Blueprint $table){
            $table->dropColumn('cut_from_salary');
        });
    }
}
