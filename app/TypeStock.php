<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeStock extends Model
{
    protected $primaryKey = 'type_stock_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'type_stock';
    protected $fillable = [
        'name', 'code_id', 'description'
    ];
}
