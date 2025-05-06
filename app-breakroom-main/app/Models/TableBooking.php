<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableBooking extends Model
{
    protected $fillable = [
        'user_id',
        'table_id',
        'booking_time',
        'booking_type',
        'duration',
        'original_price',
        'started_at',
        'end_time',
        'final_duration',
        'status',
        'is_active',
        'loyalty_discount',
        'voucher_discount',
        'used_voucher_id',
        'final_price',
    ];

    //
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A booking belongs to one table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function usedVoucher()
    {
        return $this->belongsTo(UserVoucher::class, 'used_voucher_id');
    }
}
