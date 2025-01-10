<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'brt_code' => 'required|string|max:255',
            'reserved_amount' => 'required|numeric',
            'status' => 'required|string|in:active,expired,pending',
        ]);

        $ticket = Ticket::create([
            'sender_id' => Auth::id(),
            'receiver_id' => Auth::user()->is_admin ? null : 1, // Admin gets user ticket; user gets admin ticket
            'brt_code' => $request->brt_code,
            'reserved_amount' => $request->reserved_amount,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Ticket created successfully!');
    }
}
