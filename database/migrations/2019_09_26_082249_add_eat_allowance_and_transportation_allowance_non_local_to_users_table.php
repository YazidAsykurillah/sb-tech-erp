<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEatAllowanceAndTransportationAllowanceNonLocalToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->decimal('eat_allowance_non_local', 20, 2)->after('eat_allowance')->default(0);
            $table->decimal('transportation_allowance_non_local', 20, 2)->after('transportation_allowance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('eat_allowance_non_local');
            $table->dropColumn('transportation_allowance_non_local');
        });
    }
}
