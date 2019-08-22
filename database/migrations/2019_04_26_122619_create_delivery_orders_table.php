<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('project_id');
            $table->integer('user_id')->comment('Creator');
            $table->integer('sender_id');
            $table->enum('status', ['draft', 'delivered', 'received'])->default('draft');
            $table->string('receiver')->nullable()->default(NULL);
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
        Schema::drop('delivery_orders');
    }
}
