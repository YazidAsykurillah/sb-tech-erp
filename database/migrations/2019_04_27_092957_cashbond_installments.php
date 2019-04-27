<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashbondInstallments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbond_installments', function(Blueprint $table){
            $table->increments('id');
            $table->integer('cashbond_id');
            $table->decimal('amount',20,2);
            $table->date('installment_schedule')->nullable();
            $table->enum('status',['paid', 'unpaid']);
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
        Schema::drop('cashbond_installments');
    }
}
