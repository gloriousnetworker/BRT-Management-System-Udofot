@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Welcome User Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Welcome, ' . Auth::user()->name) }}</div>
            <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
        </div>

        <!-- Admin Analytics Dashboard (Visible only for Admin) -->
        @if(Auth::user()->is_admin) <!-- Assuming you have a `is_admin` field in your user table -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">{{ __('Admin Analytics Dashboard') }}</div>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="font-medium text-gray-700">Total BRTs Created</h3>
                    <p class="text-xl font-semibold text-blue-500">{{ $totalBRTs }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="font-medium text-gray-700">Active BRTs</h3>
                    <p class="text-xl font-semibold text-green-500">{{ $activeBRTs }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="font-medium text-gray-700">Expired BRTs</h3>
                    <p class="text-xl font-semibold text-red-500">{{ $expiredBRTs }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="font-medium text-gray-700">BRTs Created This Week</h3>
                    <p class="text-xl font-semibold text-blue-500">{{ $brtsThisWeek }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="font-medium text-gray-700">BRTs Created This Month</h3>
                    <p class="text-xl font-semibold text-blue-500">{{ $brtsThisMonth }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="font-medium text-gray-700">Total Blume Coins Reserved</h3>
                    <p class="text-xl font-semibold text-yellow-500">{{ $totalBlumeCoins }} BLUME COINS</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Ticket Creation Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Create a New Ticket') }}</div>
            <form id="ticket-form" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="brt_code" class="block text-sm font-medium text-gray-700">BRT Code</label>
                    <input type="text" name="brt_code" id="brt_code" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="reserved_amount" class="block text-sm font-medium text-gray-700">Reserved Amount</label>
                    <input type="number" name="reserved_amount" id="reserved_amount" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-md">Create Ticket</button>
            </form>
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
                        <button class="text-blue-500 ml-2 update-btn">Update</button>
                        <button class="text-red-500 ml-2 delete-btn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>

<script>
    // Initialize Pusher
    Pusher.logToConsole = true;

    var pusher = new Pusher('your-pusher-app-key', {
        cluster: 'your-pusher-cluster',
    });

    var channel = pusher.subscribe('brt-channel');
    channel.bind('brt-updated', function(event) {
        var notificationContainer = document.getElementById('notifications');
        var newNotification = document.createElement('div');
        var currentTime = new Date().toLocaleTimeString();

        if (event.brt.status === 'created') {
            newNotification.classList.add('bg-green-100', 'text-green-800', 'p-3', 'rounded-md', 'mb-2');
            newNotification.innerHTML = `BRT CODE: ${event.brt.brt_code} ${event.brt.reserved_amount} BLUME COIN RESERVED
                <span class="text-sm text-gray-600 ml-2">${currentTime}</span>
                <button class="text-blue-500 ml-2 update-btn" data-id="${event.brt.id}">Update</button>
                <button class="text-red-500 ml-2 delete-btn" data-id="${event.brt.id}">Delete</button>`;
            notificationContainer.prepend(newNotification);
            toastr.success('Ticket Created Successfully!');
        }
    });

    // Handle Ticket Form Submission
    document.getElementById('ticket-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Get form data
        var brt_code = document.getElementById('brt_code').value;
        var reserved_amount = document.getElementById('reserved_amount').value;
        var status = document.getElementById('status').value;

        // Send data to the server
        fetch('/create-ticket', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                brt_code: brt_code,
                reserved_amount: reserved_amount,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Trigger Pusher event
                pusher.trigger('brt-channel', 'brt-updated', {
                    brt: data.ticket
                });

                // Reset form
                document.getElementById('ticket-form').reset();
            } else {
                toastr.error('Error creating ticket');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error creating ticket');
        });
    });

    // Handle Update and Delete Buttons
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('update-btn')) {
            const ticketId = event.target.getAttribute('data-id');
            alert(`Update Ticket with ID: ${ticketId}`);
            // Implement your update logic here
        } else if (event.target.classList.contains('delete-btn')) {
            const ticketId = event.target.getAttribute('data-id');
            alert(`Delete Ticket with ID: ${ticketId}`);
            // Implement your delete logic here
        }
    });
</script>
@endpush
