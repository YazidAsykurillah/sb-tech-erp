<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('customer_id');
            $table->text('description');
            $table->decimal('amount', 20, 2)->nullable();
            $table->integer('quotation_customer_id')->nullable();
            $table->enum('status', ['received', 'on-process', 'cancelled']);
            $table->date('received_date')->default(date('Y-m-d'));
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
        Schema::drop('purchase_order_customers');
    }
}
