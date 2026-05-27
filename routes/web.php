<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Owner;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{slug}', [FieldController::class, 'show'])->name('fields.show');
// Lightweight JSON polling endpoint — no auth required, cached 60s server-side
Route::get('/fields/{slug}/slot-status', [FieldController::class, 'slotStatus'])->name('fields.slot-status');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard redirect by role
    Route::get('/dashboard', function () {
        return match(auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            default => redirect()->route('fields.index'),
        };
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // OTP Ganti Password
    Route::post('/profile/password/request-otp', [PasswordChangeController::class, 'requestOtp'])->name('password.change.request');
    Route::get('/profile/password/verify', [PasswordChangeController::class, 'showVerifyForm'])->name('password.change.verify');
    Route::post('/profile/password/verify', [PasswordChangeController::class, 'verifyOtp'])->name('password.change.verify.submit')->middleware('throttle:5,1');
    Route::post('/profile/password/resend-otp', [PasswordChangeController::class, 'resendOtp'])->name('password.change.resend-otp')->middleware('throttle:3,5');
    Route::get('/profile/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/profile/password/change', [PasswordChangeController::class, 'update'])->name('password.change.update');

    // Bookings (user-facing)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Payment — generate snap token & finish redirect
    Route::post('/payment/{booking}/snap-token', [PaymentController::class, 'getSnapToken'])->name('payment.snap-token');
    Route::get('/payment/{booking}/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check-status');
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});

// Midtrans webhook — TANPA auth, TANPA CSRF (dikecualikan di bootstrap/app.php)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner,admin'])->prefix('owner')->name('owner.')->group(function () {

    Route::get('/dashboard', [Owner\DashboardController::class, 'index'])->name('dashboard');

    // Fields CRUD
    Route::resource('fields', Owner\FieldController::class);

    // Schedules
    Route::get('/fields/{field}/schedules', [Owner\ScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/fields/{field}/schedules', [Owner\ScheduleController::class, 'store'])->name('schedules.store');
    Route::patch('/schedules/{schedule}/status', [Owner\ScheduleController::class, 'updateStatus'])->name('schedules.update-status');

    // Bookings management
    Route::get('/bookings', [Owner\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/confirm', [Owner\BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [Owner\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/complete', [Owner\BookingController::class, 'complete'])->name('bookings.complete');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // User management
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [Admin\UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Bookings overview
    Route::get('/bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
});

require __DIR__.'/auth.php';

