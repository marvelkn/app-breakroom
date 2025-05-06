<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user_id',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A booking belongs to one table
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
