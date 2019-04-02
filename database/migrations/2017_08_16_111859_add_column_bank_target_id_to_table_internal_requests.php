<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnBankTargetIdToTableInternalRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_requests', function(Blueprint $table){
            $table->integer('bank_target_id')->nullable()->commment('needed as the beneficiary bank if the internal request type is pindah buku');
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
            $table->dropColumn('bank_target_id');
        });
    }
}
