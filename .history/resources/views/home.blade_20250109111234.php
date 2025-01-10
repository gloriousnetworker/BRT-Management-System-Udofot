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
                <!-- Analytics cards -->
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

        <!-- Admin Ticket Management Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <div class="text-xl font-semibold text-gray-800">Tickets</div>
            <table class="table-auto w-full mt-4 border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">BRT Code</th>
                        <th class="border px-4 py-2">Reserved Amount</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example ticket rows -->
                    <tr>
                        <td class="border px-4 py-2">ABC123</td>
                        <td class="border px-4 py-2">50 BLUME COINS</td>
                        <td class="border px-4 py-2 text-green-600">Active</td>
                        <td class="border px-4 py-2">
                            <button class="text-blue-600 hover:underline">Update</button>
                            <button class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                    <!-- Repeat for more tickets -->
                </tbody>
            </table>
        </div>
        @endif

        <!-- Welcome User Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-xl font-semibold text-gray-800">{{ __('Welcome, ' . Auth::user()->name) }}</div>
            <p class="text-gray-600 mt-2">{{ __('You are logged in!') }}</p>
        </div>

        <!-- Ticket List Section for Users -->
        @if(!Auth::user()->is_admin)
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
            <div class="text-xl font-semibold text-gray-800">Your Tickets</div>
            <table class="table-auto w-full mt-4 border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">BRT Code</th>
                        <th class="border px-4 py-2">Reserved Amount</th>
                        <th class="border px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example ticket rows -->
                    <tr>
                        <td class="border px-4 py-2">ABC123</td>
                        <td class="border px-4 py-2">50 BLUME COINS</td>
                        <td class="border px-4 py-2 text-green-600">Active</td>
                    </tr>
                    <!-- Repeat for more tickets -->
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
