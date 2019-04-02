<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('code')->unique()->command("invoice customer number");
            $table->string('tax_number');
            $table->decimal('sub_amount', 20, 2)->default(0)->comment('Initial amount taken from item price summary');
            $table->integer('vat')->default(0);
            $table->decimal('wht', 20, 2)->default(0);
            $table->decimal('amount', 20, 2)->nullable()->default(NULL)->commant('the total of sub_amount,vat,and wht');
            $table->date('due_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->date('submitted_date')->default(date('Y-m-d'));
            $table->boolean('accounted')->default(false);
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
        Schema::drop('invoice_customers');
    }
}
