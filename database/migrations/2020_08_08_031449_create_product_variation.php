<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation', function (Blueprint $table) {
            $table->id('product_variation_id');
            $table->string('title');
            $table->string('cover', 128);
            $table->decimal('weight', 5, 2);
            $table->bigInteger('dimension_id')->unsigned();
            $table->string('cover', 128);
            $table->tinyInteger('isSale');
            $table->tinyInteger('isManageStock');
            $table->decimal('price', 18, 2);
            $table->string('sku', 32);
            $table->string('barcode', 48);
            $table->bigInteger('stock');
            $table->tinyInteger('isAlertStock');
            $table->timestamps();

            $table->foreign('dimension_id')->references('dimension_id')->on('dimension')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation');
    }
}
