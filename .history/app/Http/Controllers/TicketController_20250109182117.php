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
}
