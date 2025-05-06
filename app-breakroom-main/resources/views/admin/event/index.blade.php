@extends('admin.layout.app')

@section('title', 'Admin Events Page')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Section - Responsive padding -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Events</h2>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
            <a href="/admin/event/create_event" 
               class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 rounded-md font-semibold text-sm text-white hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 ease-in-out">
                Create New Event
            </a>
            <a href="{{route('admin.index')}}" 
               class="inline-flex justify-center items-center px-4 py-2 bg-gray-100 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 ease-in-out">
                Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Events Grid - Responsive columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($events as $event)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-200 ease-in-out">
            <!-- Event Header -->
            <div class="p-4 bg-purple-50 border-b">
                <h4 class="text-lg sm:text-xl font-bold text-center text-purple-900">{{$event->name}}</h4>
            </div>

            <!-- Event Image - Responsive sizing -->
            <div class="p-4 flex justify-center bg-white">
                <img src="{{$event->image_url}}" 
                     alt="{{$event->name}}" 
                     class="w-full h-48 sm:h-64 object-cover rounded-lg shadow transition-transform duration-300 hover:scale-105"/>
            </div>

            <!-- Event Info -->
            <div class="p-4 space-y-3 bg-white">
                <!-- Date and Time - Stack on mobile -->
                <div class="flex flex-col sm:flex-row justify-center items-center gap-2 sm:gap-4">
                    <div class="bg-purple-50 px-4 py-2 rounded-full w-full sm:w-auto text-center">
                        <p class="font-semibold text-purple-900">
                            {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="bg-purple-50 px-4 py-2 rounded-full w-full sm:w-auto text-center">
                        <p class="font-semibold text-purple-900">
                            {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}
                        </p>
                    </div>
                </div>
                
                <p class="text-center font-semibold text-gray-700">
                    Max Participants: {{$event->max_participants}}
                </p>
                
                <div class="flex justify-center">
                    <span class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300
                        @if ($event->status == 'Open')
                            bg-green-100 text-green-800
                        @elseif ($event->status == 'Ongoing')
                            bg-orange-100 text-orange-800
                        @else
                            bg-red-100 text-red-800
                        @endif">
                        {{$event->status}}
                    </span>
                </div>
            </div>

            <!-- Status Update Form - Full width on mobile -->
            <div class="px-4 py-3 bg-purple-50 border-t">
                <form action="{{ route('admin.event.updateStatus', $event->id) }}" 
                      method="POST" 
                      class="flex flex-col sm:flex-row items-center justify-center gap-2">
                    @csrf
                    @method('PUT')
                    <label for="status-{{$event->id}}" class="text-sm font-medium text-gray-700">Status:</label>
                    <select id="status-{{$event->id}}" 
                            name="status" 
                            class="block w-full sm:w-40 rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm transition-all duration-200"
                            onchange="this.form.submit()">
                        <option value="Open" @selected($event->status == 'Open')>Open</option>
                        <option value="Ongoing" @selected($event->status == 'Ongoing')>Ongoing</option>
                        <option value="Closed" @selected($event->status == 'Closed')>Closed</option>
                    </select>
                </form>
            </div>

            <!-- Action Buttons - Stack on mobile -->
            <div class="p-4 bg-gray-50 border-t space-y-2">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <a href="/admin/event/{{$event->id}}" 
                       class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transform hover:scale-105 transition-all duration-200">
                        View Details
                    </a>
                    <a href="/admin/event/{{$event->id}}/edit" 
                       class="inline-flex justify-center items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transform hover:scale-105 transition-all duration-200">
                        Edit Event
                    </a>
                    <a href="/admin/event/{{$event->id}}/change_image" 
                       class="inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transform hover:scale-105 transition-all duration-200">
                        Change Image
                    </a>
                </div>
                <form action="/admin/event/{{$event->id}}" method="post" class="w-full">
                    @method('DELETE')
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to delete this event?')"
                            class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transform hover:scale-105 transition-all duration-200">
                        Delete Event
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add this to your layout or page for animation utilities -->
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
</style>

<!-- Add this script for status change animation -->
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