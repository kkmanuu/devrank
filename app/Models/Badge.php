<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    // Many-to-many relationship with User
    public function users()
    {
        return $this->belongsToMany(User::class, 'badge_user')
                    ->withTimestamps()
                    ->withPivot('awarded_at'); // Optional pivot data
    }
}
