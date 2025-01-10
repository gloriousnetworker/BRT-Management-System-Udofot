<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use App\Events\TicketCreated;
use App\Events\TicketDeleted;
use App\Events\TicketUpdated;

class TicketController extends Controller
{
    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brt_code' => 'required|string|max:255',
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,expired,pending',
            'receiver_id' => 'required|exists:users,id', // Validate receiver exists in the users table
        ]);

        $ticket = Ticket::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'], // Use the receiver selected by Admin or default to 4 for non-admin
            'brt_code' => $validated['brt_code'],
            'reserved_amount' => $validated['reserved_amount'],
            'status' => $validated['status'],
        ]);

        // Broadcasting the event with the full ticket instance, not just the ticket ID
        broadcast(new TicketCreated($ticket))->toOthers();

        // Send success message for Toastr
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
     * Update the specified ticket.
     */
    public function update(Request $request, $id)
    {
        // Ensure the ticket exists
        $ticket = Ticket::findOrFail($id);

        // Authorization: Ensure only the ticket owner or an admin can update it
        if ($ticket->sender_id !== Auth::id() && !Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'You are not authorized to update this ticket.');
        }

        // Validate the input
        $validated = $request->validate([
            'brt_code' => 'required|string|max:255',
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,expired,pending',
        ]);

        // Update the ticket
        $ticket->update($validated);

        // Broadcasting the event
        broadcast(new TicketUpdated($ticket))->toOthers();

        // Redirect with success message
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully!');
    }



    /**
     * Delete the specified ticket.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        // Broadcasting the event with only the ticket ID
        broadcast(new TicketDeleted($ticket->id))->toOthers();

        // Send success message for Toastr
        return redirect()->back()->with('success', 'Ticket deleted successfully!');
    }
}
