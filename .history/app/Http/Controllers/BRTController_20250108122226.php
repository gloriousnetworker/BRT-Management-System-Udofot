<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BRT;
use App\Models\User;

class BRTController extends Controller
{
    /**
     * Store a newly created BRT in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'brt_code' => 'required|unique:brts', // This code ensures the brt_code is unique
            'reserved_amount' => 'required|numeric', // Here,  reserved_amount is numeric
            'status' => 'required|in:active,expired', // Status can be either active or expired
        ]);

        // Create the BRT and associate it with the authenticated user
        $brt = auth()->user()->brts()->create($validated);

        // Optionally broadcast a BRTCreated event if needed
        // broadcast(new BRTCreated($brt))->toOthers();

        return response()->json($brt, 201); // Return the created BRT
    }

    /**
     * Display a listing of the BRTs for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve and return all BRTs associated with the authenticated user
        return response()->json(auth()->user()->brts);
    }

    /**
     * Display the specified BRT by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch the BRT by ID for the authenticated user
        $brt = auth()->user()->brts()->findOrFail($id);

        // Return the BRT as a response
        return response()->json($brt);
    }

    /**
     * Update the specified BRT in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'brt_code' => 'required|unique:brts,brt_code,' . $id, // Exclude current BRT code from uniqueness check
            'reserved_amount' => 'required|numeric', // Ensure reserved_amount is numeric
            'status' => 'required|in:active,expired', // Ensure status is either active or expired
        ]);

        // Fetch the BRT for the authenticated user
        $brt = auth()->user()->brts()->findOrFail($id);

        // Update the BRT with the validated data
        $brt->update($validated);

        // Return the updated BRT
        return response()->json($brt);
    }

    /**
     * Remove the specified BRT from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Fetch the BRT for the authenticated user
        $brt = auth()->user()->brts()->findOrFail($id);

        // Delete the BRT
        $brt->delete();

        // Return a 204 No Content response to indicate successful deletion
        return response()->json(null, 204);
    }
}
