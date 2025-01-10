<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    use HasFactory, Notifiable;  // Include the Notifiable trait to send notifications

    // Fillable fields for mass assignment
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'brt_code',
        'reserved_amount',
        'status',
    ];

    /**
     * Define the relationship with the User model (sender).
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Define the relationship with the User model (receiver).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Override the routeNotificationForBroadcast method to specify the broadcast channel.
     *
     * @return string
     */
    public function broadcastOn()
    {
        return new Channel('ticket.' . $this->ticket->receiver_id);
    }

}
