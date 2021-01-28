<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_tax', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('tax_id')->unsigned();

            $table->foreign('supplier_id')->references('supplier_id')->on('supplier')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('tax_id')->references('tax_id')->on('tax')->onDelete('cascade')->onUpdate('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlet_tax');
    }
}
