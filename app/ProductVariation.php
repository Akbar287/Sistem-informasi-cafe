<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $primaryKey = 'product_variation_id';
    protected $table = 'product_variation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'cover', 'weight', 'dimension_id', 'isSale', 'isManageStock', 'price', 'sku', 'barcode', 'stock', 'isAlertStock'
    ];
}
