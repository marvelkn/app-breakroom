<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Breakroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">
    <!-- Navbar -->
    <nav class="bg-black/50 backdrop-blur-md border-b border-gray-700 fixed w-full z-50">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('photos/breakroom.png') }}" alt="Breakroom Logo"
                            class="h-12 w-12 rounded-lg object-contain" />
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 text-transparent bg-clip-text">Breakroom</span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition-colors">Home</a>
                        <a href="{{ route('user.tables') }}" class="hover:text-yellow-400 transition-colors">Tables</a>
                        <a href="{{route('user.event.index')}}" class="text-yellow-400">Events</a>
                        <a href="{{route('food-and-drinks.index')}}" class="hover:text-yellow-400 transition-colors">Food & Drinks</a>
                        <a href="{{route('products.index')}}" class="hover:text-yellow-400 transition-colors">Products</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Menu -->
                    <div class="relative">
                        <button type="button" class="flex items-center space-x-3 focus:outline-none"
                            id="user-menu-button">
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User"
                                class="h-10 w-10 rounded-full border-2 border-yellow-400" />
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg border border-gray-700"
                            id="user-menu">
                            <div class="py-1">
                                <a href="{{ route('user.profile') }}"
                                    class="block px-4 py-2 hover:bg-gray-700">Profile</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-700">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-700 text-red-400">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-32 pb-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-yellow-400 mb-4">Upcoming Events</h2>
                <p class="text-gray-400 text-lg">Join us for exciting tournaments, competitions, and special events</p>
            </div>

            @if($events->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 bg-gray-800/50 backdrop-blur rounded-xl">
                <svg class="w-16 h-16 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-xl text-gray-400 mb-2">No Upcoming Events</p>
                <p class="text-gray-500">Check back later for exciting new events!</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="group relative">
                    <!-- Background Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-yellow-600/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -rotate-1">
                    </div>

                    <!-- Event Card -->
                    <div class="relative bg-gray-800/80 backdrop-blur rounded-xl overflow-hidden shadow-xl transform transition-all duration-300 group-hover:scale-[1.02]">
                        <!-- Event Image -->
                        <div class="relative h-56 overflow-hidden">
                            @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" 
                                alt="{{ $event->name }}" 
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                            @else
                            <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-400">No image available</span>
                            </div>
                            @endif
                            
                            <!-- Event Status Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full text-sm bg-green-900/80 text-green-300">
                                    Registration Open
                                </span>
                            </div>
                        </div>

                        <!-- Event Info -->
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-yellow-400 mb-3">{{ $event->name }}</h3>
                            
                            <div class="space-y-2 mb-4 text-gray-300">
                                <p class="flex items-center">
                                    <i class="fas fa-calendar-alt w-5 text-yellow-400"></i>
                                    <span class="ml-2">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-clock w-5 text-yellow-400"></i>
                                    <span class="ml-2">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-map-marker-alt w-5 text-yellow-400"></i>
                                    <span class="ml-2">{{ $event->location }}</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-users w-5 text-yellow-400"></i>
                                    <span class="ml-2">{{ $event->max_participants }} participants max</span>
                                </p>
                            </div>

                            <p class="text-gray-400 mb-6 line-clamp-2">{{ $event->description }}</p>

                            <div class="flex justify-between items-center">
                                <a href="{{ route('user.event.details', $event->id) }}" 
                                    class="inline-flex items-center text-yellow-400 hover:text-yellow-300">
                                    View Details
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <button class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold py-2 px-6 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                    Register Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <script>
        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>