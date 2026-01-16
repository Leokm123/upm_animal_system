<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalProfileController; // 引入动物档案控制器
use App\Http\Controllers\SightingController; // 引入目击控制器

Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// ====== 动物目击模块路由 ======
Route::get('/sighting/report', [SightingController::class, 'create'])->name('sighting.create');
Route::post('/sighting/report', [SightingController::class, 'reportSighting'])->name('sighting.report');
Route::get('/sightings', [SightingController::class, 'index'])->name('sighting.index');

// ====== 动物档案模块路由 ======
Route::post('/animal/match', [AnimalProfileController::class, 'matchProfiles'])->name('animal.match');
Route::get('/animal/create', function () {
    return view('animal.create');
})->name('animal.create')->middleware('auth.any');
Route::post('/animal/store', [AnimalProfileController::class, 'createProfile'])->name('animal.store');
Route::get('/animal/{animalId}', [AnimalProfileController::class, 'show'])->name('animal.show');
Route::get('/animal/{animalId}/edit', function ($animalId) {
    $animal = App\Models\Animal::findOrFail($animalId);
    return view('animal.edit', compact('animal'));
})->name('animal.edit')->middleware('auth.any');
Route::post('/animal/{animalId}/update', [AnimalProfileController::class, 'updateProfile'])->name('animal.update');