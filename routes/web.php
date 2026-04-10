<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('pages.home');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Pages
Route::get('/explore', [PackageController::class, 'explore'])->name('explore');

Route::get('/book', [BookingController::class, 'create'])->name('book');
Route::get('/book/details/{package}', [BookingController::class, 'details'])->name('book.details');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/api/blocked-dates', [BookingController::class, 'getBlockedDates'])->name('api.blocked-dates');

Route::get('/manage', function () {
    return view('pages.manage');
})->name('manage');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

// Manage Booking
Route::get('/manage-booking', [ManageBookingController::class, 'index'])->name('manage.index');
Route::post('/manage-booking/results', [ManageBookingController::class, 'search'])->name('manage.search');

// Package Actions for Admin
Route::middleware('auth')->group(function () {
    Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
});

// Gallery Routes for Admin
Route::middleware('auth')->group(function () {
    Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::post('/galleries/{gallery}/image', [GalleryController::class, 'addImage'])->name('galleries.addImage');
    Route::delete('/gallery-image/{image}', [GalleryController::class, 'deleteImage'])->name('galleries.deleteImage');
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');
});

// Manage Booking - Authenticated Customer
Route::middleware('auth')->group(function () {
    Route::patch('/manage-booking/{booking}/cancel', [ManageBookingController::class, 'cancel'])->name('manage.cancel');
    Route::get('/manage-booking/{booking}/edit', [ManageBookingController::class, 'edit'])->name('manage.edit');
    Route::put('/manage-booking/{booking}/update', [ManageBookingController::class, 'update'])->name('manage.update');
});

// Manage Booking - Admin Only
Route::middleware(['auth', 'role'])->group(function () {
    Route::patch('/manage-booking/{booking}/approve', [ManageBookingController::class, 'approve'])->name('manage.approve');
    Route::patch('/manage-booking/{booking}/status', [ManageBookingController::class, 'changeStatus'])->name('manage.status');
    Route::delete('/manage-booking/{booking}', [ManageBookingController::class, 'destroy'])->name('manage.destroy');
});