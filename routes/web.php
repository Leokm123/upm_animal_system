<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Login submit
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Dashboard: allow all three guards
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth:web,manager,volunteer');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web,manager,volunteer');