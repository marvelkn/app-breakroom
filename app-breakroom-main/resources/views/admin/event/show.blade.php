@extends('admin.layout.app')


@section('title', 'Event ' . $event->name)

@section('content')
<div class="event-container mb-3">
    <h1 class="text-center text-3xl mb-3">Event Details</h1>
    <div class="event-card text-center p-3" style="max-width:500px; margin: auto; background-color: #c29ded; border-radius: 10px">
        <h4 class="text-center font-bold text-2xl">{{$event->name}}</h4>
        <div class="p-4 flex justify-center">
            <img src="{{asset($image)}}" class="my-2" style="width: 250px; border-radius: 10px"/>
        </div>
        <p style="">{{$event->description}}</p>
        <p style="">{{$event->location}}</p>
        <p style="font-weight: bold">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }} {{ \Carbon\Carbon::parse($event->time)->format('H:i') }}</p>
        <p style="font-weight: bold">Max Participants: {{$event->max_participants}}</p>
        <p style="color: 
        @if ($event->status == 'open' || $event->status == 'Open')
            green 
        @elseif ($event->status == 'ongoing' || $event->status == 'Ongoing')
            #e06900
        @else
            red
        @endif
        ;font-weight: bolder">{{$event->status}}</p>
    </div>
    <a href="/admin/events" class="btn btn-info mt-3">Back to Event List</a>

    <!-- <div class="participants-section mt-4" style="max-width:800px; margin: auto">
        <h2 class="text-center mb-3 text-2xl">Participants</h2>
        
        @if($event->eventRegistration->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->eventRegistration as $registration)
                            <tr>
                                <td>{{ $registration->user->name }}</td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $registration->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-center mt-2">
                Total Participants: {{ $event->eventRegistration->count() }} / {{ $event->max_participants }}
            </p>
        @else
            <p class="text-center">No participants registered yet.</p>
        @endif
    </div> -->

    <!-- <hr>
    <hr>
    <hr>
    <hr> -->
    <!-- Ready Participants Section -->
    <div class="participants-section mt-4" style="max-width:800px; margin: auto">
        <h2 class="text-center mb-3 text-2xl font-bold">Participants</h2>
        <hr class="mb-3">
        <h2 class="text-center mb-3 text-xl text-green-600">Ready Participants</h2>
        
        @php
            $readyRegistrations = $event->eventRegistration->where('status', 'Ready');
            $readyNumber = 1;
        @endphp

        @if($readyRegistrations->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readyRegistrations as $index => $registration)
                            <tr>
                                <td>{{ $readyNumber++ }}</td>
                                <td>{{ $registration->user->name }}</td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-center mt-2">
                Total Ready Participants: {{ $readyRegistrations->count() }} / {{ $event->max_participants }}
            </p>
        @else
            <p class="text-center">No ready participants.</p>
            <p class="text-center">Available Slots: {{ $event->max_participants }}</p>
        @endif
        <hr class="my-3">
    </div>

    <!-- Cancelled Participants Section -->
    <div class="participants-section mt-4" style="max-width:800px; margin: auto">
        <h2 class="text-center mb-3 text-xl text-red-600">Cancelled Registrations</h2>
        
        @php
            $cancelledRegistrations = $event->eventRegistration->where('status', 'Cancelled');
            $cancelledNumber = 1;
        @endphp

        @if($cancelledRegistrations->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cancelledRegistrations as $index => $registration)
                            <tr>
                                <td>{{ $cancelledNumber++ }}</td>
                                <td>{{ $registration->user->name }}</td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ optional($registration->created_at)->format('M d, Y H:i') ?? 'Date not recorded' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-center mt-2">
                Total Cancelled Registrations: {{ $cancelledRegistrations->count() }}
            </p>
        @else
            <p class="text-center">No cancelled registrations.</p>
        @endif
        <hr class="my-3">
    </div>

    <!-- Overall Stats -->
    <!-- <div class="stats-section mt-4">
        <p class="text-center">
            Total Registrations: {{ $event->eventRegistration->count() }} / {{ $event->max_participants }}
        </p>
    </div> -->
</div>
@endsection