@extends('admin.layout.app')


@section('title', 'Create New Table')

@section('content')

<div class="create-table-container w-75 mb-3" style="margin: auto; background-color: #BAF4FF; padding: 20px; border-radius: 10px">
    <h1 class="text-center">Create Table</h1>
    <form class="form" action="/admin/table/create_table" method="post" enctype="multipart/form-data">
        @csrf
        <label for="number" class="form-label">Number</label> 
        <input class="form-control" type="number" name="number" id="number" value="" required><br />
    
        <label for="status" class="form-label">Status</label> 
        <select name="status" id="status" class="form-select" required>
            <option value="Open">Open</option>
            <option value="Closed">Closed</option>
        </select>
        <br />
        <label for="capacity" class="form-label">Capacity</label> 
        <input class="form-control" type="number" name="capacity" id="capacity" value="" required><br />

        <label for="price" class="form-label">Price (per hour)</label> 
        <input class="form-control" type="number" name="price" id="price" value="" required><br />
        
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <a href="/admin/tables" class="btn btn-info mt-3">Back to Table List</a>
</div>

@endsection