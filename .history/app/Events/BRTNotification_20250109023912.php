<?php

namespace App\Events;

use App\Models\BRT;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class BRTNotification implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;
    public $brt;

    /**
     * Create a new event instance.
     */
    public function __construct($message, BRT $brt)
    {
        $this->message = $message;
        $this->brt = $brt;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('notifications');
    }
}
