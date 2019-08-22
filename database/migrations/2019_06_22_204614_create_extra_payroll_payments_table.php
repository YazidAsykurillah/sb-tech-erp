<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraPayrollPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_payroll_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payroll_id');
            $table->enum('type',['adder', 'substractor'])->default('adder');
            $table->string('description');
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
        Schema::drop('extra_payroll_payments');
    }
}
