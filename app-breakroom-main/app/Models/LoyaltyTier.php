<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTier extends Model
{
    //
    protected $fillable = [
        'name',
        'required_points',
        'table_discount_percentage',
        'food_discount_percentage',
        'product_discount_percentage',
        'points_multiplier',
        'benefits'
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
