@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Welcome User Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Welcome, ' . Auth::user()->name) }}</div>
            <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
        </div>

        <!-- Notification Section -->
        <div id="notification-container" class="space-y-4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="text-xl font-semibold text-gray-800">{{ __('Real-Time Notifications') }}</div>
                <div class="mt-4" id="notifications">
                    <!-- Notifications will be appended here -->
                    <!-- Dummy Data -->
                    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-2">
                        BRT ONE 20 BLUME COIN RECEIVED
                        <span class="text-sm text-gray-600 ml-2">3 minutes ago</span>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded-md mb-2">
                        BRT ALPINE 50 BLUME COIN UPDATED
                        <span class="text-sm text-gray-600 ml-2">5 minutes ago</span>
                    </div>
                    <div class="bg-red-100 text-red-800 p-3 rounded-md mb-2">
                        BRT TWO 100 BLUME COIN DELETED
                        <span class="text-sm text-gray-600 ml-2">10 minutes ago</span>
                    </div>
                    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-2">
                        BRT ONE 20 BLUME COIN RECEIVED
                        <span class="text-sm text-gray-600 ml-2">15 minutes ago</span>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded-md mb-2">
                        BRT ALPINE 50 BLUME COIN UPDATED
                        <span class="text-sm text-gray-600 ml-2">20 minutes ago</span>
                    </div>
                    <div class="bg-red-100 text-red-800 p-3 rounded-md mb-2">
                        BRT TWO 100 BLUME COIN DELETED
                        <span class="text-sm text-gray-600 ml-2">25 minutes ago</span>
                    </div>
                    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-2">
                        BRT ONE 20 BLUME COIN RECEIVED
                        <span class="text-sm text-gray-600 ml-2">30 minutes ago</span>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded-md mb-2">
                        BRT ALPINE 50 BLUME COIN UPDATED
                        <span class="text-sm text-gray-600 ml-2">35 minutes ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Initialize Pusher
    Pusher.logToConsole = true;

    var pusher = new Pusher('your-pusher-app-key', {
        cluster: 'your-pusher-cluster',
    });

    var channel = pusher.subscribe('brt-channel');
    channel.bind('brt-updated', function(event) {
        // Display notification
        var notificationContainer = document.getElementById('notifications');
        var newNotification = document.createElement('div');
        var currentTime = new Date().toLocaleTimeString();
        if (event.brt.status === 'created') {
            newNotification.classList.add('bg-green-100', 'text-green-800', 'p-3', 'rounded-md', 'mb-2');
            newNotification.innerHTML = `BRT ONE ${event.brt.amount} BLUME COIN RECEIVED
                <span class="text-sm text-gray-600 ml-2">${currentTime}</span>`;
        } else if (event.brt.status === 'updated') {
            newNotification.classList.add('bg-yellow-100', 'text-yellow-800', 'p-3', 'rounded-md', 'mb-2');
            newNotification.innerHTML = `BRT ALPINE ${event.brt.amount} BLUME COIN UPDATED
                <span class="text-sm text-gray-600 ml-2">${currentTime}</span>`;
        } else if (event.brt.status === 'deleted') {
            newNotification.classList.add('bg-red-100', 'text-red-800', 'p-3', 'rounded-md', 'mb-2');
            newNotification.innerHTML = `BRT TWO ${event.brt.amount} BLUME COIN DELETED
                <span class="text-sm text-gray-600 ml-2">${currentTime}</span>`;
        }
        notificationContainer.prepend(newNotification);
    });

    // Toggle Navbar (for Bootstrap)
    document.addEventListener("DOMContentLoaded", function() {
        var toggleButton = document.querySelector('.navbar-toggler');
        var navbarCollapse = document.querySelector('.navbar-collapse');
        if (toggleButton && navbarCollapse) {
            toggleButton.addEventListener('click', function() {
                navbarCollapse.classList.toggle('show');
            });
        }
    });
</script>
@endpush
