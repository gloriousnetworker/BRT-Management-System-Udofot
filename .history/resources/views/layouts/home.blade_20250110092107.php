<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home - Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS styles */
            /* ! tailwindcss v3.4.1 */
            /* The inline Tailwind CSS can be kept or extracted to a separate CSS file */
            *,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}...
        </style>
    @endif
</head>
<body class="bg-gray-100">

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
            <!-- The rest of the content remains unchanged -->
            <!-- Include other sections such as Ticket Creation and Ticket Display -->
            ...

        </div>
    </div>

    @stack('scripts')
</body>
</html>
