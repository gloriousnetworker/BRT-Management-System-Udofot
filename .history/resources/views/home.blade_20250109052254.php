@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Display Logged-in User's Name -->
            <div class="card mb-4">
                <div class="card-header">{{ __('Welcome, ' . Auth::user()->name) }}</div>
                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>

            <!-- Notification Section -->
            <div id="notification-container">
                <div class="card mb-4">
                    <div class="card-header">{{ __('Real-Time Notifications') }}</div>
                    <div class="card-body">
                        <div id="notifications">
                            <!-- Notifications will be appended here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Dashboard -->
            <div class="card mb-4">
                <div class="card-header">{{ __('Data Analytics Dashboard') }}</div>
                <div class="card-body">
                    <ul>
                        <li>Total BRTs: <span id="totalBRTs">0</span></li>
                        <li>Active BRTs: <span id="activeBRTs">0</span></li>
                        <li>Expired BRTs: <span id="expiredBRTs">0</span></li>
                        <li>Total Blume Coins Reserved: <span id="blumeCoinTotal">0</span></li>
                    </ul>
                </div>
            </div>

            <!-- Default Dashboard Card -->
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
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
        newNotification.classList.add('alert', 'alert-info');
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
