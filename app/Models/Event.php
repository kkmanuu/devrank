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
    ];

    protected $casts = [
        'event_date' => 'date',
        'faqs' => 'array', // Cast faqs as array for JSON handling
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
        return 50 - $this->bookings()->count();
    }

}
