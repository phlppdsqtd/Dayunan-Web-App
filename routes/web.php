<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\PackageController;

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

Route::get('/book', function () {
    return view('pages.book');
})->name('book');

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