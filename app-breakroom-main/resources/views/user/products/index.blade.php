<!-- resources/views/user/products/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Breakroom</title>
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
    <div class="pt-32 pb-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-yellow-400 mb-4">Pro Shop</h2>
                <p class="text-gray-400">Enhance your game with our professional equipment</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <!-- Search Bar -->
                    <div class="relative w-full md:w-96">
                        <input type="text" id="searchInput" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg pl-10 pr-4 py-2.5 focus:ring-yellow-400 focus:border-yellow-400"
                            placeholder="Search products...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="flex gap-4">
                    <select id="sortSelect" class="bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2.5 focus:ring-yellow-400 focus:border-yellow-400">
                        <option value="name">Sort by Name</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                </div>
            </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="products-grid">
                @foreach($products as $product)
                <div class="product-item relative group">
                    <!-- Background Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-yellow-600/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -rotate-1">
                    </div>

                    <!-- Product Card -->
                    <div class="relative bg-gray-800/80 backdrop-blur rounded-xl overflow-hidden shadow-xl transform transition-all duration-300 hover:scale-[1.02]">
                        <!-- Product Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
                            
                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full text-sm 
                                    {{ $product->status === 'Available' ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                    {{ $product->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-yellow-400 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-400 mb-4">{{ $product->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-white">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                @if($product->status === 'Available')
                                <button onclick="openPurchaseModal('{{ $product->id }}', '{{ $product->name }}', {{ $product->price }})"
                                    class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold py-2 px-4 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                    Purchase
                                </button>
                                @else
                                <span class="text-gray-500 font-medium">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Purchase Modal -->
            <div id="purchaseModal" tabindex="-1" aria-hidden="true" 
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-gray-800 rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700 rounded-t">
                            <h3 class="text-xl font-semibold text-white" id="modalProductName">
                                Purchase Details
                            </h3>
                            <button type="button" 
                                class="text-gray-400 bg-transparent hover:bg-gray-700 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                onclick="closePurchaseModal()">
                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form id="purchaseForm" action="{{ route('products.order') }}" method="POST" class="p-4 md:p-5">
                            @csrf
                            <input type="hidden" name="product_id" id="modalProductId">
                            <div class="space-y-4">
                                <div>
                                    <label for="purchase-quantity" class="block mb-2 text-sm font-medium text-white">Quantity</label>
                                    <input type="number" name="quantity" id="purchase-quantity" min="1" value="1"
                                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5"
                                        required>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-400">Total:</span>
                                    <span class="text-lg font-bold text-yellow-400" id="modalTotalPrice">Rp 0</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4 space-x-3">
                                <button type="button" onclick="closePurchaseModal()"
                                    class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg text-sm font-medium px-5 py-2.5 hover:text-white">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="text-black bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Confirm Purchase
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentProductPrice = 0;

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', filterProducts);

        // Sort functionality
        const sortSelect = document.getElementById('sortSelect');
        sortSelect.addEventListener('change', sortProducts);

        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                const name = product.querySelector('h3').textContent.toLowerCase();
                const description = product.querySelector('p').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || description.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }

        function sortProducts() {
            const productsGrid = document.getElementById('products-grid');
            const products = Array.from(document.querySelectorAll('.product-item'));
            
            products.sort((a, b) => {
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

            productsGrid.innerHTML = '';
            products.forEach(product => productsGrid.appendChild(product));
        }

        // Modal functionality
        function openPurchaseModal(productId, productName, price) {
            currentProductPrice = price;
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').textContent = productName;
            updateTotalPrice();
            document.getElementById('purchaseModal').classList.remove('hidden');
            document.getElementById('purchaseModal').classList.add('flex');
        }

        function closePurchaseModal() {
            document.getElementById('purchaseModal').classList.add('hidden');
            document.getElementById('purchaseModal').classList.remove('flex');
            document.getElementById('purchaseForm').reset();
        }

        function updateTotalPrice() {
            const quantity = document.getElementById('purchase-quantity').value;
            const total = currentProductPrice * quantity;
            document.getElementById('modalTotalPrice').textContent = 
                `Rp ${total.toLocaleString('id-ID')}`;
        }

        document.getElementById('purchase-quantity').addEventListener('input', updateTotalPrice);

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('purchaseModal');
            if (event.target === modal) {
                closePurchaseModal();
            }
        }
    </script>
</body>
</html>