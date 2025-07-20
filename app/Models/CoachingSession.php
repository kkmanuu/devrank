<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coach_id',
        'topic',
        'session_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
