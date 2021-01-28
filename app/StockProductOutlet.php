<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockProductOutlet extends Model
{
    protected $table = 'stock_outlet';
    protected $primaryKey = 'stock_outlet_id';
    protected $fillable = ['product_variation_id', 'outlet_id', 'stock'];
}
