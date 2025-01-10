<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BRT;
use App\Events\BRTNotification;

class BRTController extends Controller
{
    /**
     * Store a newly created BRT in storage (User creates a BRT).
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'brt_code' => 'required|unique:brts,brt_code',
            'reserved_amount' => 'required|numeric',
            'status' => 'required|in:active,expired',
        ]);

        // Create the BRT for the authenticated user
        $brt = auth()->user()->brts()->create($validated);

        // Broadcast the creation event to notify admins
        event(new BRTNotification('Blume Reserve Ticket created successfully!', $brt));

        return response()->json(['message' => 'BRT created successfully', 'data' => $brt], 201);
    }

    /**
     * Display a listing of the BRTs for the authenticated user.
     */
    public function index()
    {
        $brts = auth()->user()->is_admin ? BRT::all() : auth()->user()->brts;
        return response()->json($brts);
    }

    /**
     * Update the specified BRT in storage (Admin updates a BRT).
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'brt_code' => "required|unique:brts,brt_code,$id",
            'reserved_amount' => 'required|numeric',
            'status' => 'required|in:active,expired',
        ]);

        // Fetch and update the BRT
        $brt = BRT::findOrFail($id);
        $brt->update($validated);

        // Broadcast the update event to notify the user and admins
        event(new BRTNotification('Blume Reserve Ticket updated successfully!', $brt));

        return response()->json(['message' => 'BRT updated successfully', 'data' => $brt]);
    }

    /**
     * Remove the specified BRT from storage (Admin deletes a BRT).
     */
    public function destroy($id)
    {
        $brt = BRT::findOrFail($id);
        $brt->delete();

        // Broadcast the deletion event to notify the user and admins
        event(new BRTNotification('Blume Reserve Ticket deleted successfully!', $brt));

        return response()->json(['message' => 'BRT deleted successfully'], 204);
    }

    /**
     * Fetch notifications for the admin in real-time.
     */
    public function notifications()
    {
        return response()->json(['message' => 'Notifications fetched successfully']);
    }
}
