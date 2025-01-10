<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Ticket;

class TicketNotification extends Notification
{
    protected $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['broadcast']; // This will use the broadcast channel
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'ticketId' => $this->ticket->id,
            'ticketData' => $this->ticket->toArray(),
        ]);
    }
}
