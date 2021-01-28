<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->id('receipt_id');
            $table->string('name');
            $table->string('logo', 128);
            $table->tinyInteger('isLogo');
            $table->text('description');
            $table->string('facebook', 128);
            $table->tinyInteger('isFacebook');
            $table->string('twitter', 128);
            $table->tinyInteger('isTwitter');
            $table->string('instagram', 128);
            $table->tinyInteger('isInstagram');
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
        Schema::dropIfExists('receipt');
    }
}
