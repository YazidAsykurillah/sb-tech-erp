<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->comment('Internal request number');
            $table->text('description');
            $table->decimal('amount', 20, 2);
            $table->integer('remitter_bank_id')->comment('Bank pengirim, taken from Cash model');
            $table->integer('beneficiary_bank_id')->comment('Bank penerima, taken from Bank Account model');
            $table->integer('project_id');
            $table->integer('requester_id')->comment('the user who make the internal request');
            $table->enum('status', ['pending', 'checked', 'approved', 'rejected'])->default('pending');
            $table->integer('approver_id')->nullable();
            $table->date('transaction_date')->nullable();
            $table->boolean('settled')->default(false)->comment('Define if this IR has settled or not');
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
        Schema::drop('internal_requests');
    }
}
