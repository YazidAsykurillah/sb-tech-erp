<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalColumnsToTableInvoiceCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_customers', function(Blueprint $table){
            $table->decimal('discount', 20, 2)->default(0);
            $table->decimal('discount_value', 20, 2)->default(0);
            $table->decimal('after_discount', 20, 2)->default(0);
            $table->decimal('down_payment',20,2)->default(0);
            $table->decimal('down_payment_value', 20, 2)->default(0);
            $table->decimal('vat_value', 20, 2)->default(0);

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
            $table->dropColumn('discount');
            $table->dropColumn('discount_value');
            $table->dropColumn('after_discount');
            $table->dropColumn('down_payment');
            $table->dropColumn('down_payment_value');
            $table->dropColumn('vat_value');

        });
    }
}
