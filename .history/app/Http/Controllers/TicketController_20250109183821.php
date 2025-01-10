<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Notifications\TicketCreatedNotification;  // Import the notification
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;  // Import Notification facade

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'brt_code' => 'required|string|max:255',
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,expired,pending',
            'receiver_id' => 'required|exists:users,id', // Validate receiver exists in the users table
        ]);

        // Create the new ticket
        $ticket = Ticket::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'], // Use the receiver selected by Admin or default to 4 for non-admin
            'brt_code' => $validated['brt_code'],
            'reserved_amount' => $validated['reserved_amount'],
            'status' => $validated['status'],
        ]);

        // Notify the receiver with a real-time notification
        $ticket->receiver->notify(new TicketCreatedNotification($ticket));

        // Notify the admin (sender) as well
        $ticket->sender->notify(new TicketCreatedNotification($ticket));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Ticket created successfully!');
    }
}
