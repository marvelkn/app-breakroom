<?php

namespace App\Http\Controllers;

use App\Models\UserVoucher;
use App\Models\TableBooking;
use Illuminate\Http\Request;
use App\Models\PointTransaction;
use App\Services\BookingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TableBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function adminIndex()
    {
        $bookings = TableBooking::with(['user', 'table', 'usedVoucher'])->whereIn('status', ['active', 'pending', ['completed'], ['cancelled']])->orderBy('booking_time', 'desc')->get();

        foreach ($bookings as $booking) {
            if ($booking->status === 'completed') {
                $booking->total_price = $booking->final_price;
                $booking->duration_display = floor($booking->final_duration / 60) . 'h ' . ($booking->final_duration % 60) . 'm';
            } elseif ($booking->status === 'active') {
                $startTime = \Carbon\Carbon::parse($booking->started_at);
                $durationInSeconds = $startTime->diffInSeconds(now());

                // Calculate hours, minutes, and seconds
                $hours = floor($durationInSeconds / 3600);
                $minutes = floor(($durationInSeconds % 3600) / 60);
                $seconds = $durationInSeconds % 60;

                // Format the duration string
                $booking->duration_display = "{$hours}h {$minutes}m {$seconds}s";

                $booking->total_price = $booking->booking_type === '3-hour-package'
                    ? $booking->final_price
                    : ($durationInSeconds / 3600) * $booking->table->price;
            } else {
                $booking->total_price = $booking->booking_type === '3-hour-package' ? $booking->final_price : 0;
                $booking->duration_display = '-';
            }

            $booking->price_display = 'Rp ' . number_format($booking->total_price, 0, ',', '.');
        }

        return view('admin.table_bookings.index', compact('bookings'));
    }

    public function finish($id)
    {
        $booking = TableBooking::with(['user', 'table', 'user.loyaltyTier'])->findOrFail($id);

        // Calculate original price
        $duration = $booking->duration ?? 0;
        $price = $booking->table->price ?? 0;
        $originalPrice = ($duration / 60) * $price;

        // Get loyalty discount
        $loyaltyDiscount = 0;
        $loyaltyDiscount = floor(($originalPrice * $booking->user->loyaltyTier->table_discount_percentage) / 100);


        // Get voucher discount
        $voucherDiscount = 0;
        if ($booking->used_voucher_id) {
            $userVoucher = UserVoucher::with('voucher')->find($booking->used_voucher_id);
            if ($userVoucher) {
                if ($userVoucher->voucher->discount_type === 'percentage') {
                    $voucherDiscount = floor(($originalPrice * $userVoucher->voucher->discount_value) / 100);
                    if ($userVoucher->voucher->max_discount) {
                        $voucherDiscount = min($voucherDiscount, $userVoucher->voucher->max_discount);
                    }
                } else {
                    $voucherDiscount = $userVoucher->voucher->discount_value;
                }

                // Mark voucher as used
                $userVoucher->is_used = true;
                $userVoucher->used_at = now();
                $userVoucher->save();
            }
        }

        // Calculate final price
        $finalPrice = ($originalPrice - $loyaltyDiscount) - $voucherDiscount;

        // Update booking
        $booking->status = 'finished';
        $booking->original_price = $originalPrice;
        $booking->loyalty_discount = $loyaltyDiscount;
        $booking->voucher_discount = $voucherDiscount;
        $booking->final_price = $finalPrice;

        // Add loyalty points based on final paid price
        $booking->user->loyalty_points += floor($finalPrice / 10000);

        DB::transaction(function () use ($booking) {
            $booking->save();
            $booking->user->save();
        });

        return redirect('/admin/bookings')->with('success', 'Booking has been marked as finished.');
    }

    public function cancel($id)
    {
        try {
            $booking = TableBooking::with(['user', 'table'])->findOrFail($id);

            // If this was an active session, calculate final duration and price
            if ($booking->status === 'active' && $booking->started_at) {
                $duration = now()->diffInMinutes($booking->started_at);
                $finalPrice = $booking->booking_type === '3-hour-package'
                    ? $booking->final_price
                    : ($duration / 60) * $booking->table->price;

                $booking->update([
                    'status' => 'cancelled',
                    'end_time' => now(),
                    'final_duration' => $duration,
                    'final_price' => $finalPrice,
                    'is_active' => false
                ]);

                // Free up the table
                $booking->table->update(['status' => 'Open']);
            } else {
                // For pending bookings, just mark as cancelled
                $booking->update([
                    'status' => 'cancelled',
                    'is_active' => false
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking has been cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function startSession(Request $request, $id)
    {
        $booking = TableBooking::findOrFail($id);

        // Check if booking can be started
        if ($booking->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be started'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Update booking
            $booking->update([
                'started_at' => now(),
                'status' => 'active',
                'is_active' => true,
            ]);

            // Update table status
            $booking->table->update([
                'status' => 'In Use'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Session started successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error starting session'
            ], 500);
        }
    }

    public function endSession($id)
    {
        $booking = TableBooking::with(['user', 'table', 'user.loyaltyTier'])->findOrFail($id);

        if ($booking->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be ended'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $duration = now()->diffInMinutes($booking->started_at);
            $originalPrice = $booking->booking_type === '3-hour-package'
                ? $booking->final_price
                : ($duration / 60) * $booking->table->price;

            // Calculate loyalty discount
            $loyaltyDiscount = 0;
            if ($booking->user->loyaltyTier) {
                $loyaltyDiscount = floor(($originalPrice * $booking->user->loyaltyTier->table_discount_percentage) / 100);
            }

            // Calculate voucher discount
            $voucherDiscount = 0;
            if ($booking->used_voucher_id) {
                $userVoucher = UserVoucher::with('voucher')->find($booking->used_voucher_id);
                if ($userVoucher) {
                    if ($userVoucher->voucher->discount_type === 'percentage') {
                        $voucherDiscount = floor(($originalPrice * $userVoucher->voucher->discount_value) / 100);
                        if ($userVoucher->voucher->max_discount) {
                            $voucherDiscount = min($voucherDiscount, $userVoucher->voucher->max_discount);
                        }
                    } else {
                        $voucherDiscount = $userVoucher->voucher->discount_value;
                    }

                    // Mark voucher as used
                    $userVoucher->update([
                        'is_used' => true,
                        'used_at' => now(),
                        'used_reference_type' => 'table_booking',
                        'used_reference_id' => $booking->id
                    ]);
                }
            }

            // Calculate final price
            $finalPrice = ($originalPrice - $loyaltyDiscount) - $voucherDiscount;

            // Update booking
            $booking->update([
                'status' => 'completed',
                'end_time' => now(),
                'final_duration' => $duration,
                'original_price' => $originalPrice,
                'loyalty_discount' => $loyaltyDiscount,
                'voucher_discount' => $voucherDiscount,
                'final_price' => $finalPrice,
                'is_active' => false
            ]);

            // Update table status
            $booking->table->update(['status' => 'Open']);

            // Award loyalty points based on final price
            $pointsEarned = floor($finalPrice / 10000); // 1 point per 10,000
            $booking->user->increment('loyalty_points', $pointsEarned);

            // Record point transaction
            PointTransaction::create([
                'user_id' => $booking->user_id,
                'transaction_type' => 'earn',
                'points' => $pointsEarned,
                'reference_type' => 'table_booking',
                'reference_id' => $booking->id,
                'description' => "Points earned from table booking #{$booking->id}"
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Session ended successfully',
                'duration' => $duration,
                'original_price' => $originalPrice,
                'loyalty_discount' => $loyaltyDiscount,
                'voucher_discount' => $voucherDiscount,
                'final_price' => $finalPrice,
                'points_earned' => $pointsEarned
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error ending session: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error ending session'
            ], 500);
        }
    }

    public function getUpdatedPrices()
    {
        $bookings = TableBooking::with(['table'])
            ->where('status', 'active')
            ->get();

        foreach ($bookings as $booking) {
            $startTime = \Carbon\Carbon::parse($booking->started_at);
            $duration = $startTime->diffInMinutes(now());
            $totalPrice = $booking->booking_type === '3-hour-package'
                ? $booking->final_price
                : ($duration / 60) * $booking->table->price;

            $booking->price_display = 'Rp ' . number_format($totalPrice, 0, ',', '.');
        }

        return response()->json($bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'price_display' => $booking->price_display,
            ];
        }));
    }

    public function getUpdatedDurations()
    {
        $bookings = TableBooking::where('status', 'active')->get();

        foreach ($bookings as $booking) {
            $startTime = \Carbon\Carbon::parse($booking->started_at);
            $durationInSeconds = $startTime->diffInSeconds(now());

            $hours = floor($durationInSeconds / 3600);
            $minutes = floor(($durationInSeconds % 3600) / 60);
            $seconds = $durationInSeconds % 60;

            $booking->duration_display = "{$hours}h {$minutes}m {$seconds}s";
        }

        return response()->json($bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'duration_display' => $booking->duration_display,
            ];
        }));
    }

    public function getActiveSessions()
    {
        $activeBookings = TableBooking::with(['table'])
            ->where('status', 'active')
            ->get()
            ->map(function ($booking) {
                $startTime = \Carbon\Carbon::parse($booking->started_at);
                $durationInSeconds = $startTime->diffInSeconds(now());
                $durationInMinutes = $durationInSeconds / 60;
                $currentPrice = ($durationInMinutes / 60) * $booking->table->price;

                $hours = floor($durationInSeconds / 3600);
                $minutes = floor(($durationInSeconds % 3600) / 60);
                $seconds = $durationInSeconds % 60;

                return [
                    'id' => $booking->id,
                    'table_id' => $booking->table_id,
                    'duration_display' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds),
                    'current_price' => $currentPrice
                ];
            });

        return response()->json($activeBookings);
    }

    public function getOperatingHours(Request $request)
    {
        $bookingService = new BookingService();
        return response()->json($bookingService->getOperatingHours($request->date));
    }

    public function getUnavailableSlots(Request $request, $table_id)
    {
        $bookingService = new BookingService();
        return response()->json($bookingService->getUnavailableSlots($table_id, $request->date));
    }

    public function getAvailableSlots($table_id, $date)
    {
        try {
            $isWeekend = \Carbon\Carbon::parse($date)->isWeekend();
            $openingTime = $isWeekend ? '11:00' : '10:00';
            $closingTime = $isWeekend ? '01:00' : '00:00';

            // Get bookings for this table and date
            $bookings = TableBooking::where('table_id', $table_id)
                ->where('booking_time', $date)
                ->whereIn('status', ['pending', 'confirmed', 'active'])
                ->get();

            // Create array of booked time slots
            $bookedSlots = [];
            foreach ($bookings as $booking) {
                $start = \Carbon\Carbon::parse($booking->start_time);
                $end = \Carbon\Carbon::parse($booking->end_time);

                // Add all 30-minute slots between start and end time
                while ($start < $end) {
                    $bookedSlots[] = $start->format('H:i');
                    $start->addMinutes(30);
                }
            }

            return response()->json([
                'success' => true,
                'slots' => $bookedSlots,
                'operating_hours' => [
                    'open' => $openingTime,
                    'close' => $closingTime,
                    'is_weekend' => $isWeekend
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching time slots'
            ], 500);
        }
    }
}
