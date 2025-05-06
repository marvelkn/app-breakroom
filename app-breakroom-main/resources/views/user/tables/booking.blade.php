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
                    <div class="hidden md:flex ml-10 space-x-6">
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md transition-colors duration-200">Home</a>
                        <a href="{{ route('user.tables') }}"
                            class="text-yellow-400 font-bold px-3 py-2 rounded-md">Tables</a>
                        <a href="#"
                            class="text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md transition-colors duration-200">Events</a>
                        <a href="#"
                            class="text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md transition-colors duration-200">Products</a>
                        <a href="#"
                            class="text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md transition-colors duration-200">Food
                            & Drinks</a>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button class="flex items-center space-x-3 focus:outline-none" id="user-menu-button">
                        <div class="flex items-center">
                            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : '/api/placeholder/40/40' }}"
                                alt="Profile" class="h-8 w-8 rounded-full object-cover border-2 border-yellow-400" />
                            <div class="ml-3 hidden md:block text-left">
                                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400">Member</p>
                            </div>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-lg shadow-lg border border-gray-700"
                        id="user-menu">
                        <div class="py-1">
                            <a href="{{ route('user.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-400">Profile
                                Settings</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-400">Booking
                                History</a>
                            <div class="border-t border-gray-700 mt-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700">Sign
                                    out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-20 pb-12 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Booking Form Card -->
            <div class="relative">
                <!-- Decorative Elements -->
                <div
                    class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-xl transform rotate-1">
                </div>
                <div
                    class="absolute inset-0 bg-gradient-to-l from-purple-400/10 to-purple-600/10 rounded-xl transform -rotate-1">
                </div>

                <!-- Main Form Container -->
                <div class="relative bg-gray-800/80 backdrop-blur rounded-xl shadow-xl p-8">
                    <!-- Form Header -->
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-yellow-400 mb-2">Book Your Table</h2>
                        <p class="text-gray-400">Table #{{ $table->number }} - Capacity: {{ $table->capacity }} people
                        </p>
                    </div>

                    <!-- Booking Form -->
                    <form method="POST" action="{{ route('user.tables.book', ['table_id' => $table->id]) }}"
                        class="space-y-6">
                        @csrf
                        <input type="hidden" id="table_id" value="{{ $table->id }}">
                        <input type="hidden" id="datetime" name="datetime">
                        <!-- Current Table Info -->
                        <div class="bg-gray-900/50 rounded-lg p-4 mb-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-400">Price per hour</p>
                                    <p class="text-lg font-bold text-yellow-400">Rp
                                        {{ number_format($table->price, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Status</p>
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-semibold {{ strtolower($table->status) == 'open' ? 'bg-green-900/80 text-green-300' : 'bg-red-900/80 text-red-300' }}">
                                        {{ $table->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if (strtolower($table->status) == 'open')

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Select Date</label>
                                <div class="flex space-x-2 overflow-x-auto pb-2">
                                    @foreach (range(0, 6) as $dayOffset)
                                        @php
                                            $date = now()->addDays($dayOffset);
                                            $isWeekend = $date->isWeekend();
                                            $hours = $isWeekend ? '11 AM - 1 AM' : '10 AM - 12 AM';
                                        @endphp
                                        <button type="button" data-date="{{ $date->format('Y-m-d') }}"
                                            data-weekend="{{ $isWeekend ? 'true' : 'false' }}"
                                            class="date-selector flex-shrink-0 flex flex-col items-center p-4 rounded-lg border-2 transition-all
                                                {{ $dayOffset === 0 ? 'border-yellow-400 bg-yellow-400/10' : 'border-gray-700 hover:border-yellow-400/50' }}">
                                            <span class="text-sm text-gray-400">{{ $date->format('D') }}</span>
                                            <span class="text-lg font-bold text-white">{{ $date->format('d') }}</span>
                                            <span class="text-xs text-gray-400 mt-1">{{ $hours }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Select Time</label>
                                <div class="grid grid-cols-4 gap-2" id="timeSlots">
                                    <!-- Time slots will be populated by JavaScript -->
                                </div>
                                <p class="text-sm text-gray-400" id="operatingHoursInfo"></p>
                            </div>

                            <!-- Duration Selector -->
                            <div class="space-y-2">
                                <label for="duration" class="block text-sm font-medium text-gray-300">Select
                                    Duration</label>
                                <select name="duration" id="duration"
                                    class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    required>
                                    <option value="" disabled selected>Choose your duration</option>
                                    <option value="180" {{ old('duration') == '180' ? 'selected' : '' }}>Package -
                                        3
                                        Hours</option>
                                    <option value="open" {{ old('duration') == 'open' ? 'selected' : '' }}>Open
                                        Duration</option>
                                </select>
                            </div>

                            <!-- Loyalty Benefits & Discounts -->
                            <div class="bg-gray-900/50 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="text-sm text-gray-400">Your Loyalty Tier</span>
                                        <h3 class="text-lg font-bold text-yellow-400">{{ $loyaltyTier->name }}</h3>
                                    </div>
                                    @if ($loyaltyTier->table_discount_percentage > 0)
                                        <span class="bg-green-900/80 text-green-300 px-3 py-1 rounded-full text-sm">
                                            {{ $loyaltyTier->table_discount_percentage }}% Tier Discount
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Voucher Selection -->
                            @if ($applicableVouchers->isNotEmpty())
                                <div class="space-y-2">
                                    <label for="voucher_id" class="block text-sm font-medium text-gray-300">Apply
                                        Voucher (Optional)</label>
                                    <select name="voucher_id" id="voucher_id"
                                        class="w-full bg-gray-900/50 border border-gray-700 text-white rounded-lg p-3 focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                        <option value="">No voucher</option>
                                        @foreach ($applicableVouchers as $userVoucher)
                                            <option value="{{ $userVoucher->id }}"
                                                data-type="{{ $userVoucher->voucher->discount_type }}"
                                                data-value="{{ $userVoucher->voucher->discount_value }}"
                                                data-min="{{ $userVoucher->voucher->min_purchase }}"
                                                data-max="{{ $userVoucher->voucher->max_discount }}">
                                                {{ $userVoucher->voucher->name }}
                                                (@if ($userVoucher->voucher->discount_type === 'percentage')
                                                    {{ $userVoucher->voucher->discount_value }}%
                                                @else
                                                    Rp {{ number_format($userVoucher->voucher->discount_value) }}
                                                @endif off)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div id="price-estimation" class="bg-gray-900/50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-300 mb-2">Price Details</h4>
                                <div id="price-info-container">
                                    <p class="text-xl font-bold text-yellow-400" id="initial-message">Please select a
                                        duration first!</p>
                                    <p class="text-xs text-gray-400 mt-1 hidden" id="initial-info"></p>
                                </div>

                                <div id="price-details-container" class="space-y-2 hidden">
                                    <!-- Original Price -->
                                    <div class="flex justify-between items-center">
                                        <span>Original Price</span>
                                        <span id="original-price" class="text-gray-400"></span>
                                    </div>

                                    <!-- Loyalty Discount -->
                                    @if ($loyaltyTier->table_discount_percentage > 0)
                                        <div class="flex justify-between items-center text-green-400">
                                            <span>Loyalty Tier Discount
                                                ({{ $loyaltyTier->table_discount_percentage }}%)</span>
                                            <span id="loyalty-discount">-Rp 0</span>
                                        </div>
                                    @endif

                                    <!-- Voucher Discount (Hidden by default) -->
                                    <div id="voucher-discount-row"
                                        class="flex justify-between items-center text-green-400 hidden">
                                        <span id="voucher-label">Voucher Discount</span>
                                        <span id="voucher-discount">-Rp 0</span>
                                    </div>

                                    <!-- Final Price -->
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-700">
                                        <span>Final Price</span>
                                        <span id="final-price" class="text-xl font-bold text-yellow-400">Rp 0</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1" id="price-info"></p>
                            </div>

                        @elseif (strtolower($table->status) == 'closed')
                            <!-- fill this section with appropirate and necessary section if a table is closed -->
                        @endif
                        <!-- Action Buttons -->
                        <div class="flex space-x-4 pt-4">
                            <a href="{{ route('user.tables') }}"
                                class="flex-1 px-6 py-3 bg-gray-700 text-white rounded-lg text-center hover:bg-gray-600 transition-colors duration-200">
                                {{ strtolower($table->status) == 'open' ? 'Cancel' : 'View Available Tables' }}
                            </a>
                            @if (strtolower($table->status) == 'open')
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                    Confirm Booking
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 bg-gray-800/50 backdrop-blur rounded-lg p-6">
                <h3 class="text-lg font-semibold text-yellow-400 mb-4">Booking Information</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Bookings must be made at least 1 hour in advance</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Please arrive 15 minutes before your booking time</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>Payment must be made upon arrival</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const durationSelect = document.getElementById('duration');
        const priceEstimation = document.getElementById('price-estimation');
        const estimatedPriceDisplay = document.getElementById('estimated-price');
        const estimatedPriceDisplayInfo = document.getElementById('estimated-price-info');
        const pricePerHour = {{ $table->price }};

        document.addEventListener('DOMContentLoaded', function() {
            estimatedPriceDisplayInfo.classList.add('hidden');
            estimatedPriceDisplay.textContent = `Please select a duration first!`;
        });

        const priceInfoContainer = document.getElementById('price-info-container');
        const priceDetailsContainer = document.getElementById('price-details-container');
        const initialMessage = document.getElementById('initial-message');
        const initialInfo = document.getElementById('initial-info');

        durationSelect.addEventListener('change', function() {
            if (this.value === '') {
                // Show initial message, hide price details
                priceInfoContainer.classList.remove('hidden');
                priceDetailsContainer.classList.add('hidden');
                initialMessage.textContent = 'Please select a duration first!';
                initialInfo.classList.add('hidden');
            } else if (this.value === 'open') {
                // Show open duration message, hide price details
                priceInfoContainer.classList.remove('hidden');
                priceDetailsContainer.classList.add('hidden');
                initialMessage.textContent =
                    'Price will be calculated based on actual duration at the end of session!';
                initialInfo.textContent = `Base rate: Rp ${numberFormat(pricePerHour)} per hour`;
                initialInfo.classList.remove('hidden');
            } else {
                // Show price details, hide initial message
                priceInfoContainer.classList.add('hidden');
                priceDetailsContainer.classList.remove('hidden');
                calculatePrice();
            }
        });

        // Update form validation
        const bookingForm = document.querySelector('form');
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!document.getElementById('datetime').value) {
                showToast('Please select a time slot', 'error');
                return;
            }

            if (!durationSelect.value) {
                showToast('Please select a duration', 'error');
                return;
            }

            const selectedDateTime = new Date(document.getElementById('datetime').value);
            const now = new Date();
            const minBookingTime = new Date(now.getTime() + (60 * 60 * 1000));

            if (selectedDateTime < minBookingTime) {
                showToast('Booking must be made at least 1 hour in advance', 'error');
                return;
            }

            // Show loading state and submit
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-black inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Processing...
    `;

            this.submit();
        });

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

        // Helper function for number formatting
        function numberFormat(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

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

        document.addEventListener('DOMContentLoaded', () => {
            // Date selection
            document.querySelectorAll('.date-selector').forEach(button => {
                button.addEventListener('click', () => {
                    // Update selection UI
                    document.querySelectorAll('.date-selector').forEach(btn => {
                        btn.classList.remove('border-yellow-400', 'bg-yellow-400/10');
                    });
                    button.classList.add('border-yellow-400', 'bg-yellow-400/10');

                    // Generate time slots
                    generateTimeSlots(
                        button.dataset.date,
                        button.dataset.weekend === 'true'
                    );
                });
            });

            // Initialize with first date
            const firstDate = document.querySelector('.date-selector');
            if (firstDate) {
                generateTimeSlots(
                    firstDate.dataset.date,
                    firstDate.dataset.weekend === 'true'
                );
            }
        });

        function generateTimeSlots(date, isWeekend) {
            const timeSlotsContainer = document.getElementById('timeSlots');
            const operatingHoursInfo = document.getElementById('operatingHoursInfo');
            const table_id = document.getElementById('table_id').value;

            timeSlotsContainer.innerHTML =
                '<div class="col-span-4 text-center py-4 text-gray-400">Loading available times...</div>';

            fetch(`/booking/slots/${table_id}/${date}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message);
                    }

                    timeSlotsContainer.innerHTML = '';
                    const bookedSlots = data.slots;
                    const now = new Date();
                    const today = now.toISOString().split('T')[0];
                    const oneHourFromNow = new Date(now.getTime() + (60 * 60 * 1000));

                    const openingTime = isWeekend ? 11 : 10;
                    const closingHour = isWeekend ? 25 : 24;

                    for (let hour = openingTime; hour < closingHour; hour++) {
                        for (let minute of [0, 30]) {
                            const displayHour = hour >= 24 ? hour - 24 : hour;
                            const timeString =
                                `${String(displayHour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;

                            // Create slot time for comparison
                            const slotTime = new Date(`${date}T${timeString}`);

                            // Check if slot is within one hour from now
                            const isPast = date === today && slotTime < oneHourFromNow;
                            const isBooked = bookedSlots.includes(timeString);

                            const button = document.createElement('button');
                            button.type = 'button';
                            button.className = `time-slot p-2 rounded-lg text-center transition-all ${
                        isBooked || isPast 
                            ? 'bg-gray-800 text-gray-500 cursor-not-allowed' 
                            : 'bg-gray-700 hover:bg-yellow-400/20 text-white'
                    }`;
                            button.disabled = isBooked || isPast;
                            button.dataset.time = timeString;
                            button.textContent = formatTime(timeString);

                            if (isPast && !isBooked) {
                                button.title = "Must book at least 1 hour in advance";
                            }

                            if (!isBooked && !isPast) {
                                button.addEventListener('click', () => selectTimeSlot(button));
                            }

                            timeSlotsContainer.appendChild(button);
                        }
                    }

                    operatingHoursInfo.textContent =
                        `Operating hours: ${formatTime(`${openingTime}:00`)} - ${isWeekend ? '1:00 AM' : '12:00 AM'} next day`;

                    // If all slots are unavailable for today, show a message
                    if (date === today && !document.querySelector('.time-slot:not([disabled])')) {
                        showToast('No available slots for today. Please try selecting another date.', 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    timeSlotsContainer.innerHTML =
                        '<div class="col-span-4 text-center py-4 text-red-400">Error loading time slots. Please try again.</div>';
                    showToast('Error loading time slots. Please try again.', 'error');
                });
        }

        // Add this helper function for better time formatting
        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        function selectTimeSlot(button) {
            if (button.disabled) {
                showToast('This time slot is not available', 'error');
                return;
            }

            document.querySelectorAll('.time-slot').forEach(btn => {
                btn.classList.remove('bg-yellow-400', 'text-black', 'font-bold');
            });

            button.classList.add('bg-yellow-400', 'text-black', 'font-bold');

            const selectedDate = document.querySelector('.date-selector.border-yellow-400').dataset.date;
            const selectedTime = button.dataset.time;
            document.getElementById('datetime').value = `${selectedDate}T${selectedTime}:00`;

            showToast(`Selected time: ${formatTime(selectedTime)}`, 'info');

            if (typeof calculatePrice === 'function') {
                calculatePrice();
            }
        }

        const voucherSelect = document.getElementById('voucher_id');
        const loyaltyDiscountPercentage = {{ $loyaltyTier->table_discount_percentage ?? 0 }};
        const originalPriceDisplay = document.getElementById('original-price');
        const loyaltyDiscountDisplay = document.getElementById('loyalty-discount');
        const voucherDiscountRow = document.getElementById('voucher-discount-row');
        const voucherDiscountDisplay = document.getElementById('voucher-discount');
        const finalPriceDisplay = document.getElementById('final-price');

        function calculatePrice() {
            try {
                let originalPrice = 0;
                let finalPrice = 0;
                let voucherDiscount = 0; // Initialize voucherDiscount

                // Calculate base price
                const minutes = parseInt(durationSelect.value) || 0;
                if (!minutes && durationSelect.value !== 'open') {
                    showToast('Please select a valid duration', 'warning');
                    return;
                }

                if (durationSelect.value === 'open') {
                    // For open duration, just show the base rate
                    priceInfoContainer.classList.remove('hidden');
                    priceDetailsContainer.classList.add('hidden');
                    initialMessage.textContent = 'Price will be calculated based on actual duration at the end of session!';
                    initialInfo.textContent = `Base rate: Rp ${numberFormat(pricePerHour)} per hour`;
                    initialInfo.classList.remove('hidden');
                    return;
                }

                // For 3-hour package
                originalPrice = (pricePerHour * minutes) / 60;
                originalPriceDisplay.textContent = `Rp ${numberFormat(originalPrice)}`;

                // Apply loyalty discount
                const loyaltyDiscount = Math.floor((originalPrice * loyaltyDiscountPercentage) / 100);
                if (loyaltyDiscountDisplay) {
                    loyaltyDiscountDisplay.textContent = `-Rp ${numberFormat(loyaltyDiscount)}`;
                }

                finalPrice = originalPrice - loyaltyDiscount;

                // Apply voucher discount if selected
                if (voucherSelect && voucherSelect.value) {
                    const selectedOption = voucherSelect.selectedOptions[0];
                    const discountType = selectedOption.dataset.type;
                    const discountValue = parseInt(selectedOption.dataset.value);
                    const maxDiscount = parseInt(selectedOption.dataset.max);

                    if (discountType === 'percentage') {
                        voucherDiscount = Math.floor((originalPrice * discountValue) / 100);
                        if (maxDiscount) {
                            voucherDiscount = Math.min(voucherDiscount, maxDiscount);
                        }
                    } else {
                        voucherDiscount = discountValue;
                    }

                    voucherDiscountRow.classList.remove('hidden');
                    voucherDiscountDisplay.textContent = `-Rp ${numberFormat(voucherDiscount)}`;
                    finalPrice -= voucherDiscount;
                } else {
                    voucherDiscountRow.classList.add('hidden');
                }

                // Show price details
                priceInfoContainer.classList.add('hidden');
                priceDetailsContainer.classList.remove('hidden');
                finalPriceDisplay.textContent = `Rp ${numberFormat(Math.max(0, finalPrice))}`;

                // Show notification if significant discount applies
                const totalDiscount = loyaltyDiscount + voucherDiscount;
                if (totalDiscount > 0) {
                    showToast(`You saved Rp ${numberFormat(totalDiscount)} with discounts!`, 'success');
                }

            } catch (error) {
                console.error('Error calculating price:', error);
                showToast('Error calculating price. Please try again.', 'error');
            }
        }

        // Add event listeners
        durationSelect.addEventListener('change', calculatePrice);
        if (voucherSelect) {
            voucherSelect.addEventListener('change', calculatePrice);
        }

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

        // Replace existing showToast function with this one
        function showToast(message, type = 'success') {
            ToastManager.showToast(message, type);
        }

        // Initialize toasts from session messages
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

            const table = document.getElementById('table_id');
            if (table) {
                showToast(`Now booking Table #${table.value}`, 'info');
            }
        });
    </script>
</body>

</html>
