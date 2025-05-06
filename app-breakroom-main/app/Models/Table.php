<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'number',
        'status',
        'capacity',
        'price',
        'image',
    ];
    public function tableBookings()
    {
        return $this->hasMany(TableBooking::class);
    }

    public function activeBooking()
    {
        return $this->hasOne(TableBooking::class)
            ->where('status', 'active')
            ->where('is_active', true)
            ->latest();
    }

    // Also add general bookings relationship
    public function bookings()
    {
        return $this->hasMany(TableBooking::class);
    }
}