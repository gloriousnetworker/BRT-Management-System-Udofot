<?php

use Illuminate\Support\Facades\Broadcast;

// Private channel for a specific user (authenticated user only)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id; // Ensures only the matching user can listen
});

// Public channel for notifications (can be used for general events like admin notifications)
Broadcast::channel('tickets', function () {
    return true; // Can be set to `Auth::check()` if authentication is required for this channel
});
