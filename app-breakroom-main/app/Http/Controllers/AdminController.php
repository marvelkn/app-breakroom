<?php

namespace App\Http\Controllers;

use App\Models\FoodAndDrink;
use App\Models\Table;
use App\Models\Event;
use App\Models\Product;
use App\Models\TableBooking;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\PasswordResetMail;

class AdminController extends Controller
{
    public function index()
    {
        // Your existing index method remains the same
        $allTables = Table::orderBy('capacity', 'desc')->get();
        $tables = Table::orderBy('capacity', 'desc')->take(3)->get();
        foreach ($tables as $table) {
            $table->image_url = Storage::url($table->image);
        }
        $allEvents = Event::orderBy('date', 'asc')->get();
        $events = Event::orderBy('date', 'asc')->take(2)->get();
        foreach ($events as $event) {
            $event->image_url = Storage::url($event->image);
        }
        $allProducts = Product::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->take(3)->get();
        foreach ($products as $product) {
            $product->image_url = Storage::url($product->image);
        }
        $allFoods = FoodAndDrink::orderBy('name', 'asc')->get();
        $foods = FoodAndDrink::orderBy('name', 'asc')->take(3)->get();
        foreach ($foods as $food) {
            $food->image_url = Storage::url($food->image);
        }
        $allUsers = User::where('id', '!=', auth()->id())
                        ->orderBy('created_at', 'desc')->get();
        $users = User::where('id', '!=', auth()->id())
                        ->orderBy('created_at', 'desc')->take(3)->get();
        foreach ($users as $user) {
            $user->image_url = Storage::url($user->image);
        }
        $bookings = TableBooking::where('status', 'active')->get();
        $vouchers = Voucher::orderBy('id', 'asc')->get();
        return view('admin.index', [
            'tables' => $tables,
            'events' => $events,
            'products' => $products,
            'foods' => $foods,
            'users' => $users,
            'bookings' => $bookings,
            'vouchers' => $vouchers,
            'allTables' => $allTables,
            'allEvents' => $allEvents,
            'allProducts' => $allProducts,
            'allFoods' => $allFoods,
            'allUsers' => $allUsers
        ]);
    }

    public function dashboard()
    {
        // Redirect to index since that's where your main admin view is
        return redirect()->route('admin.index');
    }

    public function create_table()
    {
        return view('admin.table.create_table');
    }

    public function create_event()
    {
        return view('admin.event.create_event');
    }

    public function create_product()
    {
        return view('admin.product.create_product');
    }

    public function create_food()
    {
        return view('admin.food.create_food');
    }

    // New methods for profile management
    public function profile()
    {
        return view('admin.profile.index');
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
            $directory = 'photos';
            $filename = time() . '.' . $request->file('photo')->getClientOriginalExtension();
        
            $path = $request->file('photo')->storeAs($directory, $filename, 'public');
        
            $user->photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    // New methods for user management
    public function usersList()
    {
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        foreach ($users as $user) {
            if ($user->photo) {
                $user->photo_url = Storage::url($user->photo);
            }
        }

        return view('admin.users.users', compact('users'));
    }

    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);

        // Generate a random password
        $newPassword = Str::random(10);

        // Update user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Send email with new password
        Mail::to($user->email)->send(new PasswordResetMail($newPassword));

        return back()->with('success', 'Password has been reset and sent to user\'s email.');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        // Don't allow toggling other admin accounts
        if ($user->role_id == 1) {
            return back()->with('error', 'Cannot modify admin accounts.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User has been {$status} successfully.");
    }

    public function createAccount(Request $request)
    {
        return view('admin.users.create_account');
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $account = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'email_verified_at' => now(),
        ]);
        return redirect()->route('admin.users.adminIndex')
        ->with('success', 'Account successfully made!');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1, // Admin role
            'email_verified_at' => now(), // Auto verify the admin
        ]);

        return redirect()->back()->with('success', 'Admin account created successfully');
    }
}