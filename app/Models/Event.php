<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'agenda',
        'about',
        'faqs',
        'event_date',
        'start_time',
        'image',
        'created_by',
        'status',
        'location',
        'amount',
        'capacity',
    ];

    protected $casts = [
        'event_date' => 'date',
        'faqs' => 'array',
    ];

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
        return $this->morphMany(Payment::class, 'payable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'bookings', 'bookable_id', 'user_id')
            ->wherePivot('bookable_type', self::class)
            ->withTimestamps()
            ->withPivot('participated');
    }
}