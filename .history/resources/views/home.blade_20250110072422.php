@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Admin Dashboard Section -->
        @if(Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Admin Dashboard</div>
            <div class="grid grid-cols-2 gap-6 mt-4">
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

        <!-- Welcome Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">
                {{ __('Welcome, ' . Auth::user()->name) }}
            </div>
            <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
        </div>

        <!-- Ticket Creation Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Create a New Ticket') }}</div>
            <form id="ticket-form" class="mt-4" method="POST" action="{{ route('tickets.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="brt_code" class="block text-sm font-medium text-gray-700">BRT Code</label>
                    <input type="text" name="brt_code" id="brt_code"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>
                <div class="mb-4">
                    <label for="reserved_amount" class="block text-sm font-medium text-gray-700">Reserved Amount</label>
                    <input type="number" name="reserved_amount" id="reserved_amount"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                @if(Auth::user()->is_admin)
                <div class="mb-4">
                    <label for="receiver_id" class="block text-sm font-medium text-gray-700">Select User to Send Ticket</label>
                    <select name="receiver_id" id="receiver_id"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        @foreach(\App\Models\User::where('is_admin', false)->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <input type="hidden" name="receiver_id" value="4">
                @endif
                <button type="submit" id="create-ticket-btn"
                    class="w-full bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    Create Ticket
                </button>
            </form>
        </div>

        <!-- Ticket Display Section -->
        @if($tickets->isNotEmpty())
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Your Tickets</div>
            <div class="mt-4 space-y-4">
                @foreach($tickets as $ticket)
                <div class="bg-green-100 p-4 rounded-lg flex justify-between items-center">
                    <div>
                        <div><strong>BRT Code:</strong> {{ $ticket->brt_code }}</div>
                        <div><strong>Amount:</strong> ${{ $ticket->reserved_amount }}</div>
                        <div><strong>Status:</strong> {{ ucfirst($ticket->status) }}</div>
                        <div><strong>Created At:</strong> {{ $ticket->created_at->format('d-m-Y H:i') }}</div>
                    </div>
                    <div class="flex space-x-2">
                        <!-- Update Button -->
                        <button onclick="document.getElementById('edit-ticket-{{ $ticket->id }}').classList.remove('hidden');"
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </button>

                        <!-- Delete Form -->
                        <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Update Form Modal -->
                <div id="edit-ticket-{{ $ticket->id }}" class="hidden bg-white shadow-lg rounded-lg p-6">
                    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="brt_code_{{ $ticket->id }}" class="block text-sm font-medium text-gray-700">BRT Code</label>
                            <input type="text" name="brt_code" id="brt_code_{{ $ticket->id }}" value="{{ $ticket->brt_code }} "
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="reserved_amount_{{ $ticket->id }}" class="block text-sm font-medium text-gray-700">Reserved Amount</label>
                            <input type="number" name="reserved_amount" id="reserved_amount_{{ $ticket->id }}" value="{{ $ticket->reserved_amount }} "
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="status_{{ $ticket->id }}" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status_{{ $ticket->id }} "
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                required>
                                <option value="active" {{ $ticket->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="expired" {{ $ticket->status === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-green-500 text-white p-3 rounded-md hover:bg-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                            Update Ticket
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    // Enable Pusher logging
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
    });

    // Subscribe to the tickets channel
    var channel = pusher.subscribe('tickets');
    channel.bind('TicketCreated', function(data) {
        alert(`New ticket created: ${data.brt_code}`);
    });

    channel.bind('pusher:subscription_succeeded', function() {
        console.log("Successfully subscribed to the tickets channel");
    });

    channel.bind('pusher:subscription_error', function(status) {
        console.error('Error subscribing to channel', status);
    });
</script>
@endpush
