<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id');
            $table->string('code')->unique()->command('Purchase order vendor number');
            $table->integer('purchase_request_id');
            $table->text('description');
            $table->decimal('amount', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('purchase_order_vendors');
    }
}
