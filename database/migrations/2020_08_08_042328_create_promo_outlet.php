<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_outlet', function (Blueprint $table) {
            $table->id('promo_outlet_id');
            $table->bigInteger('special_promo_id')->unsigned();
            $table->bigInteger('outlet_id')->unsigned();

            $table->foreign('special_promo_id')->references('special_promo_id')->on('special_promo')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('promo_outlet');
    }
}
