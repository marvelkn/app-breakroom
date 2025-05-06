@extends('admin.layout.app')


@section('title', 'Edit Table #' . $table->number)

@section('content')


<div class="edit-table-container w-50" style="margin: auto; background-color: #BDCBFF; padding: 20px; border-radius: 10px">
    <h1>Edit Table #{{$table->number}}</h1>
    <img src="{{asset(path: $image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/table/{{ $table->id }}">
        @csrf
        @method('PUT')

        <label for="number" class="form-label">Number</label> 
        <input class="form-control" type="number" name="number" id="number" value="{{ $table->number }}" required>
        <br />
        <label for="capacity" class="form-label">Capacity</label> 
        <input class="form-control" type="number" name="capacity" id="capacity" value="{{ $table->capacity }}" required>
        <br />
        <label for="price" class="form-label">Price (per hour)</label> 
        <input class="form-control" type="number" name="price" id="price" value="{{ $table->price }}" required>
        <br />
        <button type="submit" class="btn btn-primary">Update Table</button>
    </form>
    <a href="/admin/tables" class="btn btn-info mt-3">Back to Table List</a>
</div>

@endsection