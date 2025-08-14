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
        'developer_type', // Added new field
        'coach_id',
        'session_date',
        'start_time',
        'capacity',
        'status',
        'created_by',
        'scheduled_at',
        'user_id',
        'amount', 
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

 public function payments()
{
    return $this->hasMany(Payment::class, 'coaching_session_id');
}

    public function getDeveloperTypeDisplayAttribute()
    {
        return ucfirst($this->developer_type) . ' Developer';
    }
}