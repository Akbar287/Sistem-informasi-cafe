<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapsOutlet extends Model
{
    protected $table = 'maps_outlet';
    protected $primaryKey = 'maps_outlet_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lat', 'lng', 'outlet_id'
    ];
}
