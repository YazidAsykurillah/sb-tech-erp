<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemDeliveryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_delivery_order', function(Blueprint $table){
            $table->integer('delivery_order_id');
            $table->integer('item_purchase_request_id');
            $table->decimal('quantity',20,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_delivery_order');
    }
}
