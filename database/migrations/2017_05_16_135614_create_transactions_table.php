<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cash_id');
            $table->enum('refference', 
                [
                'internal_request', 'settlement', 'cashbond',
                'invoice_customer', 'invoice_vendor', 'bank_administration',
                'invoice_customer_tax', 'invoice_vendor_tax', 'manual',
                'site_internal_request', 'site_settlement', 'cashbond-site',
                'payroll'
                ]
            );
            $table->integer('refference_id');
            $table->string('refference_number');
            $table->enum('type', ['credit', 'debet']);
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
        Schema::drop('transactions');
    }
}
