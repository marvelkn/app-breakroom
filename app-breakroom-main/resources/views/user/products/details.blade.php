@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-500 hover:text-blue-600 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
        </a>

        <!-- Product Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Product Image -->
            @if($product->image)
                <div class="h-96 overflow-hidden">
                    <img src="{{ Storage::url($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Product Content -->
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($product->status === 'Available') 
                            bg-green-100 text-green-800
                        @else 
                            bg-red-100 text-red-800
                        @endif">
                        {{ $product->status }}
                    </span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Price</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <div class="prose max-w-none text-gray-600">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Add to Cart Button or Purchase Action -->
                @if($product->status === 'Available')
                    <div class="mt-8 flex justify-center">
                        <form action="{{ route('products.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" 
                                    class="px-8 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors
                                           flex items-center space-x-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-8 flex justify-center">
                        <span class="px-8 py-3 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">
                            Currently Unavailable
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Additional Information or Related Products could go here -->
    </div>
</div>
@endsection