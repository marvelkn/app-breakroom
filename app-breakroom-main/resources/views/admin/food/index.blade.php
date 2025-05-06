@extends('admin.layout.app')

@section('title', 'Admin Foods Page')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Foods & Drinks</h2>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
            <a href="/admin/food/create_food" 
               class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-sm text-white hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 ease-in-out">
                Create New Item
            </a>
            <a href="{{route('admin.index')}}" 
               class="inline-flex justify-center items-center px-4 py-2 bg-gray-100 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 ease-in-out">
                Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Categories Loop -->
    @foreach ($categories as $categoryName => $foods)
        <div class="mb-12 last:mb-0">
            <!-- Category Header -->
            <div class="relative py-4 mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-red-800 inline-block bg-white pr-4">
                    {{ $categoryName }}
                </h3>
                <div class="absolute bottom-1/2 w-full h-px bg-red-200 -z-10"></div>
            </div>

            <!-- Foods Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($foods as $food)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-200 ease-in-out">
                    <!-- Food Header -->
                    <div class="p-4 bg-red-50 border-b">
                        <h4 class="text-lg sm:text-xl font-bold text-center text-red-900">{{$food->name}}</h4>
                    </div>

                    <!-- Food Image -->
                    <div class="p-4 flex justify-center bg-white">
                        <img src="{{$food->image_url}}" 
                             alt="{{$food->name}}" 
                             class="w-40 h-40 object-cover rounded-lg shadow transition-transform duration-300 hover:scale-105"/>
                    </div>

                    <!-- Food Info -->
                    <div class="p-4 space-y-3 bg-white">
                        <p class="text-gray-600 text-center">{{$food->description}}</p>
                        
                        <p class="text-center text-2xl font-bold text-red-600">
                            Rp. {{number_format($food->price)}}
                        </p>
                        
                        <div class="flex justify-center">
                            <span class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300
                                @if ($food->status == 'Available')
                                    bg-green-100 text-green-800
                                @else
                                    bg-red-100 text-red-800
                                @endif">
                                {{$food->status}}
                            </span>
                        </div>
                    </div>

                    <!-- Status Update Form -->
                    <div class="px-4 py-3 bg-red-50 border-t">
                        <form action="{{ route('admin.food.updateStatus', $food->id) }}" 
                              method="POST" 
                              class="flex flex-col sm:flex-row items-center justify-center gap-2">
                            @csrf
                            @method('PUT')
                            <label for="status-{{$food->id}}" class="text-sm font-medium text-gray-700">Status:</label>
                            <select id="status-{{$food->id}}" 
                                    name="status" 
                                    class="block w-full sm:w-40 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm transition-all duration-200"
                                    onchange="this.form.submit()">
                                <option value="Available" @selected($food->status == 'Available')>Available</option>
                                <option value="Unavailable" @selected($food->status == 'Unavailable')>Unavailable</option>
                            </select>
                        </form>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 bg-gray-50 border-t space-y-2">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <a href="/admin/food/{{$food->id}}" 
                               class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transform hover:scale-105 transition-all duration-200">
                                View Details
                            </a>
                            <a href="/admin/food/{{$food->id}}/edit" 
                               class="inline-flex justify-center items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transform hover:scale-105 transition-all duration-200">
                                Edit Item
                            </a>
                            <a href="/admin/food/{{$food->id}}/change_image" 
                               class="inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transform hover:scale-105 transition-all duration-200">
                                Change Image
                            </a>
                        </div>
                        <form action="/admin/food/{{$food->id}}" method="post" class="w-full">
                            @method('DELETE')
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                    class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transform hover:scale-105 transition-all duration-200">
                                Delete Item
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<style>
    .status-transition {
        transition: all 0.3s ease-in-out;
    }
    
    .hover-scale {
        transition: transform 0.2s ease-in-out;
    }
    
    .hover-scale:hover {
        transform: scale(1.05);
    }
    
    @keyframes statusChange {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    .status-change-animation {
        animation: statusChange 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .category-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('select[name="status"]');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const card = this.closest('.bg-white');
            const statusBadge = card.querySelector('.rounded-full');
            
            statusBadge.classList.add('status-change-animation');
            
            setTimeout(() => {
                statusBadge.classList.remove('status-change-animation');
            }, 300);
        });
    });
});
</script>
@endsection