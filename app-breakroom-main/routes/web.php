<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TableBookingController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodAndDrinkController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\LoyaltyProgramController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

// Base Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
// Route::middleware('auth')->group(function () {
//     Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
//     Route::post('/email/verify', [VerificationController::class, 'verify'])->name('verification.verify');
//     Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])
        ->name('verification.resend');
});
// Route::get('/otp/verify', [VerificationController::class, 'notice'])->name('otp.verify');
// Route::post('/otp/verify', [VerificationController::class, 'verify'])->name('otp.verify.post');

Route::get('/otp/verify', [AuthController::class, 'showVerificationForm'])->name('otp.verify');
Route::post('/otp/verify', [AuthController::class, 'verify'])->name('otp.verify.post');
Route::post('/email/resend', [AuthController::class, 'resendVerification'])->name('verification.resend');

Route::middleware(['web'])->group(function () {
    // Public routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Users
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // Tables
    Route::get('/tables', [UserController::class, 'tables'])->name('tables');
    Route::get('/tables/book/{table_id}', [UserController::class, 'bookTablesView'])->name('tables.bookView');
    Route::post('/tables/book/{table_id}', [UserController::class, 'bookTables'])->name('tables.book');
    Route::get('/tables/active-sessions', [TableBookingController::class, 'getActiveSessions'])
        ->name('tables.active-sessions');

    // EVENTS
    Route::get('/events', [EventController::class, 'index'])->name('event.index');
    Route::get('/events/{event_id}', [EventController::class, 'details'])->name('event.details');
    Route::post('/events/{event_id}/register', [EventController::class, 'register'])->name('event.register');
    Route::post('/events/{event_id}/cancel', [EventController::class, 'cancel'])->name('event.cancel');

    //Loyyalty
    Route::get('/loyalty_program', [UserController::class, 'loyaltyProgramIndex'])->name('loyalty_program.index');
    Route::post('/loyalty/redeem-voucher/{voucher}', [LoyaltyProgramController::class, 'redeemVoucher'])
        ->name('loyalty.redeem-voucher');
    // Resource Routes
});

// Route::resource('tables', TableController::class);
// Route::resource('table-bookings', TableBookingController::class);


// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Tables
        Route::get('/table/create_table', [AdminController::class, 'create_table']);
        Route::post('/table/create_table', [TableController::class, 'store']);
        Route::get('/tables', [TableController::class, 'index'])->name('table.index');
        Route::get('/table/{id}', [TableController::class, 'show'])->name('table.show');
        Route::get('/table/{id}/edit', [TableController::class, 'edit'])->name('table.edit');
        Route::get('/table/{id}/change_image', [TableController::class, 'changeImage'])->name('table.changeImage');
        Route::put('/table/{id}', [TableController::class, 'update'])->name('table.update');
        Route::put('/table/{id}/status', [TableController::class, 'updateStatus'])->name('table.updateStatus');
        Route::put('/table/{id}/change_image', [TableController::class, 'updateImage'])->name('table.updateImage');
        Route::delete('/table/{id}', [TableController::class, 'destroy'])->name('table.destroy');
        Route::get('/tables/status', [TableController::class, 'status'])->name('admin.tables.status');
        Route::put('/tables/{table}/update-status', [TableController::class, 'updateStatus'])->name('admin.tables.update-status');

        // Table Bookings
        Route::get('/bookings', [TableBookingController::class, 'adminIndex'])->name('booking.index');
        Route::post('/bookings/{booking}/start', [TableBookingController::class, 'startSession'])
            ->name('bookings.start-session');
        Route::post('/bookings/{booking}/end', [TableBookingController::class, 'endSession'])
            ->name('bookings.end-session');
        Route::get('/booking/{id}/finish', [TableBookingController::class, 'finish'])->name('booking.finish');
        Route::get('/booking/{id}/cancel', [TableBookingController::class, 'cancel'])->name('booking.cancel');
        Route::post('/bookings/{id}/cancel', [TableBookingController::class, 'cancel'])
            ->name('bookings.cancel');
        Route::get('/bookings/prices', [TableBookingController::class, 'getUpdatedPrices'])
            ->name('bookings.prices');
        Route::get('/bookings/durations', [TableBookingController::class, 'getUpdatedDurations'])
            ->name('bookings.durations');


        // Events
        Route::get('/events', [EventController::class, 'adminIndex'])->name('event.adminIndex');
        Route::get('/event/create_event', [AdminController::class, 'create_event'])->name('event.create');
        Route::post('/event/create_event', [EventController::class, 'store'])->name('event.store');
        Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
        Route::put('/event/{id}/status', [EventController::class, 'updateStatus'])->name('event.updateStatus');
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
        Route::get('/event/{id}/change_image', [EventController::class, 'changeImage'])->name('event.changeImage');
        Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');
        Route::put('/event/{id}/change_image', [EventController::class, 'updateImage'])->name('event.updateImage');
        Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('event.destroy');
        Route::get('/events/manage', [EventController::class, 'manage'])->name('admin.events.manage');

        // Products
        Route::get('/product/create_product', [AdminController::class, 'create_product'])->name('product.create');
        Route::post('/product/create_product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/products', [ProductController::class, 'adminIndex'])->name('product.adminIndex');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('/product/{id}/change_image', [ProductController::class, 'changeImage'])->name('product.changeImage');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::put('/product/{id}/status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');
        Route::put('/product/{id}/change_image', [ProductController::class, 'updateImage'])->name('product.updateImage');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::get('/products/manage', [ProductController::class, 'manage'])->name('admin.products.manage');

        // Foods
        Route::get('/food/create_food', [AdminController::class, 'create_food'])->name('food.create');
        Route::post('/food/create_food', [FoodAndDrinkController::class, 'store'])->name('food.store');
        Route::get('/foods', [FoodAndDrinkController::class, 'adminIndex'])->name('food.adminIndex');
        Route::get('/food/{id}', [FoodAndDrinkController::class, 'show'])->name('food.show');
        Route::get('/food/{id}/edit', [FoodAndDrinkController::class, 'edit'])->name('food.edit');
        Route::get('/food/{id}/change_image', [FoodAndDrinkController::class, 'changeImage'])->name('food.changeImage');
        Route::put('/food/{id}', [FoodAndDrinkController::class, 'update'])->name('food.update');
        Route::put('/food/{id}/status', [FoodAndDrinkController::class, 'updateStatus'])->name('food.updateStatus');
        Route::put('/food/{id}/change_image', [FoodAndDrinkController::class, 'updateImage'])->name('food.updateImage');
        Route::delete('/food/{id}', [FoodAndDrinkController::class, 'destroy'])->name('food.destroy');
        Route::get('/food-and-drinks/manage', [FoodAndDrinkController::class, 'manage'])->name('admin.food-and-drinks.manage');

        // User Management
        Route::get('/users', [AdminController::class, 'usersList'])->name('users.adminIndex');
        Route::get('/users/create_account', [AdminController::class, 'createAccount'])->name('users.create');
        Route::post('/users/create_account', [AdminController::class, 'storeAccount'])->name('users.store');
        Route::get('/users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');

        // Waiting List
        Route::get('/waiting-list/manage', [WaitingListController::class, 'manage'])->name('admin.waiting-list.manage');

        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
        // Route::get('/users', [AdminController::class, 'usersList'])->name('users');
        Route::post('/users/{id}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
        Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');

        // Route::post('/users/create-admin', [AdminController::class, 'createAdmin'])->name('users.create-admin');

        // VOUCHERS
        Route::get('/vouchers', [VoucherController::class, 'adminIndex'])->name('voucher.adminIndex');
        Route::get('/voucher/create_voucher', [VoucherController::class, 'create_voucher'])->name('voucher.create');
        Route::post('/voucher/create_voucher', [VoucherController::class, 'store'])->name('voucher.store');
        Route::put('/voucher/{id}/status', [VoucherController::class, 'updateStatus'])
            ->name('voucher.updateStatus');
        Route::get('/voucher/{id}/edit', [VoucherController::class, 'edit'])->name('voucher.edit');
        Route::put('/voucher/{id}', [VoucherController::class, 'update'])->name('voucher.update');
    });
});


// User Routes
Route::middleware(['auth'])->group(function () {
    // Profile
    //Already Done Above
    // Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Food & Drinks
    Route::get('/food-and-drinks', [FoodAndDrinkController::class, 'index'])->name('food-and-drinks.index');
    Route::post('/food-and-drinks/order', [FoodAndDrinkController::class, 'order'])->name('food-and-drinks.order');
    Route::get('/food-drinks/{id}', [FoodAndDrinkController::class, 'details'])->name('food-drinks.details');

    // Waiting List
    Route::get('/waiting-list', [WaitingListController::class, 'index'])->name('waiting-list.index');
    Route::post('/waiting-list/join', [WaitingListController::class, 'join'])->name('waiting-list.join');

    // Loyalty Program
    Route::get('/loyalty-program', [LoyaltyProgramController::class, 'index'])->name('loyalty-program.index');

    // Bookings
    Route::get('/booking-history', [BookingController::class, 'history'])->name('booking-history.index');
    Route::get('/products/{id}', [ProductController::class, 'details'])->name('products.details');
    Route::post('/product/order', [ProductController::class, 'order'])->name('products.order');
    Route::get('/booking/slots/{table_id}/{date}', [TableBookingController::class, 'getAvailableSlots'])
        ->name('booking.slots');
});

// Public Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'details'])->name('products.details');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/bookings/check', [BookingController::class, 'checkAvailability'])->name('bookings.check');
Route::post('/bookings', [BookingController::class, 'book'])->name('bookings.book');
Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');

// Route::get('/events', [EventController::class, 'index'])->name('event.index');
// Route::get('/events/{id}', [EventController::class, 'details'])->name('event.details');
// Route::post('/events/{event}/register', [EventController::class, 'register'])->name('event.register');
