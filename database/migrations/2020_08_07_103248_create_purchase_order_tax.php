<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_tax', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_purchase_order_id')->unsigned();
            $table->bigInteger('tax_id')->unsigned();

            $table->foreign('product_purchase_order_id')->references('product_purchase_order_id')->on('product_purchase_order')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('tax_id')->references('tax_id')->on('tax')->onDelete('cascade')->onUpdate('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlet_tax');
    }
}
