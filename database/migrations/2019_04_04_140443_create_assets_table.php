<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('price',20,2)->default(0)->comment('Harga aset');
            $table->integer('asset_category_id')->nullable()->comment('Asset category, related to AssetCategory model');
            $table->enum('type',['current','fixed','intangible'])->nullable()->comment('Current = lancar, fixed = tetap, intangible = tidak berwujud');
            $table->text('description');
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
        Schema::drop('assets');
    }
}
