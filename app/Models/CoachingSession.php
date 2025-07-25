<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingSession extends Model
{
  use HasFactory;

    protected $fillable = [
        'topic',
        'description',
        'type',
        'coach_id',
        'session_date',
        'start_time',
        'capacity',
        'status',
        'created_by',
        'scheduled_at',
        'user_id',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function availableSlots()
    {
        return $this->capacity - $this->bookings()->count();
    }
}
