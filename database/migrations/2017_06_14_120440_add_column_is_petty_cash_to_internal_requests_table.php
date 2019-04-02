<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsPettyCashToInternalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_requests', function(Blueprint $table){
            $table->boolean('is_petty_cash')->default(FALSE)->comment('define if this IR is petty cash or not');
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
            $table->dropColumn('is_petty_cash');
        });
    }
}
