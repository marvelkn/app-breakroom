<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TableBooking;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;

class TableBookingSeeder extends Seeder
{
    // public function run()
    // {
    //     // Get some tables and users
    //     $tables = Table::all();
    //     $users = User::where('role_id', 2)->get(); // Get member users only

    //     if ($tables->isEmpty() || $users->isEmpty()) {
    //         $this->command->info('Please seed tables and users first!');
    //         return;
    //     }

    //     // Create various booking scenarios
    //     foreach ($tables as $table) {
    //         // 1. Active Booking (currently in use)
    //         TableBooking::create([
    //             'user_id' => $users->random()->id,
    //             'table_id' => $table->id,
    //             'booking_time' => Carbon::now()->subHours(1),
    //             'booking_type' => 'open',
    //             'started_at' => Carbon::now()->subHours(1),
    //             'status' => 'active',
    //             'is_active' => true,
    //             'original_price' => null,
    //             'loyalty_discount' => null,
    //             'voucher_discount' => null,
    //             'final_price' => null
    //         ]);

    //         // 2. Pending Bookings (future bookings)
    //         TableBooking::create([
    //             'user_id' => $users->random()->id,
    //             'table_id' => $table->id,
    //             'booking_time' => Carbon::tomorrow()->setHour(14),
    //             'booking_type' => '3-hour-package',
    //             'duration' => 180, // 3 hours in minutes
    //             'status' => 'pending',
    //             'is_active' => false,
    //             'original_price' => $table->price * 3,
    //             'loyalty_discount' => ($table->price * 3) * 0.1, // Example 10% loyalty discount
    //             'final_price' => ($table->price * 3) * 0.9
    //         ]);

    //         // 3. Completed Bookings (past bookings)
    //         for ($i = 1; $i <= 3; $i++) {
    //             $startTime = Carbon::now()->subDays($i)->setHour(13);
    //             $duration = rand(120, 240); // Random duration between 2-4 hours
    //             $originalPrice = ($duration / 60) * $table->price;
    //             $loyaltyDiscount = $originalPrice * 0.05; // Example 5% loyalty discount
    //             $voucherDiscount = rand(0, 1) ? $originalPrice * 0.1 : 0; // Random voucher discount

    //             TableBooking::create([
    //                 'user_id' => $users->random()->id,
    //                 'table_id' => $table->id,
    //                 'booking_time' => $startTime,
    //                 'booking_type' => rand(0, 1) ? '3-hour-package' : 'open',
    //                 'started_at' => $startTime,
    //                 'end_time' => $startTime->copy()->addMinutes($duration),
    //                 'duration' => $duration,
    //                 'final_duration' => $duration,
    //                 'status' => 'completed',
    //                 'is_active' => false,
    //                 'original_price' => $originalPrice,
    //                 'loyalty_discount' => $loyaltyDiscount,
    //                 'voucher_discount' => $voucherDiscount,
    //                 'final_price' => $originalPrice - $loyaltyDiscount - $voucherDiscount
    //             ]);
    //         }

    //         // 4. Cancelled Bookings
    //         TableBooking::create([
    //             'user_id' => $users->random()->id,
    //             'table_id' => $table->id,
    //             'booking_time' => Carbon::yesterday()->setHour(15),
    //             'booking_type' => rand(0, 1) ? '3-hour-package' : 'open',
    //             'duration' => 180,
    //             'status' => 'cancelled',
    //             'is_active' => false,
    //             'original_price' => null,
    //             'loyalty_discount' => null,
    //             'voucher_discount' => null,
    //             'final_price' => null
    //         ]);

    //         // Another cancelled booking but after session started
    //         $startTime = Carbon::yesterday()->setHour(18);
    //         $duration = 45; // Cancelled after 45 minutes
    //         $originalPrice = ($duration / 60) * $table->price;

    //         TableBooking::create([
    //             'user_id' => $users->random()->id,
    //             'table_id' => $table->id,
    //             'booking_time' => $startTime,
    //             'booking_type' => 'open',
    //             'started_at' => $startTime,
    //             'end_time' => $startTime->copy()->addMinutes($duration),
    //             'duration' => $duration,
    //             'final_duration' => $duration,
    //             'status' => 'cancelled',
    //             'is_active' => false,
    //             'original_price' => $originalPrice,
    //             'loyalty_discount' => $originalPrice * 0.05,
    //             'voucher_discount' => 0,
    //             'final_price' => $originalPrice * 0.95
    //         ]);
    //     }
    // }

    public function run()
    {
        $tables = Table::where('status', '!=', 'Closed')->get();
        $users = User::where('role_id', 2)->get(); // Get only member users

        if ($tables->isEmpty() || $users->isEmpty()) {
            $this->command->info('Please seed tables and users first!');
            return;
        }

        foreach ($tables as $table) {
            // 1. Active Booking (Currently in use)
            TableBooking::create([
                'user_id' => $users->random()->id,
                'table_id' => $table->id,
                'booking_time' => Carbon::now()->subHours(2),
                'booking_type' => 'open',
                'started_at' => Carbon::now()->subHours(2),
                'status' => 'active',
                'is_active' => true,
                'original_price' => null,
                'loyalty_discount' => null,
                'voucher_discount' => null,
                'final_price' => null
            ]);

            // 2. Pending Bookings (Future)
            TableBooking::create([
                'user_id' => $users->random()->id,
                'table_id' => $table->id,
                'booking_time' => Carbon::tomorrow()->setHour(rand(11, 16)), // Between 11 AM and 4 PM
                'booking_type' => '3-hour-package',
                'duration' => 180,
                'status' => 'pending',
                'is_active' => false,
                'original_price' => $table->price * 3,
                'loyalty_discount' => ($table->price * 3) * 0.1,
                'final_price' => ($table->price * 3) * 0.9
            ]);

            // 3. Completed Bookings (Past)
            for ($i = 1; $i <= 3; $i++) {
                $startTime = Carbon::now()->subDays($i)->setHour(rand(12, 18)); // Between 12 PM and 6 PM
                $duration = rand(120, 240); // Random duration between 2-4 hours
                $originalPrice = ($duration / 60) * $table->price;
                $loyaltyDiscount = $originalPrice * 0.05;
                $voucherDiscount = rand(0, 1) ? $originalPrice * 0.1 : 0;

                TableBooking::create([
                    'user_id' => $users->random()->id,
                    'table_id' => $table->id,
                    'booking_time' => $startTime,
                    'booking_type' => rand(0, 1) ? '3-hour-package' : 'open',
                    'started_at' => $startTime,
                    'end_time' => $startTime->copy()->addMinutes($duration),
                    'duration' => $duration,
                    'final_duration' => $duration,
                    'status' => 'completed',
                    'is_active' => false,
                    'original_price' => $originalPrice,
                    'loyalty_discount' => $loyaltyDiscount,
                    'voucher_discount' => $voucherDiscount,
                    'final_price' => $originalPrice - $loyaltyDiscount - $voucherDiscount
                ]);
            }

            // 4. Cancelled Bookings
            TableBooking::create([
                'user_id' => $users->random()->id,
                'table_id' => $table->id,
                'booking_time' => Carbon::yesterday()->setHour(rand(14, 18)), // Between 2 PM and 6 PM
                'booking_type' => 'open',
                'duration' => rand(60, 180),
                'status' => 'cancelled',
                'is_active' => false,
                'original_price' => null,
                'loyalty_discount' => null,
                'voucher_discount' => null,
                'final_price' => null
            ]);
        }
    }
}
