<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mail\PasswordResetMail;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // In the new migration file
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('bio')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'address', 'birth_date', 'bio']);
        });
    }

    // In AdminController.php - Add these methods
    public function usersList()
    {
        $users = User::where('role_id', '!=', 1)->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(10);

        $user->password = Hash::make($newPassword);
        $user->save();

        // Send email with new password
        Mail::to($user->email)->send(new PasswordResetMail($newPassword));

        return redirect()->back()->with('success', 'Password has been reset and sent to user\'s email.');
    }

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'bio' => 'nullable|string'
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->birth_date = $request->birth_date;
        $user->bio = $request->bio;

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::delete('public/' . $user->photo);
            }

            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
};
