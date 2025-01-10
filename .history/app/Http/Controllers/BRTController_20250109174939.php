<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BRT;
use App\Events\BRTNotification;

class BRTController extends Controller
{
    /**
     * Store a newly created BRT in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brt_code' => 'required|unique:brts,brt_code|regex:/^[A-Z0-9]{6,}$/',
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,expired',
        ]);

        $brt = auth()->user()->brts()->create($validated);

        event(new BRTNotification('Blume Reserve Ticket created successfully!', $brt));

        return response()->json([
            'message' => 'BRT created successfully',
            'data' => $brt
        ], 201);
    }

    /**
     * Display a listing of the BRTs for the authenticated user.
     */
    public function index()
    {
        $brts = auth()->user()->is_admin ? BRT::all() : auth()->user()->brts;

        return response()->json($brts, 200);
    }

    /**
     * Update the specified BRT in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'brt_code' => "required|unique:brts,brt_code,$id|regex:/^[A-Z0-9]{6,}$/",
            'reserved_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,expired',
        ]);

        $brt = BRT::findOrFail($id);

        // Check if the user is authorized to update the BRT
        if (!auth()->user()->is_admin && $brt->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $brt->update($validated);

        event(new BRTNotification('Blume Reserve Ticket updated successfully!', $brt));

        return response()->json([
            'message' => 'BRT updated successfully',
            'data' => $brt
        ], 200);
    }

    /**
     * Remove the specified BRT from storage.
     */
    public function destroy($id)
    {
        $brt = BRT::findOrFail($id);

        // Check if the user is authorized to delete the BRT
        if (!auth()->user()->is_admin && $brt->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $brt->delete();

        event(new BRTNotification('Blume Reserve Ticket deleted successfully!', $brt));

        return response()->json(['message' => 'BRT deleted successfully'], 204);
    }

    /**
     * Fetch notifications for the admin in real-time.
     */
    public function notifications()
    {
        // Example logic for fetching notifications
        return response()->json(['message' => 'Notifications fetched successfully'], 200);
    }
}
