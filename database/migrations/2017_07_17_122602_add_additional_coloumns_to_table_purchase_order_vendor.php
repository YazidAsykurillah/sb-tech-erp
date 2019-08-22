<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalColoumnsToTablePurchaseOrderVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_vendors', function(Blueprint $table){
            $table->decimal('sub_amount', 20, 2)->default(0)->comment('Initial amount taken from item price summary');
            $table->integer('vat')->default(0);
            $table->decimal('wht', 20, 2)->default(0);
            $table->integer('discount')->default(0);
            $table->decimal('after_discount', 20, 2)->default(0);
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
            $table->dropColumn('sub_amount');
            $table->dropColumn('vat');
            $table->dropColumn('wht');
            $table->dropColumn('discount');
            $table->dropColumn('after_discount');
        });
    }
}
