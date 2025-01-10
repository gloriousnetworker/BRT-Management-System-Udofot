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
        ]);

        $ticket = Ticket::create([
            'sender_id' => Auth::id(),
            'receiver_id' => Auth::user()->is_admin ? null : 1, // Admin gets user ticket; user gets admin ticket
            'brt_code' => $validated['brt_code'],
            'reserved_amount' => $validated['reserved_amount'],
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Ticket created successfully!');
    }
}
