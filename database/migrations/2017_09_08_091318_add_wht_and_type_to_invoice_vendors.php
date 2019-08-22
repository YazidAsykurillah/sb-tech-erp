<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWhtAndTypeToInvoiceVendors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_vendors', function(Blueprint $table){
            $table->decimal('wht_amount', 20, 2);
            $table->enum('type', ['dp', 'term', 'pelunasan'])->nullable()->default(NULL);
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
            $table->dropColumn('wht_amount');
            $table->dropColumn('type');
        });
    }
}
