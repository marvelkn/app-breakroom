<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        $user = Auth::user();

        DB::beginTransaction();

        try {
            $otp = OtpCode::where('user_id', $user->id)
                ->where('code', $request->otp)
                ->where('is_used', false)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$otp) {
                return back()->withErrors(['otp' => 'Invalid or expired OTP']);
            }

            // Mark OTP as used
            $otp->update(['is_used' => true]);

            // Mark email as verified
            User::where('id', $user->id)->update([
                'email_verified_at' => Carbon::now()
            ]);

            DB::commit();

            // Log the user out
            Auth::logout();

            // Redirect to login with success message
            return redirect()->route('login')
                ->with('success', 'Email verified successfully. Please login to continue.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Verification failed. Please try again.']);
        }
    }

    public function resend()
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        DB::beginTransaction();

        try {
            // Generate new OTP
            $otp = sprintf("%06d", mt_rand(1, 999999));

            // Store new OTP
            OtpCode::create([
                'user_id' => $user->id,
                'code' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            // Send new OTP Email
            Mail::send('emails.verification', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Email Verification OTP');
            });

            DB::commit();

            return back()->with('success', 'New verification code sent!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to send verification code. Please try again.']);
        }
    }
}