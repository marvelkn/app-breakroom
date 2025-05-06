<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    //
    protected $fillable = [
        'user_id',
        'voucher_id',
        'code',
        'is_used',
        'purchased_at',
        'expires_at',
        'used_at',
        'used_reference_type',
        'used_reference_id'
    ];

    // Also, for models with timestamps that should be treated as dates, you might want to add:
    protected $casts = [
        'expires_at' => 'datetime',
        'purchased_at' => 'datetime',
        'used_at' => 'datetime'
    ];
    
    // This helps Laravel automatically convert these fields to Carbon instances for easier date manipulation.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
