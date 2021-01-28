<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'tax';
    protected $primaryKey = 'tax_id';
    protected $fillable = ['tax_type_id', 'name', 'total'];
}
