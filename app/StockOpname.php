<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $primaryKey = 'stock_opname_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stock_opname';
    protected $fillable = [
        'outlet_id', 'code_id', 'description'
    ];
}
