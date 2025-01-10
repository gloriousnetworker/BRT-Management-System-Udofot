@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Check if the user is an Admin -->
        @if(Auth::user()->is_admin)
        <!-- Admin Tickets Sent by Users Section -->
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
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @else
        <!-- User Tickets Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Your Tickets</div>
            @if($tickets->isEmpty())
                <p class="text-gray-600 mt-4">No tickets found.</p>
            @else
                <div class="mt-4 space-y-4">
                    @foreach($tickets as $ticket)
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <div><strong>BRT Code:</strong> {{ $ticket->brt_code }}</div>
                        <div><strong>Amount:</strong> ${{ $ticket->reserved_amount }}</div>
                        <div><strong>Status:</strong> {{ ucfirst($ticket->status) }}</div>
                        <div><strong>Created At:</strong> {{ $ticket->created_at->format('d-m-Y H:i') }}</div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection
