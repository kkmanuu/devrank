<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'company',
        'type',
        'message',
        'user_id',
        'is_read',
        'reply', // add if you are storing admin replies
    ];

    // Relationship to the user who sent the message
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
