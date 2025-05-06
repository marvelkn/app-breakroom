<?php



// app/Models/Booking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'table_id', 'start_time', 'end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participants');
    }
}



