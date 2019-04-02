<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeToTableInvoiceCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_customers', function(Blueprint $table){
            $table->enum('type', ['dp', 'term', 'pelunasan', 'billing'])->nullable();
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
            $table->dropColumn('type');
        });
    }
}
