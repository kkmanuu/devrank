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
    'event_date',
    'start_time',
    'image',
    'created_by',
    'status',
];

 protected $casts = [
        'event_date' => 'date',
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
