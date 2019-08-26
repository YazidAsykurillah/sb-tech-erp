<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('migos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('purchase_request_id')->nullable();
            $table->integer('creator_id')->comment('The user id');
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
        Schema::drop('migos');
    }
}
