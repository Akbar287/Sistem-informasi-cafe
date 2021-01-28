<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_outlet', function (Blueprint $table) {
            $table->id('voucher_outlet_id');
            $table->bigInteger('voucher_id')->unsigned();
            $table->bigInteger('outlet_id')->unsigned();

            $table->foreign('voucher_id')->references('voucher_id')->on('voucher')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('voucher_outlet');
    }
}
