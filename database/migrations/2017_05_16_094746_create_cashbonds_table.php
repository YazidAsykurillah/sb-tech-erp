<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbonds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('user_id');
            $table->decimal('amount', 20, 2);
            $table->text('description');
            $table->enum('status', ['pending', 'checked', 'approved', 'rejected'])->default('pending');
            $table->date('transaction_date')->nullable();
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
        Schema::drop('cashbonds');
    }
}
