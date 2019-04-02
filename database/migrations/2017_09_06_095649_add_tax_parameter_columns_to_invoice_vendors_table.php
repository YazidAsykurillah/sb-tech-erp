<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxParameterColumnsToInvoiceVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->decimal('sub_total', 20, 2)->default(0);
            $table->integer('discount')->default(0);
            $table->decimal('after_discount', 20, 2)->default(0);
            $table->integer('vat')->default(0);
            $table->decimal('vat_amount', 20, 2)->default(0);
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
            $table->dropColumn('sub_total');
            $table->dropColumn('discount');
            $table->dropColumn('after_discount');
            $table->dropColumn('vat');
            $table->dropColumn('vat_amount');
         });
    }
}
