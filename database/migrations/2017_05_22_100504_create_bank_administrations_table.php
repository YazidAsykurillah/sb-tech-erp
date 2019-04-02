<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAdministrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_administrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('cash_id');
            $table->string('refference_number')->comment('The refference number from the bank');
            $table->text('description');
            $table->decimal('amount', 20, 2);
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
        Schema::drop('bank_administrations');
    }
}
