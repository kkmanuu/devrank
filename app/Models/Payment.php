<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coaching_session_id',
        'bookable_id',
        'amount',
        'phone_number',
        'transaction_id',
        'status',
        'mpesa_request_id', 
        'mpesa_receipt_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function coachingSession()
{
    return $this->belongsTo(CoachingSession::class, 'coaching_session_id');
}

}
