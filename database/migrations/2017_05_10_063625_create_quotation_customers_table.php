<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('customer_id');
            $table->integer('sales_id');
            $table->text('amount')->nullable();
            $table->text('description');
            $table->enum('status', ['pending', 'submitted', 'rejected'])->default('pending');
            $table->date('submitted_date')->nullable();
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
        Schema::drop('quotation_customers');
    }
}
