<?php

use Illuminate\Support\Facades\Broadcast;

// Private channel for a specific user (authenticated user only)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id; // Ensures only the matching user can listen
});

// Private channel for ticket notifications specific to the receiver
Broadcast::channel('ticket.{receiverId}', function ($user, $receiverId) {
    return $user->id == $receiverId; // Ensures only the receiver of the ticket can listen
});

// Public channel for notifications (can be used for general events like admin notifications)
Broadcast::channel('admin-notifications', function () {
    return true; // Allows anyone to join this channel
});
