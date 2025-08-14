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
    'phone',
    'company',
    'subject',
    'message',
    'user_id',
    'replied_by',
    'status',
    'priority',
    'is_read',
    'reply',
    'replied_at',
    'newsletter',
];


    // Relationship to the user who sent the message
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the user/admin who replied to the message
    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by'); 
    }
}
