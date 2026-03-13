<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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