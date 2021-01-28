<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id('role_id');
            $table->tinyInteger('isSuperAdmin');
            $table->tinyInteger('isCashier');
            $table->tinyInteger('isReprintReceipt');
            $table->tinyInteger('isCustomerManagement');
            $table->tinyInteger('isDeviceManagement');
            $table->tinyInteger('isInventoryManagement');
            $table->tinyInteger('isProductManagement');
            $table->tinyInteger('isPromoManagement');
            $table->tinyInteger('isEmployeeManagement');
            $table->tinyInteger('isViewReport');
            $table->tinyInteger('isPurchasingManagement');
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
        Schema::dropIfExists('role');
    }
}
