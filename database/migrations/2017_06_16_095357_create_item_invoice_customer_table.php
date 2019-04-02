<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemInvoiceCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_invoice_customer', function(Blueprint $table){
            $table->increments('id');
            $table->text('invoice_customer_id');
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
        Schema::drop('item_invoice_customer');
    }
}
