<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypePercentAndAmountFromTypeToInvoiceVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->decimal('amount_before_type', 20, 2)->nullable();
            $table->integer('type_percent')->default(0);
            $table->decimal('amount_from_type', 20, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->dropColumn('amount_before_type');
            $table->dropColumn('type_percent');
            $table->dropColumn('amount_from_type');
        });
    }
}
