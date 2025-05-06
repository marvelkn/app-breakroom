@extends('admin.layout.app')


@section('title', 'Edit Product ' . $product->name)

@section('content')


<div class="edit-product-container w-50" style="margin: auto; background-color: #a4f5ab; padding: 20px; border-radius: 10px">
    <h1>Edit Product {{$product->name}}</h1>
    <img src="{{asset(path: $image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/product/{{ $product->id }}">
        @csrf
        @method('PUT')

        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="{{$product->name}}" required><br />

        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" name="description" id="description">{{$product->description}}</textarea>

        <label for="price" class="form-label">Price</label> 
        <input class="form-control" type="number" name="price" id="price" value="{{$product->price}}" required><br />

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
    <a href="/admin/products" class="btn btn-info mt-3">Back to Product List</a>
</div>

@endsection