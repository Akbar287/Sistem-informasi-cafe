<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_order', function (Blueprint $table) {
            $table->id('product_purchase_order_id');
            $table->integer('quantity_order');
            $table->integer('quantity_received');
            $table->decimal('price_per_unit', 18, 2);
            $table->decimal('price_total', 18, 2);
            $table->decimal('discount', 18, 2);
            $table->decimal('tax', 18, 2);
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
        Schema::dropIfExists('product_purchase_order');
    }
}
