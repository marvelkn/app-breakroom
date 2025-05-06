@extends('admin.layout.app')

@section('title', 'Create New Food')

@section('content')

<div class="create-food-container w-75 mb-3" style="margin: auto; background-color: #ff7d7d; padding: 20px; border-radius: 10px">
    <h1 class="text-center">Create Food</h1>
    <form class="form" action="/admin/food/create_food" method="post" enctype="multipart/form-data">
        @csrf
        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="" required><br />

        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description"></textarea>

        <label for="category" class="form-label">Category</label> 
        <select name="category" id="category" class="form-select" required>
            <option value="Food">Food</option>
            <option value="Drink">Drink</option>
            <option value="Dessert">Dessert</option>
            <option value="Other">Other</option>
        </select>

        <label for="price" class="form-label">Price</label> 
        <input class="form-control" type="number" name="price" id="price" value="" required><br />
        
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <a href="/admin" class="btn btn-info mt-3">Back to Dashboard</a>
</div>

@endsection