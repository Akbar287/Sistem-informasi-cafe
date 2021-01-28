<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimension extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimension', function (Blueprint $table) {
            $table->id('dimension_id');
            $table->decimal('length', 5 ,2);
            $table->decimal('width', 5 ,2);
            $table->decimal('height', 5 ,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dimension');
    }
}
