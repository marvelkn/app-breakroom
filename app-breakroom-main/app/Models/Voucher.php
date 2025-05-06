<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'voucher_type',     // 'table_discount', 'food_discount', 'product_discount'
        'discount_type',    // 'percentage' or 'fixed'
        'discount_value',
        'points_required',
        'min_purchase',
        'max_discount',
        'validity_days',
        'is_active',
        'stock'
    ];
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

}
