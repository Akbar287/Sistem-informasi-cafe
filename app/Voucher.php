<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $primaryKey = 'voucher_id';
    protected $table = 'voucher';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'discount', 'isActive', 'isType', 'description', 'start_date', 'end_date'
    ];
}
