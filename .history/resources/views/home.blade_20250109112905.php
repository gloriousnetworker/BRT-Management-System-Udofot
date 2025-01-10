@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Check if the user is an Admin -->
        @if(Auth::user()->is_admin)
        <!-- Admin Dashboard Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-2xl font-semibold text-gray-800">Admin Dashboard</div>

            <!-- Overview Metrics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-4">
                <div class="bg-blue-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Total BRTs Created</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $totalBRTs }}</div>
                </div>
                <div class="bg-yellow-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Active BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $activeBRTs }}</div>
                </div>
                <div class="bg-green-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Expired BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $expiredBRTs }}</div>
                </div>
                <div class="bg-red-100 p-6 rounded-lg">
                    <div class="text-lg font-semibold text-gray-700">Pending BRTs</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $pendingBRTs }}</div>
                </div>
            </div>

            <!-- Analytics Section -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-800">Analytics</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="text-lg font-semibold text-gray-700">BRTs Created Today</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $brtsToday }}</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="text-lg font-semibold text-gray-700">BRTs Created This Week</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $brtsThisWeek }}</div>
                    </div>
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="text-lg font-semibold text-gray-700">BRTs Created This Month</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $brtsThisMonth }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Reserved Amount -->
            <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700">Total Reserved Amount</h3>
                <div class="text-3xl font-bold text-gray-900">{{ $totalReservedAmount }} BLUME COINS</div>
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
    </div>
</div>
@endsection