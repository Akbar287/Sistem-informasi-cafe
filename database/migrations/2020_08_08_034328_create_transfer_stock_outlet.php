<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferStockOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_stock_outlet', function (Blueprint $table) {
            $table->id('transfer_stock_outlet_id');
            $table->bigInteger('byOutlet_id')->unsigned();
            $table->bigInteger('toOutlet_id')->unsigned();

            $table->foreign('byOutlet_id')->references('outlet_id')->on('outlet')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('toOutlet_id')->references('outlet_id')->on('outlet')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_stock_outlet');
    }
}
