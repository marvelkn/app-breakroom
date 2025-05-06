@extends('admin.layout.app')


@section('title', 'Edit Food ' . $food->name)

@section('content')


<div class="edit-food-container w-50" style="margin: auto; background-color: #de614e; padding: 20px; border-radius: 10px">
    <h1>Edit Food {{$food->name}}</h1>
    <img src="{{asset(path: $image)}}" class="text-center my-2" style="width: 150px; border-radius: 10px"/><br />
    <form class="form" method="POST" action="/admin/food/{{ $food->id }}">
        @csrf
        @method('PUT')

        <label for="name" class="form-label">Name</label> 
        <input class="form-control" type="text" name="name" id="name" value="{{$food->name}}" required><br />

        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" name="description" id="description">{{$food->description}}</textarea>
        
        <label for="category-{{$food->id}}" class="form-label">Category:</label>
        <select id="category-{{$food->id}}" name="category" class="form-select" style="margin: auto">
            <option value="Food" @selected($food->category == 'food' || $food->category == 'Food')>Food</option>
            <option value="Drink" @selected($food->category == 'drink' || $food->category == 'Drink')>Drink</option>
            <option value="Dessert" @selected($food->category == 'dessert' || $food->category == 'Dessert')>Dessert</option>
            <option value="Other" @selected($food->category == 'other' || $food->category == 'Other')>Other</option>
        </select>
        
        <label for="price" class="form-label">Price</label> 
        <input class="form-control" type="number" name="price" id="price" value="{{$food->price}}" required><br />


        <button type="submit" class="btn btn-primary">Update Food</button>
    </form>
    <a href="/admin/foods" class="btn btn-info mt-3">Back to food List</a>
</div>

@endsection