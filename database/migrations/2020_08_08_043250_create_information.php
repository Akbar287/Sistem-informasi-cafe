<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id('information_id');
            $table->string('business_name');
            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('phone_number', 16);
            $table->string('round_off');
            $table->string('identity_number', 64);
            $table->string('taxpayer_number', 64);
            $table->string('entrepreneur_account', 64);
            $table->string('business_type', 64);
            $table->string('payment_method', 64);
            $table->string('sales_type', 64);
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
        Schema::dropIfExists('information');
    }
}
