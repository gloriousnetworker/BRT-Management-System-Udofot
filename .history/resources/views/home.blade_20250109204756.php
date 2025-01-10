@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Admin Dashboard Section -->
        @if(Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Admin Dashboard</div>
            <div id="admin-dashboard" class="grid grid-cols-2 gap-6 mt-4">
                <!-- Add admin-specific stats dynamically if needed -->
                <div class="bg-blue-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Total BRTs Created</div>
                    <div class="text-3xl font-bold text-gray-900">150</div> <!-- Replace with dynamic data -->
                </div>
                <div class="bg-green-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Active BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">85</div> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
        @endif

        <!-- Welcome Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Welcome, ' . Auth::user()->name) }}</div>
            <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
        </div>

        <!-- Admin or User Tickets Section -->
        @if(Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">All Tickets</div>
            <div id="admin-tickets" class="space-y-4 mt-4">
                <!-- Tickets will be dynamically loaded here -->
            </div>
        </div>
        @else
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Your Tickets</div>
            <div id="user-tickets" class="space-y-4 mt-4">
                <!-- Tickets will be dynamically loaded here -->
            </div>
        </div>
        @endif

        <!-- Create Ticket Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Create a New Ticket') }}</div>
            <form id="ticket-form" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="brt_code" class="block text-sm font-medium text-gray-700">BRT Code</label>
                    <input type="text" name="brt_code" id="brt_code" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="reserved_amount" class="block text-sm font-medium text-gray-700">Reserved Amount</label>
                    <input type="number" name="reserved_amount" id="reserved_amount" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                @if(Auth::user()->is_admin)
                <div class="mb-4">
                    <label for="receiver_id" class="block text-sm font-medium text-gray-700">Assign to User</label>
                    <select name="receiver_id" id="receiver_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        @foreach(\App\Models\User::where('is_admin', false)->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Create Ticket</button>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const isAdmin = {{ Auth::user()->is_admin ? 'true' : 'false' }};
    const ticketsUrl = "/tickets";

    const loadTickets = async () => {
        const response = await fetch(ticketsUrl);
        const tickets = await response.json();
        const container = isAdmin ? document.getElementById('admin-tickets') : document.getElementById('user-tickets');
        container.innerHTML = tickets.map(ticket => `
            <div class="p-4 border rounded-lg">
                <div><strong>BRT Code:</strong> ${ticket.brt_code}</div>
                <div><strong>Reserved Amount:</strong> ${ticket.reserved_amount}</div>
                <div><strong>Status:</strong> ${ticket.status}</div>
                <button onclick="updateTicket(${ticket.id})" class="bg-yellow-500 text-white px-4 py-2 mt-2">Update</button>
                <button onclick="deleteTicket(${ticket.id})" class="bg-red-500 text-white px-4 py-2 mt-2">Delete</button>
            </div>
        `).join('');
    };

    const updateTicket = async (id) => {
        const newStatus = prompt("Enter new status (active, expired, pending):");
        if (newStatus) {
            await fetch(`${ticketsUrl}/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ status: newStatus }),
            });
            loadTickets();
        }
    };

    const deleteTicket = async (id) => {
        if (confirm("Are you sure you want to delete this ticket?")) {
            await fetch(`${ticketsUrl}/${id}`, { method: 'DELETE' });
            loadTickets();
        }
    };

    document.addEventListener('DOMContentLoaded', loadTickets);
</script>
@endpush
