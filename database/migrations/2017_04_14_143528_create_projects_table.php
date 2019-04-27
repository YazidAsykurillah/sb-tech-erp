<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('category', ['internal', 'external'])->default('external')->comment("Internal project means this project is made by company it self");
            $table->string('code')->unique()->comment("The project number");
            $table->string('name');
            $table->integer('purchase_order_customer_id')->nullable()->comment('Related to the purchase_order_customers table, required if the project is external project');
            $table->integer('sales_id')->nullable()->comment('relate to the user with the role of sales, null if the project category is internal');
            $table->boolean('enabled')->default(TRUE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
