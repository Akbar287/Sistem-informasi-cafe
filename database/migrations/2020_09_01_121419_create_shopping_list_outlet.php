<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingListOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_list_outlet', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopping_list_id')->unsigned();
            $table->bigInteger('outlet_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();

            $table->foreign('shopping_list_id')->references('shopping_list_id')->on('shopping_list')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('outlet_id')->references('outlet_id')->on('outlet')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('shopping_list_outlet');
    }
}
