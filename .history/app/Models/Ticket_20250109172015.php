<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'brt_code',
        'reserved_amount',
        'status',
    ];

    // Define the relationship with the User model (sender)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Define the relationship with the User model (receiver)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
