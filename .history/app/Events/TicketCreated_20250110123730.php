<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketId;
    public $ticketData;

    public function __construct(int $ticketId, array $ticketData)
    {
        $this->ticketId = $ticketId;
        $this->ticketData = $ticketData;
    }

    public function broadcastOn()
    {
        return new Channel('tickets');
    }

    public function broadcastAs()
    {
        return 'TicketCreated';
    }
}
