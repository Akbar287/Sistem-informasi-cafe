<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialPromo extends Model
{
    protected $primaryKey = 'special_promo_id';
    protected $table = 'special_promo';
    protected $fillable = [
        'name', 'discount', 'isType', 'isActive', 'start_date', 'end_date'
    ];
}
