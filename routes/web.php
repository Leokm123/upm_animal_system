<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Import login controller

// 1. Login page: Access http://localhost/upm-animal-system/public/login to display login page
Route::get('/login', function () {
    return view('auth.login'); // Corresponds to resources/views/auth/login.blade.php
})->name('login'); // Name the route as login

// 2. Login submission: Accept POST request from login form, call AuthController's login method
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Named as login.submit

// 3. Dashboard: Must be logged in to access, will redirect to login page if not authenticated
Route::get('/dashboard', function () {
    return view('dashboard'); // Corresponds to resources/views/dashboard.blade.php
})->name('dashboard')->middleware('auth'); // middleware('auth'): Verify login status

// 4. Logout: Must be logged in to access, call AuthController's logout method
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');