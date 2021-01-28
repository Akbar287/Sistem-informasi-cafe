<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnameRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname_relation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stock_opname_id')->unsigned();
            $table->bigInteger('product_opname_id')->unsigned();
            $table->bigInteger('product_variation_id')->unsigned();

            $table->foreign('stock_opname_id')->references('stock_opname_id')->on('stock_opname')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('product_opname_id')->references('product_opname_id')->on('product_opname')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('stock_opname_relation');
    }
}
