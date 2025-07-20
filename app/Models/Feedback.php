<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = ['submission_id', 'correct', 'incorrect'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
