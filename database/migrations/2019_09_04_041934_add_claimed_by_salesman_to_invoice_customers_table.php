<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClaimedBySalesmanToInvoiceCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_customers', function(Blueprint $table){
            $table->boolean('claimed_by_salesman')->default(FALSE)->comment('Define if invoice is already claimed by the salesman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_customers', function(Blueprint $table){
            $table->dropColumn('claimed_by_salesman');
        });
    }
}
