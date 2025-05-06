@extends('admin.layout.app')

@section('title', 'Admin Table Bookings Page')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-900 animate-slide-in">Bookings</h2>
            <div class="space-x-0 sm:space-x-4 flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back to Dashboard
                </a>
            </div>
        </div>

        {{-- <!-- Tables Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <table class="table">
        <thead>
            <tr>
                <th>Table</th>
                <th>User</th>
                <th>Email</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
                <th>Duration</th>
                <th>Original Price</th>
                <th>Loyalty Discount</th>
                <th>Voucher Discount</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach ($bookings as $booking)     
        <tr>
            <td>{{ $booking->table->number ?? 'Unknown Table' }}</td>
            <td>{{ $booking->user->name ?? 'Unknown User' }}</td>
            <td>{{ $booking->user->email ?? 'Unknown User' }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('d, M, Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
            <td>{{ floor($booking->duration / 60) }} Hour(s) {{$booking->duration % 60}} Minutes</td>
            <td>Rp. {{ number_format($booking->original_price, 2) }}</td>
            <td>Rp. {{ number_format($booking->loyalty_discount, 2) }}</td>
            <td>Rp. {{ number_format($booking->voucher_discount, 2) }}</td>
            <td>Rp. {{ number_format($booking->final_price, 2) }}</td>
            <td>
                <!-- Finish -->
                <a href="{{route('admin.booking.finish', $booking->id)}}"class="btn btn-primary m-2">Finish</a>
                <a href="{{route('admin.booking.cancel', $booking->id)}}"class="btn btn-danger m-2">Cancel</a>
            </td>
        </tr>
        @endforeach
    </table>
    </div> --}}

        <!-- Active Sessions Section -->
        <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-yellow-400 mb-4">Active Sessions</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-300 border-b border-gray-700">
                            <th class="px-4 py-3">Booking Number</th>
                            <th class="px-4 py-3">Table</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Started At</th>
                            <th class="px-4 py-3">Duration</th>
                            {{-- <th class="px-4 py-3">Original Price</th> --}}
                            {{-- <th class="px-4 py-3">Discounts</th> --}}
                            <th class="px-4 py-3">Current Price</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings->where('status', 'active') as $booking)
                            <tr class="border-b border-gray-700" id="booking-{{ $booking->id }}">
                                <td class="px-4 py-3">Table #{{ $booking->id }}</td>
                                <td class="px-4 py-3">Table #{{ $booking->table->number }}</td>
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="font-medium">{{ $booking->user->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $booking->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-sm {{ $booking->booking_type === '3-hour-package' ? 'bg-blue-900 text-blue-300' : 'bg-purple-900 text-purple-300' }}">
                                        {{ $booking->booking_type === '3-hour-package' ? '3-Hour Package' : 'Open Duration' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($booking->started_at)->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <span class="duration-timer" id="duration-timer">Calculating...</span>
                                </td>
                                {{-- <td class="px-4 py-3">
                                    <span class="original-price"
                                        id="original-price">Calculating...</span>
                                </td> --}}
                                {{-- <td class="px-4 py-3">
                                    <div class="text-sm">
                                        @if ($booking->loyalty_discount)
                                            <p class="text-green-400">Loyalty: -Rp
                                                {{ number_format($booking->loyalty_discount, 0, ',', '.') }}</p>
                                        @endif
                                        @if ($booking->voucher_discount)
                                            <p class="text-green-400">Voucher: -Rp
                                                {{ number_format($booking->voucher_discount, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </td> --}}
                                <td class="px-4 py-3">
                                    <span class="current-price font-bold" id="current-price">Calculating...</span>
                                </td>
                                <td class="px-4 py-3">
                                    <button onclick="endSession({{ $booking->id }})"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                        End Session
                                    </button>
                                    <button onclick="cancelBooking({{ $booking->id }}, 'active')"
                                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Bookings Section -->
        <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6">
            <h3 class="text-xl font-semibold text-yellow-400 mb-4">Pending Bookings</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-300 border-b border-gray-700">
                            <th class="px-4 py-3">Booking Number</th>
                            <th class="px-4 py-3">Table</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Booking Time</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings->where('status', 'pending') as $booking)
                            <tr class="border-b border-gray-700" id="booking-{{ $booking->id }}">
                                <td class="px-4 py-3">Table #{{ $booking->id }}</td>
                                <td class="px-4 py-3">Table #{{ $booking->table->number }}</td>
                                <td class="px-4 py-3">{{ $booking->user->name }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-sm 
                                {{ $booking->booking_type === '3-hour-package' ? 'bg-blue-900 text-blue-300' : 'bg-purple-900 text-purple-300' }}">
                                        {{ $booking->booking_type === '3-hour-package' ? '3-Hour Package' : 'Open Duration' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ Carbon\Carbon::parse($booking->booking_time)->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">{{ $booking->price_display }}</td>
                                <td class="px-4 py-3">
                                    <button onclick="startSession({{ $booking->id }})"
                                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        Start Session
                                    </button>
                                    <button onclick="cancelBooking({{ $booking->id }}, 'pending')"
                                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                        Cancel
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Completed Sessions --}}
        <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 mt-8">
            <h3 class="text-xl font-semibold text-yellow-400 mb-4">Completed Bookings</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-300 border-b border-gray-700">
                            <th class="px-4 py-3">Booking Number</th>
                            <th class="px-4 py-3">Table</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Start Time</th>
                            <th class="px-4 py-3">End Time</th>
                            <th class="px-4 py-3">Duration</th>
                            <th class="px-4 py-3">Original Price</th>
                            <th class="px-4 py-3">Discounts</th>
                            <th class="px-4 py-3">Final Price</th>
                            <th class="px-4 py-3">Points Earned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings->where('status', 'completed') as $booking)
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-3">Table #{{ $booking->id }}</td>
                                <td class="px-4 py-3">Table #{{ $booking->table->number }}</td>
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="font-medium">{{ $booking->user->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $booking->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-sm {{ $booking->booking_type === '3-hour-package' ? 'bg-blue-900 text-blue-300' : 'bg-purple-900 text-purple-300' }}">
                                        {{ $booking->booking_type === '3-hour-package' ? '3-Hour Package' : 'Open Duration' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($booking->started_at)->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3">{{ floor($booking->final_duration / 60) }}h
                                    {{ $booking->final_duration % 60 }}m</td>
                                <td class="px-4 py-3">Rp {{ number_format($booking->original_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        @if ($booking->loyalty_discount)
                                            <p class="text-green-400">Loyalty: -Rp
                                                {{ number_format($booking->loyalty_discount, 0, ',', '.') }}</p>
                                        @endif
                                        @if ($booking->voucher_discount)
                                            <p class="text-green-400">Voucher: -Rp
                                                {{ number_format($booking->voucher_discount, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-bold">Rp {{ number_format($booking->final_price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3">{{ floor($booking->final_price / 10000) }} points</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Cancelled Sessions --}}
        <div class="bg-gray-800/50 backdrop-blur rounded-lg p-6 mt-8">
            <h3 class="text-xl font-semibold text-yellow-400 mb-4">Cancelled Bookings</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-300 border-b border-gray-700">
                            <th class="px-4 py-3">Booking Number</th>
                            <th class="px-4 py-3">Table</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Original Booking Time</th>
                            <th class="px-4 py-3">Started At</th>
                            <th class="px-4 py-3">Cancelled At</th>
                            <th class="px-4 py-3">Duration Before Cancel</th>
                            <th class="px-4 py-3">Original Price</th>
                            <th class="px-4 py-3">Applied Discounts</th>
                            <th class="px-4 py-3">Final Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings->where('status', 'cancelled') as $booking)
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-3">Table #{{ $booking->id }}</td>
                                <td class="px-4 py-3">Table #{{ $booking->table->number }}</td>
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="font-medium">{{ $booking->user->name }}</p>
                                        <p class="text-sm text-gray-400">{{ $booking->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-sm {{ $booking->booking_type === '3-hour-package' ? 'bg-blue-900 text-blue-300' : 'bg-purple-900 text-purple-300' }}">
                                        {{ $booking->booking_type === '3-hour-package' ? '3-Hour Package' : 'Open Duration' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ Carbon\Carbon::parse($booking->booking_time)->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if ($booking->started_at)
                                        {{ Carbon\Carbon::parse($booking->started_at)->format('d M Y H:i') }}
                                    @else
                                        <span class="text-gray-400">Not started</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $booking->updated_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if ($booking->started_at)
                                        {{ floor($booking->final_duration / 60) }}h {{ $booking->final_duration % 60 }}m
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($booking->original_price)
                                        Rp {{ number_format($booking->original_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        @if ($booking->loyalty_discount)
                                            <p class="text-green-400">Loyalty: -Rp
                                                {{ number_format($booking->loyalty_discount, 0, ',', '.') }}</p>
                                        @endif
                                        @if ($booking->voucher_discount)
                                            <p class="text-green-400">Voucher: -Rp
                                                {{ number_format($booking->voucher_discount, 0, ',', '.') }}</p>
                                        @endif
                                        @if (!$booking->loyalty_discount && !$booking->voucher_discount)
                                            <span class="text-gray-400">No discounts applied</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($booking->final_price)
                                        <span class="font-bold">Rp
                                            {{ number_format($booking->final_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes statusChange {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .status-change {
            animation: statusChange 0.3s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status change animation
            const statusSelects = document.querySelectorAll('select[name="status"]');
            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const card = this.closest('.bg-white');
                    const statusBadge = card.querySelector('.rounded-full');
                    statusBadge.classList.add('status-change');
                    setTimeout(() => {
                        statusBadge.classList.remove('status-change');
                    }, 300);
                });
            });
        });

        async function cancelBooking(bookingId, type) {
            const confirmed = await createConfirmModal('Are you sure you want to cancel this booking?');
            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/bookings/${bookingId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Booking cancelled successfully', 'success');

                    // Remove or update the row
                    const bookingRow = document.getElementById(`booking-${bookingId}`);
                    if (bookingRow) {
                        // Add fade-out animation
                        bookingRow.style.transition = 'opacity 0.3s ease-out';
                        bookingRow.style.opacity = '0';

                        // Remove after animation
                        setTimeout(() => {
                            bookingRow.remove();
                        }, 300);
                    }

                    if (type === 'active') {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                } else {
                    showToast(data.message || 'Error cancelling booking', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error cancelling booking', 'error');
            }
        }

        function showToast(message, type = 'success') {
            ToastManager.showToast(message, type);
        }

        const ToastManager = {
            queue: [],
            isProcessing: false,
            activeToasts: new Set(),
            maxToasts: 3, // Maximum number of visible toasts

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
                                background: 'bg-green-50',
                                    border: 'border-green-400',
                                    text: 'text-green-800',
                                    icon: 'text-green-400'
                            };
                        case 'error':
                            return {
                                background: 'bg-red-50',
                                    border: 'border-red-400',
                                    text: 'text-red-800',
                                    icon: 'text-red-400'
                            };
                        case 'warning':
                            return {
                                background: 'bg-yellow-50',
                                    border: 'border-yellow-400',
                                    text: 'text-yellow-800',
                                    icon: 'text-yellow-400'
                            };
                        case 'info':
                            return {
                                background: 'bg-blue-50',
                                    border: 'border-blue-400',
                                    text: 'text-blue-800',
                                    icon: 'text-blue-400'
                            };
                    }
                };

                const styles = getStyles(type);
                const toast = document.createElement('div');

                toast.className = `fixed right-4 flex items-start p-4 mb-4 rounded-lg border 
            ${styles.background} ${styles.border} ${styles.text} shadow-lg 
            transform translate-x-full transition-all duration-300 ease-in-out z-50 
            max-w-sm sm:max-w-md`;

                toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${styles.icon}">
                ${getIcon(type)}
            </div>
            <div class="ml-3 text-sm font-medium break-words flex-1 max-h-32 overflow-y-auto">
                ${message}
            </div>
            <button type="button" class="ml-4 -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 
                inline-flex h-8 w-8 flex-shrink-0 ${styles.text} hover:bg-gray-100" 
                onclick="ToastManager.removeToast(this.parentElement)">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        `;

                const style = document.createElement('style');
                style.textContent = `
            .toast-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
            .toast-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .toast-scrollbar::-webkit-scrollbar-thumb {
                background: #CBD5E0;
                border-radius: 2px;
            }
        `;
                toast.appendChild(style);

                // Add scrollbar class to message container
                toast.querySelector('.max-h-32').classList.add('toast-scrollbar');

                return toast;
            },

            positionToasts() {
                const spacing = 12; // Space between toasts
                let currentTop = 16; // Initial spacing from top
                const toasts = Array.from(this.activeToasts);

                toasts.forEach((toast) => {
                    toast.style.top = `${currentTop}px`;
                    // Get actual height after rendering
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

                // Animate in
                requestAnimationFrame(() => {
                    toast.style.transform = 'translate(0, 0)';
                });

                // Auto remove after 5 seconds
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


        function createConfirmModal(message, onConfirm) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
            <p class="text-gray-800 mb-6">${message}</p>
            <div class="flex justify-end space-x-3">
                <button class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-800 cancel-btn">
                    Cancel
                </button>
                <button class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-600 text-white confirm-btn">
                    Confirm
                </button>
            </div>
        </div>
    `;

            document.body.appendChild(modal);

            return new Promise((resolve) => {
                modal.querySelector('.confirm-btn').addEventListener('click', () => {
                    document.body.removeChild(modal);
                    resolve(true);
                });

                modal.querySelector('.cancel-btn').addEventListener('click', () => {
                    document.body.removeChild(modal);
                    resolve(false);
                });
            });
        }

        async function startSession(bookingId) {
            const confirmed = await createConfirmModal('Are you sure you want to start this session?');
            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/bookings/${bookingId}/start`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showToast('Session started successfully', 'success');
                    setTimeout(() => location.reload(), 1500); // Give time for toast to show
                } else {
                    showToast(data.message || 'Error starting session', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error starting session', 'error');
            }
        }

        async function endSession(bookingId) {
            const confirmed = await createConfirmModal('Are you sure you want to end this session?');
            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/bookings/${bookingId}/end`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    showToast('Session ended successfully', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Error ending session', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error ending session', 'error');
            }
        }

        function fetchUpdatedPrices() {
            fetch('{{ route('admin.bookings.prices') }}')
                .then(response => response.json())
                .then(data => {
                    data.forEach(booking => {
                        const bookingRow = document.querySelector(`#booking-${booking.id}`);
                        if (bookingRow) {
                            const currPrice = bookingRow.querySelector(`#current-price`);
                            if (currPrice) {
                                currPrice.textContent = booking.price_display;
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching prices:', error));
        }

        function fetchUpdatedDurations() {
            fetch('{{ route('admin.bookings.durations') }}')
                .then(response => response.json())
                .then(data => {
                    data.forEach(booking => {
                        const bookingRow = document.querySelector(`#booking-${booking.id}`);
                        if (bookingRow) {
                            const durationTimer = bookingRow.querySelector(`#duration-timer`);
                            if (durationTimer) {
                                durationTimer.textContent = booking.duration_display;
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching durations:', error));
        }

        setInterval(fetchUpdatedDurations, 1000);
        setInterval(fetchUpdatedPrices, 30000);
        fetchUpdatedDurations();
        fetchUpdatedPrices();
    </script>
@endsection
