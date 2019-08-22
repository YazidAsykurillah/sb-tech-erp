<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('period_id');
            $table->date('the_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('normal',20,2)->nullable();
            $table->decimal('I',20,2)->nullable();
            $table->decimal('II',20,2)->nullable();
            $table->decimal('III',20,2)->nullable();
            $table->decimal('IV',20,2)->nullable();
            $table->text('description')->nullable();
            $table->text('plant')->nullable();
            $table->string('project_number')->nullable();
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
        Schema::drop('ets');
    }
}
