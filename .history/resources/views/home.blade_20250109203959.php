@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        @if(Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Tickets Sent by Users</h2>
            @if($tickets->isEmpty())
                <p class="text-gray-600">No tickets found.</p>
            @else
                <ul class="mt-4">
                    @foreach($tickets as $ticket)
                        <li class="bg-gray-100 p-4 rounded-lg mb-2">
                            <strong>BRT Code:</strong> {{ $ticket->brt_code }} <br>
                            <strong>Amount:</strong> ${{ $ticket->reserved_amount }} <br>
                            <strong>Status:</strong> {{ ucfirst($ticket->status) }} <br>
                            <strong>Sent By:</strong> {{ $ticket->sender->name }} <br>
                            <strong>Created At:</strong> {{ $ticket->created_at->format('d-m-Y H:i') }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        @else
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Your Tickets</h2>
            @if($tickets->isEmpty())
                <p class="text-gray-600">No tickets found.</p>
            @else
                <ul class="mt-4">
                    @foreach($tickets as $ticket)
                        <li class="bg-gray-100 p-4 rounded-lg mb-2">
                            <strong>BRT Code:</strong> {{ $ticket->brt_code }} <br>
                            <strong>Amount:</strong> ${{ $ticket->reserved_amount }} <br>
                            <strong>Status:</strong> {{ ucfirst($ticket->status) }} <br>
                            <strong>Created At:</strong> {{ $ticket->created_at->format('d-m-Y H:i') }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection
