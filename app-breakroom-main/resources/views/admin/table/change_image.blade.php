@extends('admin.layout.app')


@section('title', 'Edit Table #' . $table->number)

@section('content')

<div class="edit-table-image-container w-50" style="margin: auto; background-color: #BDCAEF; padding: 20px; border-radius: 10px">
    <h1>Change Image Table #{{$table->number}}</h1>
    <img src="{{asset('storage/' . $table->image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/table/{{ $table->id }}/change_image" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button type="submit" class="btn btn-primary">Update Image</button>
    </form>
    <a href="/admin/tables" class="btn btn-info mt-3">Back to Table List</a>
</div>

@endsection