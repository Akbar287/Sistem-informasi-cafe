<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'supplier';
    protected $fillable = [
        'company', 'name', 'phone_number', 'email', 'address'
    ];
}
