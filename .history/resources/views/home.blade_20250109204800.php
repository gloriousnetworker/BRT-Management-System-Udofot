@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Admin Dashboard Section -->
        @if(Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Admin Dashboard</div>
            <div class="grid grid-cols-2 gap-6 mt-4">
                <!-- Statistics Cards -->
                <div class="bg-blue-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Total BRTs Created</div>
                    <div class="text-3xl font-bold text-gray-900">150</div> <!-- Replace with dynamic data -->
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Active BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">85</div> <!-- Replace with dynamic data -->
                </div>
                <div class="bg-green-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Expired BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">40</div> <!-- Replace with dynamic data -->
                </div>
                <div class="bg-red-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Pending BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">25</div> <!-- Replace with dynamic data -->
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
                <!-- BRT Code Field -->
                <div class="mb-4">
                    <label for="brt_code" class="block text-sm font-medium text-gray-700">BRT Code</label>
                    <input type="text" name="brt_code" id="brt_code"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                <!-- Reserved Amount Field -->
                <div class="mb-4">
                    <label for="reserved_amount" class="block text-sm font-medium text-gray-700">Reserved Amount</label>
                    <input type="number" name="reserved_amount" id="reserved_amount"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                </div>

                <!-- Status Dropdown -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>

                <!-- Receiver Field (Admin only) -->
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
                <input type="hidden" name="receiver_id" value="4"> <!-- Default Admin Receiver -->
                @endif

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-500 text-white p-3 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    Create Ticket
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush
