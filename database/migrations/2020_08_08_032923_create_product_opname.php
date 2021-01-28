<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOpname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_opname', function (Blueprint $table) {
            $table->id('product_opname_id');
            $table->bigInteger('quantitySystem');
            $table->bigInteger('quantityActual');
            $table->bigInteger('deviation');
            $table->decimal('priceSystem', 18, 2);
            $table->decimal('priceActual', 18, 2);
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
        Schema::dropIfExists('product_opname');
    }
}
