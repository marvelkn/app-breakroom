<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Breakroom | @yield('title', 'Breakroom Gading Serpong')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Keep Bootstrap for compatibility during transition -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-yellow-400 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('photos/breakroom.png') }}" alt="Breakroom Logo" class="h-8 w-auto mr-2">
                        <a href="{{route('admin.index')}}" class="text-white text-xl font-bold hover:text-yellow-200 transition duration-150">Breakroom</a>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="{{ route('admin.index')}}"
                            class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150 {{ request()->routeIs('admin.index') ? 'bg-blue-700' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('admin.table.index')}}"
                            class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150 {{ request()->routeIs('admin.table.*') ? 'bg-blue-700' : '' }}">
                            Tables
                        </a>
                        <a href="{{ route('admin.event.adminIndex')}}"
                            class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150 {{ request()->routeIs('admin.event.*') ? 'bg-blue-700' : '' }}">
                            Events
                        </a>
                        <a href="{{ route('admin.product.adminIndex')}}"
                            class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150 {{ request()->routeIs('admin.product.*') ? 'bg-blue-700' : '' }}">
                            Products
                        </a>
                        <a href="{{ route('admin.food.adminIndex')}}"
                            class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150 {{ request()->routeIs('admin.food.*') ? 'bg-blue-700' : '' }}">
                            Food & Drinks
                        </a>
                        <a href="#"
                            class="text-white hover:bg-blue-500 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                            Contact
                        </a>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative ml-3">
                            <button type="button"
                                class="flex text-sm bg-blue-500 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-600 focus:ring-white transition duration-150"
                                id="user-menu-button"
                                onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')">
                                @if(auth()->user()->photo)
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center text-blue-800 font-semibold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </button>

                            <!-- Dropdown menu -->
                            <div class="hidden origin-top-right z-[4] absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none transform transition-all duration-150"
                                id="profile-dropdown">
                                <a href="{{ route('admin.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                    Profile
                                </a>
                                <a href="{{ route('admin.users.adminIndex') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                    Manage Users
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-yellow-200 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition duration-150"
                        aria-controls="mobile-menu" aria-expanded="false"
                        onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('admin.index')}}"
                    class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->routeIs('admin.index') ? 'bg-blue-700' : '' }}">
                    Home
                </a>
                <a href="{{ route('admin.table.index')}}"
                    class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->routeIs('admin.table.*') ? 'bg-blue-700' : '' }}">
                    Tables
                </a>
                <a href="{{ route('admin.event.adminIndex')}}"
                    class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->routeIs('admin.event.*') ? 'bg-blue-700' : '' }}">
                    Events
                </a>
                <a href="{{ route('admin.product.adminIndex')}}"
                    class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->routeIs('admin.product.*') ? 'bg-blue-700' : '' }}">
                    Products
                </a>
                <a href="{{ route('admin.food.adminIndex')}}"
                    class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150 {{ request()->routeIs('admin.food.*') ? 'bg-blue-700' : '' }}">
                    Food & Drinks
                </a>
                <a href="#"
                    class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150">
                    Contact
                </a>

                <!-- Mobile Profile Section -->
                <div class="border-t border-blue-700 pt-4 mt-4">
                    <div class="flex items-center px-3">
                        @if(auth()->user()->photo)
                            <img class="h-8 w-8 rounded-full object-cover"
                                src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile">
                        @else
                            <div class="h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center text-blue-800 font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="ml-3 text-white font-medium">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('admin.profile') }}"
                            class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150">
                            Profile
                        </a>
                        <a href="{{ route('admin.users.adminIndex') }}"
                            class="text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150">
                            Manage Users
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left text-white hover:bg-blue-500 block px-3 py-2 rounded-md text-base font-medium transition duration-150">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Close the dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profile-dropdown');
        const button = document.getElementById('user-menu-button');
        if (!dropdown.contains(e.target) && !button.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
    </script>
    @stack('scripts')
</body>

</html>