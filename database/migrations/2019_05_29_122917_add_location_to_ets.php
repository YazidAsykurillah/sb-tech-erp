<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToEts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ets', function(Blueprint $table){
            $table->enum('location',['site-local', 'site-non-local', 'workshop'])->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ets', function(Blueprint $table){
            $table->dropColumn('location');
        });
    }
}
