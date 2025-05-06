@extends('admin.layout.app')

@section('title', 'Create New Event')

@section('content')

<div class="create-event-container w-75 mb-3" style="margin: auto; background-color: #ffa1ef; padding: 20px; border-radius: 10px">
    <h1 class="text-center">Create Event</h1>
    <form class="form" action="/admin/event/create_event" method="post" enctype="multipart/form-data">
        @csrf
        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="" required><br />

        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description"></textarea>

        <label for="date" class="form-label">Date</label> 
        <input class="form-control" type="date" name="date" id="date" value="" required><br />
        
        <label for="time" class="form-label">Time</label> 
        <input class="form-control" type="time" name="time" id="time" value="" required><br />

        <label for="location" class="form-label">Location</label> 
        <input class="form-control" type="text" name="location" id="location" value="" required><br />

        <label for="max_participants" class="form-label">Max Participants</label> 
        <input class="form-control" type="number" name="max_participants" id="max_participants" value="" required><br />
        
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <a href="/admin/events" class="btn btn-info mt-3">Back to Event List</a>
</div>

@endsection