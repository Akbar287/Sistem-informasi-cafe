<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outlet', function (Blueprint $table) {
            $table->id('stock_outlet_id');
            $table->bigInteger('product_variation_id')->unsigned();
            $table->bigInteger('outlet_id')->unsigned();
            $table->integer('stock');
            $table->timestamps();

            $table->foreign('product_variation_id')->references('product_variation_id')->on('product_variation')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('outlet_id')->references('outlet_id')->on('outlet')->onDelete('cascade')->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_outlet');
    }
}
