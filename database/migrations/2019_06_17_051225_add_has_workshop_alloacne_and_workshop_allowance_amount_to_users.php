<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasWorkshopAlloacneAndWorkshopAllowanceAmountToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->boolean('has_workshop_allowance')->default(FALSE);
            $table->decimal('workshop_allowance_amount',20,2)->default(0);
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
            $table->dropColumn('has_workshop_allowance');
            $table->dropColumn('workshop_allowance_amount');
        });
    }
}
