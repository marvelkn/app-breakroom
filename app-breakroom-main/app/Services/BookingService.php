<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\TableBooking;

class BookingService 
{
    public function getOperatingHours($date)
    {
        $date = Carbon::parse($date);
        $isWeekend = $date->isWeekend();
        
        return [
            'open' => $isWeekend ? '11:00' : '10:00',
            'close' => $isWeekend ? '01:00' : '00:00',
            'is_weekend' => $isWeekend
        ];
    }

    public function getUnavailableSlots($table_id, $date)
    {
        // Get all bookings for this table on this date
        $bookings = TableBooking::where('table_id', $table_id)
            ->where('booking_time', $date)
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->get();

        // Create array of unavailable time ranges
        $unavailableSlots = [];
        foreach ($bookings as $booking) {
            $unavailableSlots[] = [
                'start' => Carbon::parse($booking->start_time)->format('H:i'),
                'end' => Carbon::parse($booking->end_time)->format('H:i')
            ];
        }

        return $unavailableSlots;
    }
}