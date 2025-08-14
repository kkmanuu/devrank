<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Check if the user is an admin. */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Check if the user is a student. */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /** User has many projects. */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /** User has many submissions through projects. */
    public function submissions()
    {
        return $this->hasManyThrough(Submission::class, Project::class);
    }

    /** User has many bookings. */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /** User has many coaching sessions through bookings. */
    public function coachingSessions()
    {
        return $this->hasManyThrough(
            CoachingSession::class,
            Booking::class,
            'user_id',
            'id',
            'id',
            'bookable_id'
        )->where('bookings.bookable_type', CoachingSession::class);
    }

    /** User has many messages. */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /** User has many contact messages. */
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function customNotifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id');
    }

    /** User has many badges. */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user')
                    ->withTimestamps()
                    ->withPivot('awarded_at');
    }

    /** User has many events through bookings. */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'bookings', 'user_id', 'bookable_id')
                    ->wherePivot('bookable_type', Event::class)
                    ->withTimestamps()
                    ->withPivot('participated');
    }

    /** ✅ User has many payments. */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    /** ✅ Check if user has an active payment. */
    public function hasActivePayment(): bool
    {
        return $this->payments()
                    ->where('status', 'completed')
                    ->where('created_at', '>=', now()->subMonth()) // adjust logic if needed
                    ->exists();
    }
}
