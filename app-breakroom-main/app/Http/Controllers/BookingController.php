<?php

// app/Http/Controllers/BookingController.php
namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function checkAvailability(Request $request)
    {
        $validatedData = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $availableTables = Table::whereDoesntHave('bookings', function($query) use ($validatedData) {
            $query->where('start_time', '<', $validatedData['end_time'])
                  ->where('end_time', '>', $validatedData['start_time']);
        })->get();

        return view('bookings.availability', compact('availableTables', 'validatedData'));
    }

    public function book(Request $request)
    {
        $validatedData = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'table_id' => $validatedData['table_id'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
        ]);

        return redirect()->route('bookings.history')
            ->with('success', 'Booking berhasil');
    }

    public function history()
    {
        $bookings = auth()->user()->bookings()->orderBy('start_time', 'desc')->get();
        return view('bookings.history', compact('bookings'));
    }
}