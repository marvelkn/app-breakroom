<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'transaction_type', // 'earn' or 'redeem'
        'points',
        'reference_type',   // 'table_booking', 'food_order', 'product_purchase', 'voucher_redemption'
        'reference_id',
        'description'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
