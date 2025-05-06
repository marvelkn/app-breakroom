@extends('admin.layout.app')

@section('title', 'Admin Tables Page')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-900 animate-slide-in">Tables</h2>
            <div class="space-x-0 sm:space-x-4 flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="/admin/table/create_table"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-sm text-white hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create New Table
                </a>
                <a href="{{ route('admin.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Tables Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tables as $table)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-200 ease-in-out animate-fade-in-up"
                    style="animation-delay: {{ $loop->index * 100 }}ms">
                    <!-- Table Header -->
                    <div class="p-4 bg-gray-50 border-b hover:bg-gray-100 transition-colors">
                        <h4 class="text-xl font-bold text-center">Table {{ $table->number }}</h4>
                    </div>

                    <!-- Table Image -->
                    <div class="p-4 flex justify-center bg-white">
                        <img src="{{ asset('storage/' . $table->image) }}" alt="Table {{ $table->number }}"
                            class="w-48 h-48 object-cover rounded-lg shadow transition-transform duration-300 hover:scale-105" />
                    </div>

                    <!-- Table Info -->
                    <div class="p-4 space-y-3 text-center bg-white">
                        <p class="text-lg font-semibold">Capacity: {{ $table->capacity }} persons</p>
                        <p class="text-xl font-bold text-blue-600">Rp. {{ number_format($table->price) }}/hr</p>
                        <div class="transition-all duration-300 ease-in-out">
                            <span
                                class="inline-block px-4 py-2 rounded-full text-sm font-bold
                        @if ($table->status == 'open' || $table->status == 'Open') bg-green-100 text-green-800
                        @else
                            bg-red-100 text-red-800 @endif">
                                {{ $table->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Status Update Form -->
                    <div class="px-4 py-3 bg-gray-50 border-t">
                        <form action="{{ route('admin.table.updateStatus', $table->id) }}" method="POST"
                            class="flex flex-col sm:flex-row items-center justify-center gap-2">
                            @csrf
                            @method('PUT')
                            <label for="status-{{ $table->id }}"
                                class="text-sm font-medium text-gray-700">Status:</label>
                            <select id="status-{{ $table->id }}" name="status"
                                class="block w-full sm:w-32 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm transition-all duration-200"
                                onchange="this.form.submit()">
                                <option value="Open" @selected($table->status == 'open' || $table->status == 'Open')>Open</option>
                                <option value="Closed" @selected($table->status == 'closed' || $table->status == 'Closed')>Closed</option>
                            </select>
                        </form>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 bg-gray-50 border-t space-y-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <a href="/admin/table/{{ $table->id }}"
                                class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transform hover:scale-105 transition-all duration-200">
                                View Details
                            </a>
                            <a href="/admin/table/{{ $table->id }}/edit"
                                class="inline-flex justify-center items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transform hover:scale-105 transition-all duration-200">
                                Edit Table
                            </a>
                        </div>
                        <a href="/admin/table/{{ $table->id }}/change_image"
                            class="inline-flex justify-center items-center w-full px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transform hover:scale-105 transition-all duration-200">
                            Change Image
                        </a>
                        <form action="/admin/table/{{ $table->id }}" method="post" class="w-full">
                            @method('DELETE')
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this table?')"
                                class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transform hover:scale-105 transition-all duration-200">
                                Delete Table
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
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
    </script>
@endsection
