<?php

namespace App;

class ShoppingList
{
    protected $primaryKey = 'shopping_list_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'tax', 'discount', 'quantity', 'isDone'
    ];
}
