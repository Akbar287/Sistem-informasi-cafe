<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id('address_id');
            $table->string('country', 16);
            $table->string('province');
            $table->string('city');
            $table->string('District');
            $table->string('subDistrict');
            $table->tinyInteger('rw');
            $table->tinyInteger('rt');
            $table->tinyInteger('number_house');
            $table->string('postal_code',32);
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
        Schema::dropIfExists('address');
    }
}
