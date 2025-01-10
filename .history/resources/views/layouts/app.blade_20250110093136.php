<!-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-gray-100">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        <button id="navbar-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="navbar" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                            <svg class="block h-6 w-6" x-show="isOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
                        <a href="{{ url('/') }}" class="text-2xl font-semibold text-gray-900">{{ config('app.name', 'Laravel') }}</a>
                    </div>

                    <div class="flex items-center space-x-4 hidden sm:block">
                        <ul class="flex space-x-4">
                            @guest
                                @if (Route::has('login'))
                                    <li><a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">{{ __('Login') }}</a></li>
                                @endif
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600">{{ __('Register') }}</a></li>
                                @endif
                            @else
                                <li class="relative">
                                    <button id="navbarDropdown" class="text-gray-700 hover:text-indigo-600" aria-haspopup="true">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden">
                                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu
            <div id="navbar" class="sm:hidden hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block text-gray-700 hover:text-indigo-600 py-2 px-3 rounded-md">{{ __('Login') }}</a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block text-gray-700 hover:text-indigo-600 py-2 px-3 rounded-md">{{ __('Register') }}</a>
                        @endif
                    @else
                        <a href="{{ route('logout') }}" class="block text-gray-700 hover:text-indigo-600 py-2 px-3 rounded-md"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div> -->

    <!-- Bootstrap JS (Optional) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script> --> -->

    <!-- Laravel Echo and Pusher -->
    <!-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('fd7cc9ca454f87cc9526', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('tickets');
        channel.bind('TicketCreated', function(data) {
            alert(JSON.stringify(data));
        });

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        Echo.private('notifications')
            .listen('.ticket-notification', (event) => {
                alert(event.message);
            });

        window.Echo.channel('tickets')
            .listen('.TicketCreated', (e) => {
                alert(`New ticket created: ${e.ticket.brt_code}`);
            })
            .listen('.TicketUpdated', (e) => {
                alert(`Ticket updated: ${e.ticket.brt_code}`);
            })
            .listen('.TicketDeleted', (e) => {
                alert(`Ticket deleted: ${e.ticket.brt_code}`);
            });
    </script>

    <script>
        // Toggle Navbar for Mobile
        const toggleButton = document.getElementById('navbar-toggle');
        const navbar = document.getElementById('navbar');

        toggleButton.addEventListener('click', () => {
            navbar.classList.toggle('hidden');
        });
    </script> -->

</body>
</html>
