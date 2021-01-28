<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('title', 64);
            $table->decimal('price', 18,2);
            $table->bigInteger('unit')->unsigned();
            $table->string('cover');
            $table->text('description');
            $table->tinyInteger('isAlertStock');
            $table->tinyInteger('isManageStock');
            $table->tinyInteger('isActive');
            $table->timestamps();
            $table->foreign('unit')->references('unit_id')->on('unit')->onDelete('cascade')->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
