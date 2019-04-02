<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('purchase_request_id');
            $table->integer('vendor_id');
            $table->text('amount')->nullable();
            $table->text('description');
            $table->enum('status', ['pending', 'received', 'rejected'])->default('received');
            $table->date('received_date')->nullable();
            $table->boolean('purchase_order_vendored')->default(false)->comment('To define if this has purchase order vendor related or not');
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
        Schema::drop('quotation_vendors');
    }
}
