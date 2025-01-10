<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
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
        // Define the notification channels (e.g., database, mail)
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        // Store ticket data in the database notification table
        return [
            'ticket_id' => $this->ticket->id,
            'brt_code' => $this->ticket->brt_code,
            'reserved_amount' => $this->ticket->reserved_amount,
            'status' => $this->ticket->status,
        ];
    }

    public function toMail($notifiable)
    {
        // Optionally, you can send an email notification
        return (new MailMessage)
                    ->line('A new ticket has been assigned to you.')
                    ->action('View Ticket', url('/tickets/' . $this->ticket->id));
    }
}
