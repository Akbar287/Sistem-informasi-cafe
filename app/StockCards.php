<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockCards extends Model
{
    protected $primaryKey = 'stock_card_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'stock_cards';
    protected $fillable = [
        'type_stock_id', 'transfer_stock_outlet_id', 'code_id', 'description', 'created_at'
    ];
}
