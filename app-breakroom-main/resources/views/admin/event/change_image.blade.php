@extends('admin.layout.app')


@section('title', 'Change Image Event ' . $event->name)

@section('content')

<div class="edit-event-image-container w-50" style="margin: auto; background-color: #BDCAEF; padding: 20px; border-radius: 10px">
    <h1>Change Image Event {{$event->name}}</h1>
    <img src="{{asset(path: $image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/event/{{ $event->id }}/change_image" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button type="submit" class="btn btn-primary">Update Image</button>
    </form>
    <a href="/admin/events" class="btn btn-info mt-3">Back to Event List</a>
</div>

@endsection