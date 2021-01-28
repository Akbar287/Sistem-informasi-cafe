<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $primaryKey = 'material_id';
    protected $table = 'materials';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'price', 'unit', 'cover', 'description', 'isAlertStock', 'isManageStock', 'isActice'
    ];

}
