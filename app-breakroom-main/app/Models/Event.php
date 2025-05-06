<?php
// app/Models/Event.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'location',
        'status',
        'max_participants',
        'image'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];
    

    // Scope untuk event mendatang
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now());
    }

    // Relasi many-to-many untuk peserta event
    // public function participants()
    // {
    //     return $this->belongsToMany(User::class, 'event_participants');
    // }
    public function eventRegistration(){
        return $this->hasMany(EventRegistration::class);
    }
}