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
                </div>
            </div>
        </div>

        <!-- Analytics Dashboard -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Data Analytics Dashboard') }}</div>
            <ul class="mt-4 text-gray-600 space-y-2">
                <li>Total BRTs: <span id="totalBRTs" class="font-semibold">0</span></li>
                <li>Active BRTs: <span id="activeBRTs" class="font-semibold">0</span></li>
                <li>Expired BRTs: <span id="expiredBRTs" class="font-semibold">0</span></li>
                <li>Total Blume Coins Reserved: <span id="blumeCoinTotal" class="font-semibold">0</span></li>
            </ul>
        </div>

        <!-- Default Dashboard Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Dashboard') }}</div>
            <div class="mt-4">
                @if (session('status'))
                    <div class="bg-green-100 text-green-800 p-4 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
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
        newNotification.classList.add('bg-blue-100', 'text-blue-800', 'p-3', 'rounded-md', 'mb-2');
        newNotification.textContent = `BRT updated: ${JSON.stringify(event.brt)}`;
        notificationContainer.prepend(newNotification);

        // Update analytics data
        document.getElementById('totalBRTs').textContent = event.analytics.totalBRTs;
        document.getElementById('activeBRTs').textContent = event.analytics.activeBRTs;
        document.getElementById('expiredBRTs').textContent = event.analytics.expiredBRTs;
        document.getElementById('blumeCoinTotal').textContent = event.analytics.blumeCoinTotal;
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
