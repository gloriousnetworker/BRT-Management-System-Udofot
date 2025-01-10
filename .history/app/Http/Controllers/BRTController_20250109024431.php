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
        // Validate the request data
        $validated = $request->validate([
            'brt_code' => 'required|unique:brts,brt_code',
            'reserved_amount' => 'required|numeric',
            'status' => 'required|in:active,expired',
        ]);

        // Create the BRT for the authenticated user
        $brt = auth()->user()->brts()->create($validated);

        // Broadcast the creation event
        event(new BRTNotification('BRT created', $brt));

        return response()->json($brt, 201);
    }

    /**
     * Display a listing of the BRTs for the authenticated user.
     */
    public function index()
    {
        return response()->json(auth()->user()->brts);
    }

    /**
     * Display the specified BRT.
     */
    public function show($id)
    {
        $brt = auth()->user()->brts()->findOrFail($id);

        return response()->json($brt);
    }

    /**
     * Update the specified BRT in storage.
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
        $brt = auth()->user()->brts()->findOrFail($id);
        $brt->update($validated);

        // Broadcast the update event
        event(new BRTNotification('BRT updated', $brt));

        return response()->json($brt);
    }

    /**
     * Remove the specified BRT from storage.
     */
    public function destroy($id)
    {
        $brt = auth()->user()->brts()->findOrFail($id);
        $brt->delete();

        // Broadcast the deletion event
        event(new BRTNotification('BRT deleted', $brt));

        return response()->json(null, 204);
    }
}
