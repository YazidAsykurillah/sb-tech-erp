<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeToTableInternalRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_requests', function(Blueprint $table){
            $table->enum('type', ['material', 'operational', 'pindah_buku'])->default('operational');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_requests', function(Blueprint $table){
            $table->dropColumn('type');
        });
    }
}
