<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dimensi extends Model
{
    protected $primaryKey = 'dimension_id';
    protected $table = 'dimension';
    public $timestamps = false;
    protected $fillable = ['length', 'width', 'height'];
}
