<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalColumnToTableCashbonds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbonds', function(Blueprint $table){
            $table->enum('accounted_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('remitter_bank_id')->nullable();
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
           $table->dropColumn('accounted_approval');
           $table->dropColumn('remitter_bank_id');
        });
    }
}
