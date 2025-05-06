<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check user role for redirection
            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.index'); // Changed from admin.dashboard to admin.index
            }
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate verification code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Default role as member
            'verification_code' => $verificationCode
        ]);

        // Store OTP
        OtpCode::create([
            'user_id' => $user->id,
            'code' => $verificationCode,
            'expires_at' => Carbon::now()->addMinutes(10),
            'is_used' => false  // Add this since your table has is_used column
        ]);

        // Send verification email with the code
        Mail::to($user->email)->send(new VerificationMail($verificationCode));
        
        return redirect()->route('otp.verify')
            ->with('success', 'Please check your email for verification code');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function verify(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|string|min:6|max:6'
            ]);

            // Log the received OTP and current time
            Log::info('Verification attempt:', [
                'input_otp' => $request->otp,
                'current_time' => Carbon::now()
            ]);

            // Get the latest unverified user with this OTP code
            $otpCode = OtpCode::where('code', $request->otp)
                ->where('expires_at', '>', Carbon::now())
                ->where('is_used', false)
                ->first();

            // Log the found OTP record
            Log::info('Found OTP record:', [
                'otpCode' => $otpCode ? $otpCode->toArray() : 'null'
            ]);

            if ($otpCode) {
                $user = User::find($otpCode->user_id);

                // Log user info
                Log::info('Found user:', [
                    'user' => $user ? $user->toArray() : 'null'
                ]);

                if ($user) {
                    $user->email_verified_at = now();
                    $user->save();

                    // Mark OTP as used
                    $otpCode->is_used = true;
                    $otpCode->save();

                    // Log the user in
                    Auth::login($user);

                    return redirect()->intended('/dashboard')
                        ->with('success', 'Email verified successfully');
                }
            }

            Log::warning('Verification failed - no matching OTP found');
            return back()->with('error', 'Verification failed. Please try again.');
        } catch (\Exception $e) {
            Log::error('Verification error: ' . $e->getMessage());
            return back()->with('error', 'Verification failed. Please try again.' . $e->getMessage());
        }
    }

    public function resendVerification(Request $request)
    {
        try {
            $email = $request->email ?? Auth::user()?->email;

            if (!$email) {
                return back()->with('error', 'Email address not found.');
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            // Delete any existing OTP
            OtpCode::where('user_id', $user->id)->delete();

            // Generate new verification code
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store new OTP
            OtpCode::create([
                'user_id' => $user->id,
                'code' => $verificationCode,
                'expires_at' => Carbon::now()->addMinutes(10),
                'is_used' => false
            ]);

            // Send new verification email
            Mail::to($user->email)->send(new VerificationMail($verificationCode));

            return back()->with('success', 'New verification code has been sent to your email.');
        } catch (\Exception $e) {
            Log::error('Resend verification error: ' . $e->getMessage());
            return back()->with('error', 'Failed to resend verification code.');
        }
    }
    public function showVerificationForm()
    {
        return view('auth.verify');
    }
}