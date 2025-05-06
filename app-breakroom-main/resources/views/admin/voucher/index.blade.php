@extends('admin.layout.app')

@section('title', 'Admin Vouchers Page')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-3xl font-bold text-gray-900 animate-slide-in">Vouchers</h2>
        <div class="space-x-0 sm:space-x-4 flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="/admin/voucher/create_voucher" 
               class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-sm text-white hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create New Voucher
            </a>
            <a href="{{route('admin.index')}}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Vouchers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($vouchers as $voucher)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-200 ease-in-out animate-fade-in-up" style="animation-delay: {{$loop->index * 100}}ms">
            <!-- Voucher Header -->
            <div class="p-4 bg-gray-50 border-b hover:bg-gray-100 transition-colors">
                <h4 class="text-xl font-bold text-center">{{$voucher->name}}</h4>
            </div>

            <!-- Voucher Info -->
            <div class="p-4 space-y-3 bg-white">
                <p class="text-gray-600">{{$voucher->description}}</p>
                <div class="space-y-2">
                    <p class="flex justify-between">
                        <span class="font-medium">Type:</span>
                        <span class="text-blue-600">{{str_replace('_', ' ', ucfirst($voucher->voucher_type))}}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="font-medium">Discount:</span>
                        <span class="text-green-600">
                            @if($voucher->discount_type === 'percentage')
                                {{$voucher->discount_value}}%
                            @else
                                Rp {{number_format($voucher->discount_value)}}
                            @endif
                        </span>
                    </p>
                    <p class="flex justify-between">
                        <span class="font-medium">Points Required:</span>
                        <span class="text-orange-600">{{number_format($voucher->points_required)}}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="font-medium">Stock:</span>
                        <span class="text-purple-600">{{$voucher->stock === -1 ? 'Unlimited' : $voucher->stock}}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="font-medium">Valid for:</span>
                        <span>{{$voucher->validity_days}} days</span>
                    </p>
                </div>
            </div>

            <!-- Status Toggle -->
            <div class="px-4 py-3 bg-gray-50 border-t">
                <form action="{{ route('admin.voucher.updateStatus', $voucher->id) }}" method="POST" 
                      class="flex flex-col sm:flex-row items-center justify-center gap-2">
                    @csrf
                    @method('PUT')
                    <label for="is_active-{{$voucher->id}}" class="text-sm font-medium text-gray-700">Status:</label>
                    <select id="is_active-{{$voucher->id}}" 
                            name="is_active" 
                            class="block w-full sm:w-32 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all duration-200"
                            onchange="this.form.submit()">
                        <option value="1" @selected($voucher->is_active)>Active</option>
                        <option value="0" @selected(!$voucher->is_active)>Inactive</option>
                    </select>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="p-4 bg-gray-50 border-t space-y-2">
                <div class="grid grid-cols-2 gap-2">
                    <a href="/admin/voucher/{{$voucher->id}}/edit" 
                       class="inline-flex justify-center items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transform hover:scale-105 transition-all duration-200">
                        Edit
                    </a>
                    <form action="/admin/voucher/{{$voucher->id}}" method="post" class="w-full">
                        @method('DELETE')
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this voucher?')"
                                class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transform hover:scale-105 transition-all duration-200">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    /* Keep your existing animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
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
</style>
@endsection