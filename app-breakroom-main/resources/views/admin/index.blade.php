@extends('admin.layout.app')

@section('title', 'Admin Dashboard')

@push('styles')
    {{-- Chart.js CDN --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Animation Classes */
        .hover-lift {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .slide-in {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideIn 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(45, 55, 72, 0.2);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(45, 55, 72, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(45, 55, 72, 0);
            }
        }

        /* Notification Styles */
        .notification-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            width: 300px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #EF4444;
            color: white;
            border-radius: 9999px;
            padding: 2px 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 shadow-lg mb-6">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-slate-100">Welcome Back, {{ auth()->user()->name }}!</h1>
                        <p class="text-emerald-400 mt-1 font-medium">{{ now()->format('l, F j, Y') }}</p>
                    </div>
                </div>
                <!-- Notification Bell -->
                <div class="relative">
                    <button id="notificationButton" class="p-2 text-white hover:text-emerald-400 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="notification-badge">3</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <!-- Quick Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
                $quickActions = [
                    [
                        'title' => 'Tables',
                        'desc' => 'Manage all billiard tables',
                        'color' => 'emerald',
                        'route' => 'admin.table.index',
                        'icon' => '🎱',
                        'stat' => $allTables->count() . ' Active'
                    ],
                    [
                        'title' => 'Events',
                        'desc' => 'Organize and manage events',
                        'color' => 'blue',
                        'route' => 'admin.event.adminIndex',
                        'icon' => '🎉',
                        'stat' => $allEvents->count() . ' Upcoming'
                    ],
                    [
                        'title' => 'Products',
                        'desc' => 'Manage product inventory',
                        'color' => 'indigo',
                        'route' => 'admin.product.adminIndex',
                        'icon' => '🛍️',
                        'stat' => $allProducts->count() . ' Items'
                    ],
                    [
                        'title' => 'Food & Drinks',
                        'desc' => 'Manage menu items',
                        'color' => 'purple',
                        'route' => 'admin.food.adminIndex',
                        'icon' => '🍽️',
                        'stat' => $allFoods->count() . ' Items'
                    ],
                    [
                        'title' => 'Users',
                        'desc' => 'Manage Users',
                        'color' => 'red',
                        'route' => 'admin.users.adminIndex',
                        'icon' => '👤',
                        'stat' => $allUsers->count() . ' Users'
                    ],
                    [
                        'title' => 'Bookings',
                        'desc' => 'Manage Bookings',
                        'color' => 'yellow',
                        'route' => 'admin.booking.index',
                        'icon' => '📑',
                        'stat' => $bookings->count() . ' Bookings'
                    ],
                    [
                        'title' => 'Vouchers',
                        'desc' => 'Manage Vouchers',
                        'color' => 'cyan',
                        'route' => 'admin.voucher.adminIndex',
                        'icon' => '🎟',
                        'stat' => $vouchers->count() . ' Vouchers'
                    ]
                ];
            @endphp

            @foreach($quickActions as $index => $action)
                <div class="bg-white hover:bg-gray-50 rounded-xl shadow-md overflow-hidden hover-lift fade-in-up"
                    style="animation-delay: {{$index * 150}}ms"
                    data-animate>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-2xl">{{$action['icon']}}</span>
                            <span class="text-{{$action['color']}}-600 text-sm font-semibold">{{$action['stat']}}</span>
                        </div>
                        <h3 class="font-bold text-xl text-gray-800 mb-2">{{$action['title']}}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{$action['desc']}}</p>
                        <a href="{{route($action['route'])}}"
                            class="inline-flex items-center text-{{$action['color']}}-600 hover:text-{{$action['color']}}-700 font-medium group">
                            Manage
                            <svg class="w-4 h-4 ml-2 transition-transform duration-200 transform group-hover:translate-x-1" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Overview Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tables Overview -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift slide-in">
                <div class="border-b border-gray-100 bg-gray-50 p-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Active Tables</h2>
                        <a href="{{route('admin.table.index')}}"
                            class="text-emerald-600 hover:text-emerald-700 flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($tables->take(3) as $table)
                        <div
                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="bg-emerald-100 rounded-full p-2">
                                    <span class="text-lg text-emerald-600">🎱</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Table {{$table->number}}</span>
                                    <p class="text-sm text-gray-500">{{$table->capacity}} seats</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium
                                    {{$table->status == 'Open' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}}">
                                {{$table->status}}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Events Overview -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift slide-in">
                <div class="border-b border-gray-100 bg-gray-50 p-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Upcoming Events</h2>
                        <a href="{{route('admin.event.adminIndex')}}"
                            class="text-blue-600 hover:text-blue-700 flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($events->take(3) as $event)
                        <div
                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 rounded-full p-2">
                                    <span class="text-lg text-blue-600">🎉</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">{{$event->name}}</span>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                                {{$event->status}}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6 slide-in" data-animate>
    <!-- Revenue Chart -->
    <div class="bg-white rounded-xl shadow-md p-4">
        <h3 class="text-lg font-semibold mb-4">Revenue Overview</h3>
        <div class="h-64"> <!-- Fixed height container -->
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    
    <!-- Bookings Chart -->
    <div class="bg-white rounded-xl shadow-md p-4">
        <h3 class="text-lg font-semibold mb-4">Bookings Overview</h3>
        <div class="h-64"> <!-- Fixed height container -->
            <canvas id="bookingsChart"></canvas>
        </div>
    </div>
</div>

        <!-- Additional Overviews -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Products Overview -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift slide-in">
                <div class="border-b border-gray-100 bg-gray-50 p-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Latest Products</h2>
                        <a href="{{route('admin.product.adminIndex')}}"
                            class="text-indigo-600 hover:text-indigo-700 flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($products->take(3) as $product)
                        <div
                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="bg-indigo-100 rounded-full p-2">
                                    <span class="text-lg text-indigo-600">🛍️</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">{{$product->name}}</span>
                                    <p class="text-sm text-gray-500">Rp. {{number_format($product->price)}}</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium
                                    {{$product->status == 'Available' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}}">
                                {{$product->status}}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Food & Drinks Overview -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift slide-in">
                <div class="border-b border-gray-100 bg-gray-50 p-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Menu Items</h2>
                        <a href="{{route('admin.food.adminIndex')}}"
                            class="text-purple-600 hover:text-purple-700 flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($foods->take(3) as $food)
                        <div
                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="bg-purple-100 rounded-full p-2">
                                    <span class="text-lg text-purple-600">🍽️</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">{{$food->name}}</span>
                                    <p class="text-sm text-gray-500">{{$food->category}} · Rp.
                                        {{number_format($food->price)}}</p>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium
                                    {{$food->status == 'Available' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}}">
                                {{$food->status}}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize intersection observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '50px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) translateX(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all animatable elements
            document.querySelectorAll('[data-animate]').forEach((el) => {
                el.style.opacity = '0';
                el.style.transform = el.classList.contains('fade-in-up')
                    ? 'translateY(20px)'
                    : 'translateX(-20px)';
                observer.observe(el);
            });

            // Initialize notifications
            const notificationButton = document.getElementById('notificationButton');
            const notificationDropdown = document.getElementById('notificationDropdown');

            notificationButton.addEventListener('click', () => {
                notificationDropdown.classList.toggle('show');
            });

            document.addEventListener('click', (event) => {
                if (!notificationButton.contains(event.target) && 
                    !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });

            // Initialize charts
            initializeCharts();
        });

        function initializeCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: [12000, 19000, 15000, 22000, 20000, 25000],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Revenue Overview'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Bookings Chart
            const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
            new Chart(bookingsCtx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Daily Bookings',
                        data: [15, 22, 18, 25, 30, 35, 28],
                        backgroundColor: '#6366F1'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Weekly Bookings'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        }

        // Function to add new notifications
        function addNotification(title, message, time) {
            const container = document.getElementById('notificationContainer');
            const notificationHTML = `
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-800">${title}</p>
                    <p class="text-xs text-gray-500">${message}</p>
                    <span class="text-xs text-gray-400">${time}</span>
                </div>
            `;
            container.insertAdjacentHTML('afterbegin', notificationHTML);
            
            // Update badge count
            const badge = document.querySelector('.notification-badge');
            const currentCount = parseInt(badge.textContent);
            badge.textContent = currentCount + 1;
        }

        // Example usage of addNotification:
        // setTimeout(() => {
        //     addNotification('New Booking', 'Table 5 booked for 3 hours', 'Just now');
        // }, 5000);

        // Add hover animations to cards
        document.querySelectorAll('.hover-lift').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.1)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '';
            });
        });
    </script>
@endpush

@endsection