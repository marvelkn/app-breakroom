@extends('admin.layout.app')

@section('title', 'Create New Product')

@section('content')

<div class="create-product-container w-75 mb-3" style="margin: auto; background-color: #83c97f; padding: 20px; border-radius: 10px">
    <h1 class="text-center">Create Product</h1>
    <form class="form" action="/admin/product/create_product" method="post" enctype="multipart/form-data">
        @csrf
        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="" required><br />

        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description"></textarea>

        <label for="price" class="form-label">Price</label> 
        <input class="form-control" type="number" name="price" id="price" value="" required><br />
        
        <label for="image" class="form-label">Image</label> 
        <input type="file" class="form-control" name="image" id="image" required> 
        <br />
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    <a href="/admin/products" class="btn btn-info mt-3">Back to Product List</a>
</div>

@endsection