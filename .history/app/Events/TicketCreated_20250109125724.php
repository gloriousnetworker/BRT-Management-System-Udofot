<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\TicketCreated;

class TicketCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('admin-notifications');
    }

    public function broadcastWith()
    {
        return ['ticket' => $this->ticket];
    }

    public function store(Request $request)
{
    $ticket = Ticket::create($request->all());
    broadcast(new TicketCreated($ticket))->toOthers();

    return response()->json(['message' => 'Ticket created successfully.']);
}
}
