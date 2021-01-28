<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_relation', function (Blueprint $table) {
            $table->id();
            $table->string('variation_name');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('product_variation_id')->unsigned();

            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('product_variation_id')->references('product_variation_id')->on('product_variation')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_relation');
    }
}
