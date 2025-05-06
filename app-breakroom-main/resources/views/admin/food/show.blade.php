@extends('admin.layout.app')


@section('title', 'Food ' . $food->name)

@section('content')
<div class="food-container mb-3" style="max-width:500px; margin: auto">
    <div class="food-card text-center p-3" style="background-color: #c97063; border-radius: 10px">
        <h1>Food Details</h1>
        <h4 class="text-center">{{$food->name}}</h4>
        <div class="p-4 flex justify-center">
            <img src="{{asset($image)}}" class="my-2" style="width: 250px; border-radius: 10px"/>
        </div>
        <p style="font-size: 20px; font-weight: bold">{{$food->category}}</p>
        <p>{{$food->description}}</p>
        <p style="font-size: 30px; font-weight: bold">Rp. {{$food->price}}</p>
        <p style="color: 
        @if ($food->status == 'available' || $food->status == 'Available')
            green 
        @elseif ($food->status == 'unavailable' || $food->status == 'Unavailable')
            red
        @endif
        ;font-weight: bolder">{{$food->status}}</p>
    </div>
    <a href="/admin/foods" class="btn btn-info mt-3">Back to Food List</a>
</div>
@endsection