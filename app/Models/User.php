<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable


{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * User has many projects.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * User has many submissions through projects.
     */
    public function submissions()
    {
        return $this->hasManyThrough(Submission::class, Project::class);
    }

    /**
     * User has many bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * User has many coaching sessions through bookings.
     */
    public function coachingSessions()
    {
        return $this->hasManyThrough(
            CoachingSession::class,
            Booking::class,
            'user_id', // Foreign key on bookings table
            'id', // Foreign key on coaching_sessions table
            'id', // Local key on users table
            'bookable_id' // Local key on bookings table
        )->where('bookings.bookable_type', CoachingSession::class);
    }

    /**
     * User has many messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * User has many contact messages.
     */
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function customNotifications()
{
    return $this->hasMany(\App\Models\Notification::class, 'user_id');
}


    /**
     * User has many badges.
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user')
                    ->withTimestamps()
                    ->withPivot('awarded_at');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'bookings', 'user_id', 'bookable_id')
                    ->wherePivot('bookable_type', Event::class)
                    ->withTimestamps()
                    ->withPivot('participated');
    }
}
