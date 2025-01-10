<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\BRT;

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
    public function broadcastOn()
    {
        // Define a private channel for BRT notifications
        return new PrivateChannel('brt.notifications');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs()
    {
        return 'brt.notification';
    }

    /**
     * The data to broadcast.
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'brt' => [
                'id' => $this->brt->id,
                'brt_code' => $this->brt->brt_code,
                'reserved_amount' => $this->brt->reserved_amount,
                'status' => $this->brt->status,
                'created_at' => $this->brt->created_at->toDateTimeString(),
            ],
        ];
    }
}
