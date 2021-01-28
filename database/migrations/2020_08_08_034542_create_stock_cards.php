<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_cards', function (Blueprint $table) {
            $table->id('stock_card_id');
            $table->bigInteger('type_stock_id')->unsigned();
            $table->bigInteger('transfer_stock_outlet_id')->unsigned();
            $table->string('code_id', 32);
            $table->text('description');
            $table->timestamps();

            $table->foreign('type_stock_id')->references('type_stock_id')->on('type_stock')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('transfer_stock_outlet_id')->references('transfer_stock_outlet_id')->on('transfer_stock_outlet')->onDelete('cascade')->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_cards');
    }
}
