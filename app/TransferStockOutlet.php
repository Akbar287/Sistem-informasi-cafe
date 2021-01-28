<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferStockOutlet extends Model
{
    protected $primaryKey = 'transfer_stock_outlet_id';
    protected $table = 'transfer_stock_outlet';
    protected $fillable = ['byOutlet_id', 'toOutlet_id'];
    public $timestamps = false;
}
