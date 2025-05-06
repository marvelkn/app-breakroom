<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Table - Breakroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen">
    <!-- Navbar -->
    <nav class="bg-black/50 backdrop-blur-md border-b border-gray-700 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo and Navigation -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('photos/breakroom.png') }}" alt="Breakroom Logo"
                            class="h-10 w-10 rounded-lg object-contain" />
                        <span
                            class="ml-3 text-xl font-bold bg-gradient-to-r from-yellow-400 to-yellow-600 text-transparent bg-clip-text">Breakroom</span>
                    </div>

                    <!-- Main Navigation -->
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition-colors">Home</a>
                        <a href="{{ route('user.tables') }}" class="hover:text-yellow-400 transition-colors">Tables</a>
                        <a href="{{ route('user.event.index') }}"
                            class="hover:text-yellow-400 transition-colors">Events</a>
                        <a href="{{ route('food-and-drinks.index') }}"
                            class="hover:text-yellow-400 transition-colors">Food & Drinks</a>
                        <a href="{{ route('products.index') }}"
                            class="hover:text-yellow-400 transition-colors">Products</a>
                    </div>
                </div>

                <!-- Profile and Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="text-gray-300 hover:text-yellow-400 relative p-1">
                        <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button class="flex items-center space-x-3 focus:outline-none" id="user-menu-button">
                            <div class="flex items-center">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : '/api/placeholder/40/40' }}"
                                    alt="Profile"
                                    class="h-8 w-8 rounded-full object-cover border-2 border-yellow-400" />
                                <div class="ml-3 hidden md:block text-left">
                                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">Member</p>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg border border-gray-700 z-50"
                            id="user-menu">
                            <div class="py-1">
                                <a href="{{ route('user.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-400">
                                    Profile Settings
                                </a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-400">
                                    Booking History
                                </a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-400">
                                    Loyalty Points
                                </a>
                                <div class="border-t border-gray-700 mt-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <button type="button" class="md:hidden bg-gray-800 p-2 rounded-md focus:outline-none"
                        id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="block text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md">Home</a>
                    <a href="{{ route('user.tables') }}"
                        class="block text-yellow-400 font-bold px-3 py-2 rounded-md">Tables</a>
                    <a href="#" class="block text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md">Events</a>
                    <a href="#"
                        class="block text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md">Products</a>
                    <a href="#" class="block text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md">Food &
                        Drinks</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16">
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="text-center mb-12 pt-8">
                <h2 class="text-3xl font-bold text-yellow-400 mb-4">Available Tables</h2>
                <p class="text-gray-400">Choose your perfect table for an amazing billiard experience</p>
            </div>

            <!-- Tables Grid -->
            @if (count($tables) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($tables as $table)
                        <div class="relative group">
                            <!-- Background Glow Effect -->
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-yellow-600/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -rotate-1">
                            </div>

                            <!-- Table Card -->
                            <div
                                class="relative bg-gray-800/80 backdrop-blur rounded-xl overflow-hidden shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
                                <!-- Table Image -->
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $table->image) }}"
                                        alt="Table {{ $table->number }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
                                    <!-- Status Badge -->
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-sm {{ strtolower($table->status) == 'open' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                            {{ $table->status }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Table Info -->
                                <div
                                    class="p-6 {{ strtolower($table->status_flag) == 'closed' ? 'opacity-50' : '' }}">
                                    <h3 class="text-xl font-bold text-yellow-400 mb-2">Table {{ $table->number }}</h3>
                                    <div class="space-y-2 text-gray-300">
                                        <p class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            Capacity: {{ $table->capacity }} people
                                        </p>
                                        <p class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Rp {{ number_format($table->price, 0, ',', '.') }}/hour
                                        </p>
                                    </div>

                                    @if (strtolower($table->status) == 'open')
                                        <div class="mt-6">
                                            <a href="{{ route('user.tables.bookView', ['table_id' => $table->id]) }}"
                                                class="block w-full text-center bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold py-3 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-300">
                                                Book Now
                                            </a>
                                        </div>
                                    @elseif (strtolower($table->status_flag) == 'closed')
                                        <div class="mt-6">
                                            <p class="text-center text-white font-bold py-3 rounded-lg">
                                                Closed
                                            </p>
                                        </div>
                                    @endif
                                    @if ($table->activeBooking)
                                        <x-session-timer :booking="$table->activeBooking" :table-id="$table->id" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-800/50 backdrop-blur rounded-xl">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <p class="text-xl text-gray-400">No tables available at the moment!</p>
                    <p class="text-gray-500 mt-2">Please check back later or contact our staff for assistance.</p>
                </div>
            @endif
        </main>
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

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } transform transition-transform duration-300 ease-in-out z-50`;
            toast.textContent = message;
            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.transform = 'translateY(-20px)';
            }, 100);

            // Animate out and remove
            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Add scroll behavior for nav background
        const nav = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                nav.classList.add('bg-black/80');
                nav.classList.remove('bg-black/50');
            } else {
                nav.classList.add('bg-black/50');
                nav.classList.remove('bg-black/80');
            }
        });

        // Add animation to cards on scroll
        const cards = document.querySelectorAll('.group');
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
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

        // Optional: Add active state for current page in navigation
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('text-yellow-400', 'font-bold');
                    link.classList.remove('text-gray-300');
                }
            });
        });

        function updateSessionTimers() {
            fetch('{{ route('user.tables.active-sessions') }}')
                .then(response => response.json())
                .then(data => {
                    data.forEach(session => {
                        const durationElement = document.getElementById(`duration-${session.id}`);
                        const priceElement = document.getElementById(`price-${session.id}`);

                        if (durationElement) {
                            durationElement.textContent = session.duration_display;
                        }
                        if (priceElement) {
                            priceElement.textContent = `Rp ${session.current_price.toLocaleString()}`;
                        }
                    });
                })
                .catch(error => console.error('Error updating session timers:', error));
        }

        setInterval(updateSessionTimers, 1000);
        updateSessionTimers();
        
        const ToastManager = {
            queue: [],
            isProcessing: false,
            activeToasts: new Set(),
            maxToasts: 3,

            createToast(message, type = 'success') {
                const getIcon = (type) => {
                    switch (type) {
                        case 'success':
                            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>`;
                        case 'error':
                            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>`;
                        case 'warning':
                            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>`;
                        case 'info':
                            return `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>`;
                    }
                };

                const getStyles = (type) => {
                    switch (type) {
                        case 'success':
                            return {
                                background: 'bg-green-900/80',
                                    border: 'border-green-700',
                                    text: 'text-green-100',
                                    icon: 'text-green-400'
                            };
                        case 'error':
                            return {
                                background: 'bg-red-900/80',
                                    border: 'border-red-700',
                                    text: 'text-red-100',
                                    icon: 'text-red-400'
                            };
                        case 'warning':
                            return {
                                background: 'bg-yellow-900/80',
                                    border: 'border-yellow-700',
                                    text: 'text-yellow-100',
                                    icon: 'text-yellow-400'
                            };
                        case 'info':
                            return {
                                background: 'bg-blue-900/80',
                                    border: 'border-blue-700',
                                    text: 'text-blue-100',
                                    icon: 'text-blue-400'
                            };
                    }
                };

                const styles = getStyles(type);
                const toast = document.createElement('div');

                toast.className = `fixed right-4 flex items-start p-4 mb-4 rounded-lg border backdrop-blur
            ${styles.background} ${styles.border} ${styles.text}
            transform translate-x-full transition-all duration-300 ease-in-out z-50
            max-w-sm sm:max-w-md`;

                toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${styles.icon}">
                ${getIcon(type)}
            </div>
            <div class="ml-3 text-sm font-medium break-words flex-1 max-h-32 overflow-y-auto">
                ${message}
            </div>
            <button type="button" class="ml-4 -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 
                inline-flex h-8 w-8 flex-shrink-0 ${styles.text} hover:bg-white/10" 
                onclick="ToastManager.removeToast(this.parentElement)">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        `;

                return toast;
            },

            positionToasts() {
                const spacing = 12;
                let currentTop = 16;
                const toasts = Array.from(this.activeToasts);

                toasts.forEach((toast) => {
                    toast.style.top = `${currentTop}px`;
                    const height = toast.offsetHeight;
                    currentTop += height + spacing;
                });
            },

            async removeToast(toast) {
                toast.style.transform = 'translate(500px, 0)';
                toast.style.opacity = '0';

                this.activeToasts.delete(toast);
                this.positionToasts();

                await new Promise(resolve => setTimeout(resolve, 300));
                if (toast.parentElement) {
                    document.body.removeChild(toast);
                }

                this.processQueue();
            },

            async showToast(message, type = 'success') {
                const toast = this.createToast(message, type);

                if (this.activeToasts.size >= this.maxToasts) {
                    this.queue.push({
                        toast,
                        message,
                        type
                    });
                    return;
                }

                document.body.appendChild(toast);
                this.activeToasts.add(toast);
                this.positionToasts();

                requestAnimationFrame(() => {
                    toast.style.transform = 'translate(0, 0)';
                });

                setTimeout(() => {
                    this.removeToast(toast);
                }, 5000);
            },

            async processQueue() {
                if (this.isProcessing || this.queue.length === 0 || this.activeToasts.size >= this.maxToasts) {
                    return;
                }

                this.isProcessing = true;
                const {
                    message,
                    type
                } = this.queue.shift();
                await this.showToast(message, type);
                this.isProcessing = false;
                this.processQueue();
            }
        };

        // Replace the existing showToast function with this one
        function showToast(message, type = 'success') {
            ToastManager.showToast(message, type);
        }

        // Check for session messages on page load
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if (session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif

            @if (session('warning'))
                showToast("{{ session('warning') }}", 'warning');
            @endif

            @if (session('info'))
                showToast("{{ session('info') }}", 'info');
            @endif
        });
    </script>
</body>

</html>
