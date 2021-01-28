<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table = 'customer_address';
    protected $fillable = ['address_id', 'customer_id', 'isDefault'];
    public $timestamps = false;
}
