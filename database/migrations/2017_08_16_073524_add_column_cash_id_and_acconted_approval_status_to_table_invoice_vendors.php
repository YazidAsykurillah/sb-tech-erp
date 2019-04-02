<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCashIdAndAccontedApprovalStatusToTableInvoiceVendors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->integer('cash_id')->nullable()->comment('The source cash of this invoice vendor to be transacted');
            $table->enum('accounted_approval',['pending', 'approved', 'rejected'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->dropColumn('cash_id');
            $table->dropColumn('accounted_approval');
        });
    }
}
