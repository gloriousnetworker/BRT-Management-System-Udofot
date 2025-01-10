<?php

namespace App\Events;

use App\Models\BRT;  // Import the BRT model if needed
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BRTCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $brt;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\BRT  $brt
     * @return void
     */
    public function __construct(BRT $brt)
    {
        $this->brt = $brt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('brts'), // Public channel
        ];
    }

    /**
     * Get the name of the event being broadcast.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'brt.created';  // Event name for frontend listener
    }
}
