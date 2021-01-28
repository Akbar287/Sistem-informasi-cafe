<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax', function (Blueprint $table) {
            $table->id('tax_id');
            $table->bigInteger('tax_type_id')->unsigned();
            $table->string('name', 64);
            $table->decimal('total', 18, 2);
            $table->timestamps();
            $table->foreign('tax_type_id')->references('tax_type_id')->on('tax_type')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax');
    }
}
