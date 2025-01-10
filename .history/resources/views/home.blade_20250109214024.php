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

<!-- Ticket Display Section -->
@if(Auth::user()->is_admin)
<div class="bg-white shadow-lg rounded-lg p-6">
    <div class="text-2xl font-semibold text-gray-800">Tickets Sent by Users</div>
    @if($tickets->isEmpty())
        <p class="text-gray-600 mt-4">No tickets found.</p>
    @else
        <div class="mt-4 space-y-4">
            @foreach($tickets as $ticket)
            <div class="bg-gray-100 p-4 rounded-lg">
                <div><strong>BRT Code:</strong> {{ $ticket->brt_code }}</div>
                <div><strong>Amount:</strong> ${{ $ticket->reserved_amount }}</div>
                <div><strong>Status:</strong> {{ ucfirst($ticket->status) }}</div>
                <div><strong>Sent By:</strong> {{ $ticket->sender->name }}</div>
                <div><strong>Created At:</strong> {{ $ticket->created_at->format('d-m-Y H:i') }}</div>

                <!-- Update Button -->
                <button onclick="document.getElementById('update-ticket-{{ $ticket->id }}').style.display='block'"
                    class="mt-3 bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Update
                </button>

                <!-- Delete Form -->
                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="mt-3 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Delete
                    </button>
                </form>

                <!-- Update Modal -->
                <div id="update-ticket-{{ $ticket->id }}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="bg-white p-6 rounded shadow-lg max-w-md w-full">
                            <h3 class="text-lg font-bold mb-4">Update Ticket</h3>
                            <form method="POST" action="{{ route('tickets.update', $ticket->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="brt_code" class="block text-sm font-medium text-gray-700">BRT Code</label>
                                    <input type="text" name="brt_code" value="{{ $ticket->brt_code }}"
                                        class="mt-1 block w-full px-4 py-2 border rounded">
                                </div>
                                <div class="mb-4">
                                    <label for="reserved_amount" class="block text-sm font-medium text-gray-700">Reserved Amount</label>
                                    <input type="number" name="reserved_amount" value="{{ $ticket->reserved_amount }}"
                                        class="mt-1 block w-full px-4 py-2 border rounded">
                                </div>
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="mt-1 block w-full px-4 py-2 border rounded">
                                        <option value="active" @if($ticket->status === 'active') selected @endif>Active</option>
                                        <option value="expired" @if($ticket->status === 'expired') selected @endif>Expired</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Changes</button>
                                <button type="button" onclick="document.getElementById('update-ticket-{{ $ticket->id }}').style.display='none'"
                                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endif

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush
