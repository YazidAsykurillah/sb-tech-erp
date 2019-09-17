<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalManhourParametersToEtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ets', function(Blueprint $table){
            $table->decimal('total_manhour', 20, 2)->default(0);
            $table->decimal('rate', 20, 2)->default(0)->comment('Man hour rate of the user');
            $table->decimal('transport', 20, 2)->default(0)->comment('transport rate of the user');
            $table->decimal('allowance', 20, 2)->default(0)->comment('allowance rate of the user');
            $table->decimal('total_cost', 20, 2)->default(0)->comment('total cost per project per day for the user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
