@extends('admin.layout.app')

@section('title', 'Table #' . $table->number)

@section('content')

<div class="table-container" style="max-width:500px; margin: auto">
    <div class="table-card text-center p-3" style="background-color: lightblue; border-radius: 10px">
        <h1>Table Details</h1>
        <div class="p-4 flex justify-center">
            <img src="{{asset($image)}}" class="my-2" style="width: 250px; border-radius: 10px"/>
        </div>
        <p><strong>Table Number:</strong> {{ $table->number }}</p>
        <p><strong>Capacity:</strong> {{ $table->capacity }}</p>
        <p><b>Rp. {{$table->price}}</b>/hr</p>
        <p style="color: 
        @if ($table->status == 'open' || $table->status == 'Open')
            green 
        @else
            red
        @endif
        ;font-weight: bolder">{{$table->status}}</p>
    </div>
    <a href="/admin/tables" class="btn btn-info mt-3">Back to Table List</a>
</div>

@endsection