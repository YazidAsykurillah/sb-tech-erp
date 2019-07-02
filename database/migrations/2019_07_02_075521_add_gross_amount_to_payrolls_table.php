<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGrossAmountToPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function(Blueprint $table){
            $table->decimal('gross_amount', 20,2)->after('thp_amount')->default(0)->comment('Payroll amount without the settlements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolls', function(Blueprint $table){
            $table->dropColumn('gross_amount');
        });
    }
}
