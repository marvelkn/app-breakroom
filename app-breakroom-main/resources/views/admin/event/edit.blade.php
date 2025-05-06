@extends('admin.layout.app')


@section('title', 'Edit Event ' . $event->name)

@section('content')


<div class="edit-event-container w-50" style="margin: auto; background-color: #BDCBFF; padding: 20px; border-radius: 10px">
    <h1>Edit Event {{$event->name}}</h1>
    <img src="{{asset(path: $image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/event/{{ $event->id }}">
        @csrf
        @method('PUT')

        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="{{$event->name}}" required><br />

        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" name="description" id="description">{{$event->description}}</textarea>

        <label for="date" class="form-label">Date</label> 
        <input class="form-control" type="date" name="date" id="date" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}" required><br />
        
        <label for="time" class="form-label">Time</label> 
        <input class="form-control" type="time" name="time" id="time" value="{{ \Carbon\Carbon::parse($event->time)->format('H:i') }}" required><br />

        <label for="location" class="form-label">Location</label> 
        <input class="form-control" type="text" name="location" id="location" value="{{$event->location}}" required><br />

        <label for="max_participants" class="form-label">Max Participants</label> 
        <input class="form-control" type="number" name="max_participants" id="max_participants" value="{{$event->max_participants}}" required><br />
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
    <a href="/admin/events" class="btn btn-info mt-3">Back to Event List</a>
</div>

@endsection