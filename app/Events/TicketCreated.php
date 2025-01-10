<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        // Broadcast to a channel specific to the receiver's ID
        return new Channel('user-' . $this->ticket->receiver_id);
    }

    /**
     * The data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'ticket' => [
                'id' => $this->ticket->id,
                'brt_code' => $this->ticket->brt_code,
                'reserved_amount' => $this->ticket->reserved_amount,
                'status' => $this->ticket->status,
                'created_at' => $this->ticket->created_at,
                'sender_id' => $this->ticket->sender_id,
                'receiver_id' => $this->ticket->receiver_id,
            ]
        ];
    }
}
