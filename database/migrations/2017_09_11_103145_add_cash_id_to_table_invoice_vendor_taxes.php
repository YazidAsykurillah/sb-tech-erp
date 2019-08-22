<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashIdToTableInvoiceVendorTaxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_vendor_taxes', function(Blueprint $table){
            $table->integer('cash_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_vendor_taxes', function(Blueprint $table){
           $table->dropColumn('cash_id');
        });
    }
}
