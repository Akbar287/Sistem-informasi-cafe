<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id('purchase_order_id');
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('outlet_id')->unsigned();
            $table->string('po_number', 32)->unique();
            $table->text('description');
            $table->bigInteger('fob_id')->unsigned();
            $table->bigInteger('term_po_id')->unsigned();
            $table->tinyInteger('isStatus');
            $table->timestamp('expected_date');
            $table->timestamps();

            $table->foreign('supplier_id')->references('supplier_id')->on('supplier')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('fob_id')->references('fob_id')->on('fob')->onDelete('cascade')->onUpdate('restrict');
            $table->foreign('term_po_id')->references('term_po_id')->on('terms_purchase_order')->onDelete('cascade')->onUpdate('restrict');
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
        Schema::dropIfExists('purchase_order');
    }
}
