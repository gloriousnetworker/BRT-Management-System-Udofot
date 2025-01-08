<?php

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route to login and get a JWT token
Route::post('login', function (Request $request) {
    // Validate input data
    $credentials = $request->only('email', 'password');

    // Attempt to generate a token with the provided credentials
    if ($token = JWTAuth::attempt($credentials)) {
        return response()->json(['token' => $token]);
    }

    // Return error if authentication fails
    return response()->json(['error' => 'Unauthorized'], 401);
});

// Protect route with JWT authentication middleware
Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user(); // Return authenticated user data
});
