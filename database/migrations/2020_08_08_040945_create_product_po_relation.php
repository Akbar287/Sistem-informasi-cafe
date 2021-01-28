<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPoRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_po_relation', function (Blueprint $table) {
            $table->id('product_po_relation_id');
            $table->bigInteger('purchase_order_id')->unsigned();
            $table->bigInteger('product_purchase_order_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();

            $table->foreign('purchase_order_id')->references('purchase_order_id')->on('purchase_order')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('product_purchase_order_id')->references('product_purchase_order_id')->on('product_purchase_order')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('material_id')->references('material_id')->on('materials')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_po_relation');
    }
}
