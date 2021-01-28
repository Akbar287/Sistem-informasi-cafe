<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOpname extends Model
{
    protected $table = 'product_opname';
    protected $primaryKey = 'product_opname_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity_system', 'quantity_actual', 'deviation', 'price_system', 'price_actual'
    ];
}
