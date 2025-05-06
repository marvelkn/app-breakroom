<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.profile.profile', compact('user')); // Changed from profile.index to user.profile
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Update user information
        $user->name = $request->name;

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // if ($user->photo) {
            //     Storage::disk('public')->delete($user->photo); // Delete old photo if exists
            // }
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }
}
