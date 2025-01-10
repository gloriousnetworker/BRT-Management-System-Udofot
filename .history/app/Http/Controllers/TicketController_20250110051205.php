<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

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


    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'brt_code' => 'required|string|max:255',
        'reserved_amount' => 'required|numeric|min:0',
        'status' => 'required|string|in:active,expired,pending',
    ]);

    $ticket = Ticket::findOrFail($id);
    $ticket->update($validated);

    broadcast(new TicketUpdated($ticket))->toOthers();

    return redirect()->back()->with('success', 'Ticket updated successfully!');
}

public function destroy($id)
{
    $ticket = Ticket::findOrFail($id);
    $ticket->delete();


    broadcast(new TicketDeleted($ticket))->toOthers();

    return redirect()->back()->with('success', 'Ticket deleted successfully!');
}

}
