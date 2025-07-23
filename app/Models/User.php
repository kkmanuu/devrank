<?php

namespace App\Models;

use App\Models\CoachingSession; 
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    // User has many projects


    public function bookings()
{
    return $this->hasMany(\App\Models\Booking::class);
}

    public function messages()
{
    return $this->hasMany(Message::class);
}

public function projects()
{
    return $this->hasMany(Project::class);
}
public function badges()
{
    return $this->belongsToMany(Badge::class, 'badge_user')
                ->withTimestamps()
                ->withPivot('awarded_at');
}


// User has many submissions through projects
public function submissions()
{
    return $this->hasManyThrough(Submission::class, Project::class);
}


    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Coaching sessions booked by the user (student).
     */
    public function coachingSessions()
    {
        return $this->hasMany(CoachingSession::class, 'user_id');
    }
}
