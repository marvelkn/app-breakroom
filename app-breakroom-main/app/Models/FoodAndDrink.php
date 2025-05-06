<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodAndDrink extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'category', 'price', 'image'
    ];
}
