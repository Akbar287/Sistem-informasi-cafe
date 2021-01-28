<?php

namespace App;

class Role
{
    protected $primaryKey = 'role_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isSuperAdmin', 'isCashier', 'isReprintReceipt', 'isCustomerManagement', 'isDeviceManagement', 'isInventoryManagement', 'isProductManagement', 'isPromoManagement', 'isEmployeeManagement', 'isViewReport', 'isPurchasingManagement'
    ];
}
