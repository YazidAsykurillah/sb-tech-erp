<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_purchase_request', function(Blueprint $table){
            $table->increments('id');
            $table->text('purchase_request_id');
            $table->text('item');
            $table->text('quantity');
            $table->text('unit');
            $table->decimal('price', 20, 2);
            $table->decimal('sub_amount', 20, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_purchase_request');
    }
}
