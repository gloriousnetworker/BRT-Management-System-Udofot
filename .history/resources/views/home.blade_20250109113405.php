@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Check if the user is an Admin -->
        @if(Auth::user()->is_admin)
        <!-- Admin Dashboard Section -->
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

        <!-- Welcome User Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Welcome, ' . Auth::user()->name) }}</div>
            <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
        </div>

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

        <!-- Ticket Management Section for Admins -->
        @if(Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Manage Tickets') }}</div>
            <div class="mt-4">
                <ul id="ticket-list" class="space-y-4">
                    <!-- Dummy Data for Tickets -->
                    <li class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                        <div>
                            <div class="text-lg font-semibold">BRT Code: 001</div>
                            <div class="text-sm text-gray-600">Reserved Amount: 100 BLUME COINS</div>
                            <div class="text-sm text-gray-600">Status: Active</div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-yellow-500 text-white px-3 py-2 rounded-md">Update</button>
                            <button class="bg-red-500 text-white px-3 py-2 rounded-md">Delete</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        @endif

        <!-- Notification Section -->
        <div id="notification-container" class="space-y-4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="text-xl font-semibold text-gray-800">{{ __('Real-Time Notifications') }}</div>
                <div class="mt-4" id="notifications">
                    <!-- Notifications will be appended here -->
                    <div class="bg-green-100 text-green-800 p-3 rounded-md mb-2">
                        BRT ONE 20 BLUME COIN RECEIVED
                        <span class="text-sm text-gray-600 ml-2">3 minutes ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Admin ticket actions will go here (Update/Delete logic to be added)
</script>
@endpush
