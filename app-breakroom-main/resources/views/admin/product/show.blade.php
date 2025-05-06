@extends('admin.layout.app')


@section('title', 'Product ' . $product->name)

@section('content')
<div class="product-container mb-3" style="max-width:500px; margin: auto">
    <div class="product-card text-center p-3" style="background-color: #52c75b; border-radius: 10px">
        <h1>Product Details</h1>
        <h4 class="text-center">{{$product->name}}</h4>
        <div class="p-4 flex justify-center">
            <img src="{{asset($image)}}" class="my-2" style="width: 250px; border-radius: 10px"/>
        </div>
        <p>{{$product->description}}</p>
        <p style="font-size: 30px; font-weight: bold">Rp. {{$product->price}}</p>
        <p style="color: 
        @if ($product->status == 'available' || $product->status == 'Available')
            green 
        @elseif ($product->status == 'unavailable' || $product->status == 'Unavailable')
            red
        @endif
        ;font-weight: bolder">{{$product->status}}</p>
    </div>
    <a href="/admin/products" class="btn btn-info mt-3">Back to Product List</a>
</div>
@endsection