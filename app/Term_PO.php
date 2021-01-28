<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term_PO extends Model
{
    protected $table = 'terms_purchase_order';
    protected $primaryKey = 'term_id';
    protected $fillable = ['term', 'description'];
}
