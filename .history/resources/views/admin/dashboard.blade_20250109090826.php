@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-semibold">Admin Dashboard</h2>

    <div class="mt-4">
        <h3 class="text-lg font-semibold">Tickets</h3>
        <ul>
            @foreach($tickets as $ticket)
                <li>{{ $ticket->title }} - {{ $ticket->status }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4">
        <h3 class="text-lg font-semibold">Notifications</h3>
        <ul>
            @foreach(auth()->user()->notifications as $notification)
                <li>{{ $notification->data['message'] }} - {{ $notification->created_at }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
