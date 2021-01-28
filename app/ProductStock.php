<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $primaryKey = 'product_stock_id';
    protected $table = 'product_stock';
    protected $fillable = [
        'stock_card_id', 'product_variation_id', 'quantity', 'total'
    ];
}
