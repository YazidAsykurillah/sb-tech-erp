<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTermToTableCashbonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbonds', function(Blueprint $table){
            $table->integer('term')->default(1);
            $table->boolean('payment_status')->default(FALSE);
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
            $table->dropColumn('term');
            $table->dropColumn('payment_status');
        });
    }
}
