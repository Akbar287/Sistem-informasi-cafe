<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MapsOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps_outlet', function (Blueprint $table) {
            $table->id('maps_outlet_id');
            $table->bigInteger('outlet_id')->unsigned();
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->timestamps();

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
        //
    }
}
