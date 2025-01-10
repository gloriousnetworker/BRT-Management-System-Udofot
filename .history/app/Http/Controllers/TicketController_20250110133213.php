<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User; // Import User model
use Illuminate\Support\Facades\Auth;
use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use App\Events\TicketDeleted;
use App\Notifications\TicketNotification;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'brt_code' => 'required|string|max:255',
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,expired,pending',
            'receiver_id' => 'required|exists:users,id', // Validate receiver exists in the users table
        ]);

        // Create the ticket
        $ticket = Ticket::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'brt_code' => $validated['brt_code'],
            'reserved_amount' => $validated['reserved_amount'],
            'status' => $validated['status'],
        ]);

        // Broadcast the event to others
        broadcast(new TicketCreated($ticket->id, $ticket->toArray()))->toOthers();

        // Send a notification to the receiver (admin or user)
        $receiver = User::find($validated['receiver_id']);
        if ($receiver->is_admin) {
            // Notify the admin (Optional: send custom admin notification or broadcast)
            $receiver->notify(new TicketNotification($ticket)); // Example of a Laravel Notification
        } else {
            // Notify the user
            $receiver->notify(new TicketNotification($ticket)); // Example of a Laravel Notification
        }

        return redirect()->back()->with('success', 'Ticket created successfully!');
    }

    /**
     * Fetch tickets for admin or regular user.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            // Admin: Fetch all tickets sent by users
            $tickets = Ticket::with('sender')->orderBy('created_at', 'desc')->get();
        } else {
            // Regular user: Fetch tickets sent to them
            $tickets = Ticket::where('receiver_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('home', compact('tickets'));
    }

    /**
     * Update an existing ticket in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validated = $request->validate([
            'brt_code' => 'required|string|max:255',
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,expired,pending',
        ]);

        // Find and update the ticket
        $ticket = Ticket::findOrFail($id);
        $ticket->update($validated);

        // Broadcast the event to others
        broadcast(new TicketUpdated($ticket->id, $ticket->toArray()))->toOthers();

        // Notify the receiver of the updated ticket
        $receiver = User::find($ticket->receiver_id);
        $receiver->notify(new TicketNotification($ticket)); // Example of a Laravel Notification

        return redirect()->back()->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove a ticket from storage.
     */
    public function destroy($id)
    {
        // Find and delete the ticket
        $ticket = Ticket::findOrFail($id);
        $ticketId = $ticket->id;

        $ticket->delete();

        // Broadcast the event to others
        broadcast(new TicketDeleted($ticketId))->toOthers();

        // Notify the receiver of the deleted ticket
        $receiver = User::find($ticket->receiver_id);
        $receiver->notify(new TicketNotification($ticket)); // Example of a Laravel Notification

        return redirect()->back()->with('success', 'Ticket deleted successfully!');
    }
}
