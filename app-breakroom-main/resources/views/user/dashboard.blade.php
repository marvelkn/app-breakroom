<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breakroom - User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
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
                        <a href="{{route('user.event.index')}}" class="hover:text-yellow-400 transition-colors">Events</a>
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
    <div class="pt-24 pb-12 px-4 max-w-screen-xl mx-auto">
        <!-- Welcome Section -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-400">Ready for another game? Check out our latest offerings below.</p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div
                class="bg-gradient-to-br from-purple-900 to-purple-800 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                <h3 class="text-xl font-semibold mb-4">Quick Book</h3>
                <p class="text-gray-300 mb-4">Reserve your table now for instant gameplay</p>
                <a href="{{ route('user.tables') }}"
                    class="inline-block bg-purple-700 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors">Book
                    Table</a>
            </div>

            <div
                class="bg-gradient-to-br from-blue-900 to-blue-800 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                <h3 class="text-xl font-semibold mb-4">Upcoming Events</h3>
                <p class="text-gray-300 mb-4">Check out our tournaments and special events</p>
                <a href="{{route('user.event.index')}}"
                    class="inline-block bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">View
                    Events</a>
            </div>

            <div
                class="bg-gradient-to-br from-yellow-900 to-yellow-800 p-6 rounded-xl shadow-lg hover:scale-105 transition-transform">
                <h3 class="text-xl font-semibold mb-4">Loyalty Program</h3>
                <p class="text-gray-300 mb-4">View your points and available rewards</p>
                <a href="{{route('user.loyalty_program.index')}}"
                    class="inline-block bg-yellow-700 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors">Check
                    Rewards</a>
            </div>
        </div>

        <!-- Available Tables Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-yellow-400">Available Tables</h2>
                <a href="{{ route('user.tables') }}" class="text-yellow-400 hover:text-yellow-300">View All →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($tables as $table)
                    <div class="relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-xl opacity-50 group-hover:opacity-75 transition-opacity -rotate-1">
                        </div>
                        <div class="relative bg-gray-800 p-6 rounded-xl shadow-lg">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold">Table #{{ $table->id }}</h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm {{ strtolower($table->status) == 'open' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $table->status }}
                                </span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-gray-300">Capacity: {{ $table->capacity }} people</p>
                                <p class="text-gray-300">Price: Rp {{ number_format($table->price, 0, ',', '.') }}/hour</p>
                            </div>
                            @if(strtolower($table->status) == 'open')
                                <a href="{{ route('user.tables.bookView', $table->id) }}"
                                    class="mt-4 inline-block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded-lg transition-colors">
                                    Book Now
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Additional Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Food & Drinks -->
            <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Food & Drinks</h3>
                <img src="/api/placeholder/400/200" alt="Menu Preview"
                    class="w-full h-48 object-cover rounded-lg mb-4" />
                <p class="text-gray-300 mb-4">Hungry? Check out our menu with delicious options to fuel your game.</p>
                <a href="{{route('food-and-drinks.index')}}" class="text-yellow-400 hover:text-yellow-300">View Menu →</a>
            </div>

            <!-- Tournament Schedule -->
            <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-semibold mb-4">Upcoming Tournaments</h3>
                <img src="/api/placeholder/400/200" alt="Tournament Preview"
                    class="w-full h-48 object-cover rounded-lg mb-4" />
                <p class="text-gray-300 mb-4">Join our weekly tournaments and compete for amazing prizes!</p>
                <a href="{{route('user.event.index')}}" class="text-yellow-400 hover:text-yellow-300">View Schedule →</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black/30 backdrop-blur-md border-t border-gray-800 py-8">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">About Breakroom</h4>
                    <p class="text-gray-400">Your premium billiard destination for casual games and professional
                        tournaments.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-yellow-400">Book a Table</a></li>
                        <li><a href="#" class="hover:text-yellow-400">Events</a></li>
                        <li><a href="#" class="hover:text-yellow-400">Menu</a></li>
                        <li><a href="#" class="hover:text-yellow-400">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Opening Hours</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Monday - Friday: 10:00 - 23:00</li>
                        <li>Saturday: 09:00 - 00:00</li>
                        <li>Sunday: 09:00 - 22:00</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-yellow-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-yellow-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.384.667 2.126 1.384.788.667 1.459 1.077 1.384 2.126.72 2.889.923 3.76.063 1.277.072 1.667.072 4.947 0 8.74-.015 3.667-.072 4.947-.06 1.277-.261 2.148-.558 2.913-.306.788-.717 1.459-1.384 2.126-.667.667-1.337 1.077-2.126 1.384-.765.297-1.636.499-2.913.558C8.333 23.988 7.933 24 4 24s-4.333-.015-5.947-.072c-1.277-.06-2.148-.261-2.913-.558-.788-.306-1.459-.717-2.126-1.384-.667-.667-1.077-1.337-1.384-2.126-.297-.765-.499-1.636-.558-2.913-.047-1.28-.063-1.687-.063-4.947s.015-3.667.072-4.947c.06-1.277.261-2.148.558-2.913.306-.788.717-1.459 1.384-2.126C3.35.935 4.021.525 4.81.228 5.575-.069 6.446-.27 7.723-.33 9.003-.386 9.41-.4 12-.4c2.59 0 2.997.015 4.277.072 1.277.06 2.148.261 2.913.558.788.306 1.459.717 2.126 1.384.667.667 1.077 1.337 1.384 2.126.297.765.499 1.636.558 2.913.047 1.28.063 1.687.063 4.947s-.015 3.667-.072 4.947c-.06 1.277-.261 2.148-.558 2.913-.306.788-.717 1.459-1.384 2.126-.667.667-1.337 1.077-2.126 1.384-.765.297-1.636.499-2.913.558-1.28.047-1.687.063-4.947.063s-3.667-.015-4.947-.072c-1.277-.06-2.148-.261-2.913-.558-.788-.306-1.459-.717-2.126-1.384-.667-.667-1.077-1.337-1.384-2.126-.297-.765-.499-1.636-.558-2.913-.047-1.28-.063-1.687-.063-4.947s.015-3.667.072-4.947c.06-1.277.261-2.148.558-2.913.306-.788.717-1.459 1.384-2.126C3.35.935 4.021.525 4.81.228 5.575-.069 6.446-.27 7.723-.33 9.003-.386 9.41-.4 12-.4zm0 3.6c-2.504 0-4.533 2.029-4.533 4.533s2.029 4.533 4.533 4.533 4.533-2.029 4.533-4.533S14.504 3.2 12 3.2zm0 7.467c-1.626 0-2.934-1.308-2.934-2.934S10.374 4.8 12 4.8s2.934 1.308 2.934 2.934-1.308 2.934-2.934 2.934zm5.067-7.467c0 .667-.533 1.2-1.2 1.2s-1.2-.533-1.2-1.2.533-1.2 1.2-1.2 1.2.533 1.2 1.2z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; 2024 Breakroom. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
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

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href !== "#") {
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation to cards on scroll
        const cards = document.querySelectorAll('.hover\\:scale-105');
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease-out';
            observer.observe(card);
        });

        // Toast notifications
        function showNotification(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } transform transition-transform duration-300 ease-in-out`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.transform = 'translateY(-100px)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Example usage of notifications (you can trigger these based on your app's events)
        // showNotification('Table booked successfully!');
        // showNotification('Error booking table', 'error');
    </script>
</body>

</html>