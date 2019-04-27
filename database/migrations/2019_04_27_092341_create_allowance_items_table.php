<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllowanceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowance_items', function(Blueprint $table){
            $table->increments('id');
            $table->integer('allowance_id');
            $table->enum('type',['transportation', 'meal']);
            $table->decimal('amount',20,2);
            $table->integer('multiplier');
            $table->decimal('total_amount',20,2);
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
        Schema::drop('allowance_items');
    }
}
