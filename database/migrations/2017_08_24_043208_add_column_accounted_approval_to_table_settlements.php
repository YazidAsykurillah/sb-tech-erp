<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAccountedApprovalToTableSettlements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements', function(Blueprint $table){
            $table->enum('accounted_approval', ['pending', 'approved', 'rejected']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlements', function(Blueprint $table){
            $table->dropColumn('accounted_approval');
        });
    }
}
