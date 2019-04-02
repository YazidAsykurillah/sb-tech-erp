<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAccountedApprovalToTableInternalRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_requests', function(Blueprint $table){
            $table->enum('accounted_approval', ['pending', 'approved', 'rejected'])->default('pending')->comment('Check the condition of accounted status of this internal request');
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
            $table->dropColumn('accounted_approval');
        });
    }
}
