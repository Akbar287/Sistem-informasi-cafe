<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_product', function (Blueprint $table) {
            $table->id('tax_product_id');
            $table->bigInteger('product_id')->unsigned();
            $table->tinyInteger('isTax');

            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_product');
    }
}
