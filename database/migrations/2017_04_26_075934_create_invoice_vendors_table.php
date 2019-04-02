<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('Invoice vendor number');
            $table->string('tax_number');
            $table->decimal('amount', 20, 2);
            $table->integer('project_id');
            $table->integer('purchase_order_vendor_id');
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'paid']);
            $table->boolean('accounted')->default(false);
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
        Schema::drop('invoice_vendors');
    }
}
