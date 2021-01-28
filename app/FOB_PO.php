<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FOB_PO extends Model
{
    protected $table = 'fob';
    protected $primaryKey = 'fob_id';
    protected $fillable = ['name', 'description'];
}
