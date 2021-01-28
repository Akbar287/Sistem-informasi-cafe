<?php

namespace App;

class ProductPurchaseOrder
{
    protected $primaryKey = 'product_purchase_order_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity_order, quantity_received, price_per_unit, price_total'
    ];
}
