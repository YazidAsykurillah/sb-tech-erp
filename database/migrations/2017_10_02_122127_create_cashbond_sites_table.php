<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbondSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbond_sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('user_id');
            $table->decimal('amount', 20, 2);
            $table->text('description');
            $table->enum('status', ['pending', 'checked', 'approved', 'rejected'])->default('pending');
            $table->date('transaction_date')->nullable();
            $table->boolean('accounted')->default(false);
            $table->integer('cash_id');
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
        Schema::drop('cashbond_sites');
    }
}
