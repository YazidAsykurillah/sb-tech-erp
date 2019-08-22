<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotationVendorIdToPurchaseOrderVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_vendors', function(Blueprint $table){
            $table->integer('quotation_vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_vendors', function(Blueprint $table){
            $table->dropColumn('quotation_vendor_id');
        });
    }
}
