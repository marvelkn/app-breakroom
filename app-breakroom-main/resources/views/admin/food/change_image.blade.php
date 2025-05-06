@extends('admin.layout.app')


@section('title', 'Change Image Food ' . $food->name)

@section('content')

<div class="edit-food-image-container w-50" style="margin: auto; background-color: #d18377; padding: 20px; border-radius: 10px">
    <h1>Change Image Event {{$food->name}}</h1>
    <img src="{{asset(path: $image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/food/{{ $food->id }}/change_image" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button type="submit" class="btn btn-primary">Update Image</button>
    </form>
    <a href="/admin/foods" class="btn btn-info mt-3">Back to Food List</a>
</div>

@endsection