<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusToPurchaseOrderVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_vendors', function(Blueprint $table){
            $table->enum('status', ['uncompleted', 'completed', 'unresolved'])->default('uncompleted');
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
            $table->dropColumn('status');
        });
    }
}
