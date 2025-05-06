<?php

namespace App\Http\Controllers;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\PointTransaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoyaltyProgramController extends Controller
{
    //
    public function redeemVoucher(Voucher $voucher)
    {
        $user = auth()->user();

        // Check if user has enough points
        if ($user->loyalty_points < $voucher->points_required) {
            return back()->with('error', 'Insufficient points to redeem this voucher');
        }

        // Check if voucher is still active
        if (!$voucher->is_active) {
            return back()->with('error', 'This voucher is no longer available');
        }

        // Check stock
        if ($voucher->stock !== -1 && $voucher->stock <= 0) {
            return back()->with('error', 'This voucher is out of stock');
        }

        try {
            DB::transaction(function () use ($user, $voucher) {
                // Generate unique code
                $code = strtoupper(uniqid() . Str::random(4));

                // Create user voucher
                UserVoucher::create([
                    'user_id' => $user->id,
                    'voucher_id' => $voucher->id,
                    'code' => $code,
                    'purchased_at' => now(),
                    'expires_at' => now()->addDays($voucher->validity_days),
                ]);

                // Deduct points from user
                $user->loyalty_points -= $voucher->points_required;
                $user->save();

                // Record points transaction
                PointTransaction::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'redeem',
                    'points' => -$voucher->points_required,
                    'reference_type' => 'voucher_redemption',
                    'reference_id' => $voucher->id,
                    'description' => "Redeemed voucher: {$voucher->name}"
                ]);

                // Update voucher stock if not unlimited
                if ($voucher->stock !== -1) {
                    $voucher->decrement('stock');
                }
            });

            return back()->with('success', 'Voucher redeemed successfully! Check your vouchers section to see the code.');

        } catch (\Exception $e) {
            \Log::error('Voucher redemption failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to redeem voucher. Please try again later.');
        }
    }
}
