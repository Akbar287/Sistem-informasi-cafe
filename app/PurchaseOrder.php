<?php

namespace App;

class PurchaseOrder
{
    protected $primaryKey = 'purchase_order_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id', 'outlet_id', 'po_number', 'description', 'fob_id', 'term_po_id', 'isStatus', 'expected_date'
    ];
}
