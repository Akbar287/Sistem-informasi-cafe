<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('role_type_id')->unsigned();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('role_id')->references('role_id')->on('role')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('role_type_id')->references('role_type_id')->on('role_type')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
