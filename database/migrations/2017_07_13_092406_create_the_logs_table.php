<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTheLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('the_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('source', ['internal_request', 'cashbond', 'settlement', 'invoice_vendor', 'invoice_customer', 'quotation_customer', 'quotation_vendor'])->nullable();
            $table->enum('mode', ['create', 'update', 'delete', 'approve', 'reject'])->nullable();
            $table->integer('refference_id');
            $table->integer('user_id');
            $table->text('description')->nullable();
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
        Schema::drop('the_logs');
    }
}
