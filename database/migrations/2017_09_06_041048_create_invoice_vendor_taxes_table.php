<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceVendorTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_vendor_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_vendor_id');
            $table->enum('source', ['vat', 'wht']);
            $table->integer('percentage')->default(0);
            $table->decimal('amount', 20, 2);
            $table->enum('status',['pending', 'paid']);
            $table->enum('approval', ['pending', 'approved', 'rejected']);
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
        Schema::drop('invoice_vendor_taxes');
    }
}
