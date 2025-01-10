<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        $(document).ready(function() {
            // Display Toastr notification on page load if there's any session message
            @if (session('success'))
                toastr.success("{{ session('success') }}", 'Success');
            @elseif (session('error'))
                toastr.error("{{ session('error') }}", 'Error');
            @endif

            // Pusher setup
            Pusher.logToConsole = true;
            var pusher = new Pusher('fd7cc9ca454f87cc9526', { cluster: 'mt1' });

            // Subscribe to the user-specific channel (using receiver_id from session or dynamically)
            var receiverId = '{{ Auth::user()->id }}'; // Make sure this is dynamically set to the logged-in user's ID
            var channel = pusher.subscribe('user-' + receiverId); // Listen for the receiver's user channel

            // Bind to the TicketCreated event
            channel.bind('TicketCreated', function(data) {
                console.log('New Ticket Created:', data);

                // Add the new ticket data dynamically to the page
                var ticket = data.ticket;
                var ticketHTML = `
                    <div class="bg-green-100 p-4 rounded-lg flex justify-between items-center">
                        <div>
                            <div><strong>BRT Code:</strong> ${ticket.brt_code}</div>
                            <div><strong>Amount:</strong> $${ticket.reserved_amount}</div>
                            <div><strong>Status:</strong> ${ticket.status}</div>
                            <div><strong>Created At:</strong> ${ticket.created_at}</div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                            <form method="POST" action="/tickets/${ticket.id}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                `;
                $('#ticket-display').prepend(ticketHTML); // Prepend new ticket at the top

                // Show notification to the user using Toastr
                toastr.success(`New ticket created with BRT Code: ${ticket.brt_code}`, 'New Ticket');

                // Check if browser supports notifications and if permission is granted
                if (Notification.permission === 'granted') {
                    // Create a new notification for the user
                    new Notification('New Ticket Created', {
                        body: `BRT Code: ${ticket.brt_code} - Amount: $${ticket.reserved_amount}`,
                        icon: '/path/to/icon.png', // Optional: specify an icon for the notification
                    });
                } else if (Notification.permission !== 'denied') {
                    // Request permission from the user to display notifications
                    Notification.requestPermission().then(function(permission) {
                        if (permission === 'granted') {
                            new Notification('New Ticket Created', {
                                body: `BRT Code: ${ticket.brt_code} - Amount: $${ticket.reserved_amount}`,
                                icon: '/path/to/icon.png', // Optional: specify an icon for the notification
                            });
                        }
                    });
                }
            });
        });
    </script>
</head>



<body class="bg-gray-100">
    <!-- Navbar Section -->
    @include('layouts.navbar') <!-- Adjust the path based on your navbar file location -->

    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Welcome Message Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                @if(Auth::user()->is_admin)
                    <div class="text-2xl font-semibold text-gray-800">
                        Welcome Back Admin!
                    </div>
                @else
                    <div class="text-2xl font-semibold text-gray-800">
                        Welcome Back {{ Auth::user()->name }}!
                    </div>
                @endif
            </div>

            <!-- Admin Dashboard Section -->
            @if(Auth::user()->is_admin)
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="text-2xl font-semibold text-gray-800">Admin Dashboard</div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-4">
                        <div class="bg-blue-100 p-6 rounded-lg">
                            <div class="text-lg font-semibold text-gray-700">Total BRTs Created</div>
                            <div class="text-3xl font-bold text-gray-900">150</div>
                        </div>
                        <div class="bg-yellow-100 p-6 rounded-lg">
                            <div class="text-lg font-semibold text-gray-700">Active BRTs</div>
                            <div class="text-3xl font-bold text-gray-900">85</div>
                        </div>
                        <div class="bg-green-100 p-6 rounded-lg">
                            <div class="text-lg font-semibold text-gray-700">Expired BRTs</div>
                            <div class="text-3xl font-bold text-gray-900">40</div>
                        </div>
                        <div class="bg-red-100 p-6 rounded-lg">
                            <div class="text-lg font-semibold text-gray-700">Pending BRTs</div>
                            <div class="text-3xl font-bold text-gray-900">25</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Content -->
            <!-- Add other sections like ticket creation, etc., here -->
        </div>
    </div>
</body>



</html>
