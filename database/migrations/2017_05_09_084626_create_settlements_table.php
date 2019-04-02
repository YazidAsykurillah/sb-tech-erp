<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('internal_request_id');
            $table->date('transaction_date');
            $table->text('description');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->decimal('amount', 20, 2);
            $table->enum('result', ['clear', 'additional'])->default('clear');
            $table->enum('status', ['pending', 'checked', 'approved', 'rejected'])->default('pending');
            $table->integer('last_updater_id')->nullable();
            $table->boolean('accounted')->default(false)->comment('Define is this accounted on cash or not');
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
        Schema::drop('settlements');
    }
}
