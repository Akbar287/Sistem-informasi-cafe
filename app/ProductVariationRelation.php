<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariationRelation extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'product_variation_relation';
    protected $fillable = ['variation_name', 'product_id', 'product_variation_id'];
    public $timestamps = false;
}
