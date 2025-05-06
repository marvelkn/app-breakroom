<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Voucher;
use App\Models\LoyaltyTier;
use App\Models\UserVoucher;
use App\Models\TableBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $tables = Table::take(3)->get();
        return view('user.dashboard', compact('tables'));
    }

    public function profile()
    {
        $user = auth()->user();

        // Pass the $user variable to the 'user.profile.profile' view
        return view('user.profile.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'current_password' => 'required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->password && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->fill($request->only([
            'name',
            'email',
            'phone_number',
            'address',
            'birth_date',
            'bio'
        ]));

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $directory = 'photos/profiles';
            $filename = time() . '.' . $request->file('photo')->getClientOriginalExtension();

            $path = $request->file('photo')->storeAs($directory, $filename, 'public');

            $user->photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    public function tables()
    {
        $tables = Table::with('activeBooking')->orderBy('price', 'desc')->get();
        foreach ($tables as $table) {
            $table->image_url = Storage::url($table->image);
        }
        return view('user.tables.index', ['tables' => $tables]);
    }

    public function bookTablesView(Request $request, $table_id)
    {
        $table = Table::findOrFail($table_id);
        $user = auth()->user();
        $loyaltyTier = LoyaltyTier::where('name', $user->loyalty_tier)->first();
        $applicableVouchers = UserVoucher::where('user_id', $user->id)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->whereHas('voucher', function ($query) {
                $query->where('voucher_type', 'table_discount')
                    ->where('is_active', true);
            })
            ->with('voucher')
            ->get();

        return view('user.tables.booking', [
            'table' => $table,
            'loyaltyTier' => $loyaltyTier,
            'applicableVouchers' => $applicableVouchers
        ]);
    }


    public function bookTables(Request $request, $table_id)
    {
        $request->validate([
            'datetime' => 'required|date|after:+1 hour',
            'duration' => 'required',
            'voucher_id' => 'nullable|exists:user_vouchers,id'
        ]);

        try {
            $table = Table::findOrFail($table_id);
            $user = Auth::user();
            $userVoucher = null;

            // Calculate original price
            $duration = intval($request->duration); // Duration in minutes
            $originalPrice = ($duration / 60) * $table->price;

            // Get loyalty discount
            $loyaltyDiscount = 0;
            $loyaltyTier = LoyaltyTier::where('name', $user->loyalty_tier)->first();
            if ($loyaltyTier && $loyaltyTier->table_discount_percentage > 0) {
                $loyaltyDiscount = floor(($originalPrice * $loyaltyTier->table_discount_percentage) / 100);
            }

            // Get voucher discount if provided
            $voucherDiscount = 0;
            if ($request->voucher_id) {
                $userVoucher = UserVoucher::with('voucher')
                    ->where('id', $request->voucher_id)
                    ->where('user_id', $user->id)
                    ->where('is_used', false)
                    ->where('expires_at', '>', now())
                    ->firstOrFail();

                if ($userVoucher->voucher->discount_type === 'percentage') {
                    $voucherDiscount = floor(($originalPrice * $userVoucher->voucher->discount_value) / 100);
                    if ($userVoucher->voucher->max_discount) {
                        $voucherDiscount = min($voucherDiscount, $userVoucher->voucher->max_discount);
                    }
                } else {
                    $voucherDiscount = $userVoucher->voucher->discount_value;
                }
            }

            // Calculate final price
            $finalPrice = $originalPrice - $loyaltyDiscount - $voucherDiscount;

            DB::transaction(function () use ($user, $table, $request, $duration, $originalPrice, $loyaltyDiscount, $voucherDiscount, $finalPrice, $userVoucher) {
                // Create booking
                $booking = TableBooking::create([
                    'user_id' => $user->id,
                    'table_id' => $table->id,
                    'booking_type' => $request->duration,
                    'booking_time' => $request->datetime,
                    'duration' => $duration,
                    'original_price' => $originalPrice,
                    'loyalty_discount' => $loyaltyDiscount,
                    'voucher_discount' => $voucherDiscount,
                    'final_price' => $finalPrice,
                    'used_voucher_id' => $userVoucher ? $userVoucher->id : null,
                    'status' => 'pending'
                ]);

                // 'duration' => $request->input('open-duration'),

                // Mark voucher as used if one was applied
                if ($userVoucher) {
                    $userVoucher->is_used = true;
                    $userVoucher->used_at = now();
                    $userVoucher->save();
                }
            });

            return redirect()->route('user.tables')
                ->with('success', sprintf(
                    'Successfully booked Table %d for %d hour%s!',
                    $table->number,
                    $duration / 60,
                    $duration / 60 > 1 ? 's' : ''
                ));
        } catch (\Exception $e) {
            Log::error('Error booking table: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to book table. Please try again.');
        }
    }

    public function loyaltyProgramIndex()
    {
        //
        $user = auth()->user();
        $vouchers = Voucher::where('is_active', true)
            ->where(function ($query) {
                $query->where('stock', '>', 0)
                    ->orWhere('stock', -1);
            })
            ->orderByRaw('CASE 
                    WHEN points_required <= ? THEN 0 
                    ELSE 1 
                    END', [$user->loyalty_points])  // First sort by affordability
            ->orderBy('points_required', 'asc')  // Then sort by points needed (lowest first)
            ->get();
        $userVouchers = UserVoucher::where('user_id', $user->id)
            ->with('voucher')
            ->orderBy('expires_at', 'desc')
            ->get();
        return view('user.loyalty.index', compact('user', 'vouchers', 'userVouchers'));
    }
}
