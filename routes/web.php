<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;

Route::get('/', function () { return view('pages.home'); });

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout']);

// Placeholder Pages (Pointing to the pages folder)
Route::get('/explore', function () { return view('pages.explore'); });
Route::get('/book', function () { return view('pages.book'); });
Route::get('/manage', function () { return view('pages.manage'); });
Route::get('/contact', function () { return view('pages.contact'); });

// Route to see the page CONTACT
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

use App\Http\Controllers\ManageBookingController;

Route::get('/manage-booking', [ManageBookingController::class, 'index'])->name('manage.index');
Route::post('/manage-booking/results', [ManageBookingController::class, 'search'])->name('manage.search');

