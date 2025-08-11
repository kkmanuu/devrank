<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['user_id', 'project_id', 'score', 'status', 'feedback_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function rubricScores()
    {
        return $this->hasMany(RubricScore::class);
    }
}
?>
