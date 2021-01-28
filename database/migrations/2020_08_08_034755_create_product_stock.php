<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock', function (Blueprint $table) {
            $table->id('product_stock_id');
            $table->bigInteger('product_variation_id')->unsigned();
            $table->bigInteger('quantity');
            $table->decimal('total', 18, 2);
            $table->timestamps();

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
        Schema::dropIfExists('product_stock');
    }
}
