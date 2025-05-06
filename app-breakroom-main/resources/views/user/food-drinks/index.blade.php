<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food & Drinks - Breakroom</title>
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
                        <a href="{{route('user.event.index')}}"
                            class="hover:text-yellow-400 transition-colors">Events</a>
                        <a href="{{route('food-and-drinks.index')}}"
                            class="hover:text-yellow-400 transition-colors">Food & Drinks</a>
                        <a href="{{route('products.index')}}"
                            class="hover:text-yellow-400 transition-colors">Products</a>
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
                <h2 class="text-3xl font-bold text-yellow-400 mb-4">Food & Drinks Menu</h2>
                <p class="text-gray-400">Enjoy our delicious selections while you play</p>
            </div>

            <!-- Category Tabs -->
            <div class="mb-8">
                <div class="border-b border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button onclick="filterItems('all')"
                            class="category-tab active border-yellow-400 text-yellow-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            All Items
                        </button>
                        <button onclick="filterItems('Food')"
                            class="category-tab border-transparent text-gray-400 hover:text-yellow-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Food
                        </button>
                        <button onclick="filterItems('Drink')"
                            class="category-tab border-transparent text-gray-400 hover:text-yellow-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Drinks
                        </button>
                        <button onclick="filterItems('Dessert')"
                            class="category-tab border-transparent text-gray-400 hover:text-yellow-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Desserts
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="relative w-full md:w-96">
                        <input type="text" id="searchInput"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg pl-10 pr-4 py-2.5 focus:ring-yellow-400 focus:border-yellow-400"
                            placeholder="Search menu items...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="flex gap-4">
                        <select id="sortSelect"
                            class="bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2.5 focus:ring-yellow-400 focus:border-yellow-400">
                            <option value="name">Sort by Name</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="menu-grid">
                @foreach($items as $item)
                    <div class="menu-item relative group" data-category="{{ $item->category }}">
                        <!-- Background Glow Effect -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-yellow-600/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -rotate-1">
                        </div>

                        <!-- Item Card -->
                        <div
                            class="relative bg-gray-800/80 backdrop-blur rounded-xl overflow-hidden shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
                            <!-- Item Image -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />

                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm 
                                            {{ $item->status === 'Available' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Item Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-yellow-400 mb-2">{{ $item->name }}</h3>
                                <p class="text-gray-400 mb-4">{{ $item->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-white">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                    @if($item->status === 'Available')
                                        <button
                                            onclick="openOrderModal('{{ $item->id }}', '{{ $item->name }}', {{ $item->price }})"
                                            class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold py-2 px-4 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                            Order Now
                                        </button>
                                    @else
                                        <span class="text-gray-500 font-medium">Currently Unavailable</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Order Modal -->
    <div id="orderModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-gray-800 rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700 rounded-t">
                    <h3 class="text-xl font-semibold text-white" id="modalItemName">
                        Order Details
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-700 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        onclick="closeOrderModal()">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="orderForm" action="{{ route('food-and-drinks.order') }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    <input type="hidden" name="item_id" id="modalItemId">
                    <div class="space-y-4">
                        <div>
                            <label for="quantity" class="block mb-2 text-sm font-medium text-white">Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="1"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label for="notes" class="block mb-2 text-sm font-medium text-white">Special Instructions
                                (Optional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5"
                                placeholder="Any special requests?"></textarea>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-400">Total:</span>
                            <span class="text-lg font-bold text-yellow-400" id="modalTotalPrice">Rp 0</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4 space-x-3">
                        <button type="button" onclick="closeOrderModal()"
                            class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg text-sm font-medium px-5 py-2.5 hover:text-white">
                            Cancel
                        </button>
                        <button type="submit"
                            class="text-black bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Filter items by category
        function filterItems(category) {
            const items = document.querySelectorAll('.menu-item');
            const tabs = document.querySelectorAll('.category-tab');

            // Update active tab
            tabs.forEach(tab => {
                tab.classList.remove('border-yellow-400', 'text-yellow-400');
                tab.classList.add('border-transparent', 'text-gray-400');
            });
            event.target.classList.remove('border-transparent', 'text-gray-400');
            event.target.classList.add('border-yellow-400', 'text-yellow-400');

            // Filter items
            items.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Modal functionality
        let currentItemPrice = 0;

        function openOrderModal(itemId, itemName, price) {
            currentItemPrice = price;
            document.getElementById('modalItemId').value = itemId;
            document.getElementById('modalItemName').textContent = itemName;
            updateTotalPrice();
            document.getElementById('orderModal').classList.remove('hidden');
            document.getElementById('orderModal').classList.add('flex');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
            document.getElementById('orderModal').classList.remove('flex');
            document.getElementById('orderForm').reset();
        }

        function updateTotalPrice() {
            const quantity = document.getElementById('quantity').value;
            const total = currentItemPrice * quantity;
            document.getElementById('modalTotalPrice').textContent =
                `Rp ${total.toLocaleString('id-ID')}`;
        }

        document.getElementById('quantity').addEventListener('input', updateTotalPrice);

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                closeOrderModal();
            }
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', filterMenuItems);

        // Sort functionality
        const sortSelect = document.getElementById('sortSelect');
        sortSelect.addEventListener('change', sortMenuItems);

        function filterMenuItems() {
            const searchTerm = searchInput.value.toLowerCase();
            const menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                const name = item.querySelector('h3').textContent.toLowerCase();
                const description = item.querySelector('p').textContent.toLowerCase();
                const category = item.dataset.category.toLowerCase();

                if (name.includes(searchTerm) || description.includes(searchTerm) || category.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function sortMenuItems() {
            const menuGrid = document.getElementById('menu-grid');
            const items = Array.from(document.querySelectorAll('.menu-item'));

            items.sort((a, b) => {
                const priceA = parseInt(a.querySelector('.text-lg').textContent.replace(/[^0-9]/g, ''));
                const priceB = parseInt(b.querySelector('.text-lg').textContent.replace(/[^0-9]/g, ''));
                const nameA = a.querySelector('h3').textContent;
                const nameB = b.querySelector('h3').textContent;

                switch (sortSelect.value) {
                    case 'price-low':
                        return priceA - priceB;
                    case 'price-high':
                        return priceB - priceA;
                    default:
                        return nameA.localeCompare(nameB);
                }
            });

            menuGrid.innerHTML = '';
            items.forEach(item => menuGrid.appendChild(item));
        }
    </script>
</body>

</html>