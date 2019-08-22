<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillAmountToInvoiceVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->decimal('bill_amount', 20, 2)->default(0);
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
            $table->dropColumn('bill_amount');
        });
    }
}
