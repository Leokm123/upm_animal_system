<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

use App\Http\Controllers\AnimalProfileController; // 引入动物档案控制器
use App\Http\Controllers\SightingController; // 引入目击控制器

// 之前的Login/登出/仪表盘路由保持不变...

// ====== 动物目击模块路由 ======
// 1. 显示上报目击表单
Route::get('/sighting/report', [SightingController::class, 'create'])->name('sighting.create');
// 2. 提交目击记录
Route::post('/sighting/report', [SightingController::class, 'reportSighting'])->name('sighting.report');
// 3. 查看志愿者的目击记录列表
Route::get('/sightings', [SightingController::class, 'index'])->name('sighting.index');

// ====== 动物档案模块路由 ======
// 1. 档案匹配（AJAX接口，无需视图）
Route::post('/animal/match', [AnimalProfileController::class, 'matchProfiles'])->name('animal.match');
// 2. 显示创建档案表单
Route::get('/animal/create', function () {
    return view('animal.create');
})->name('animal.create')->middleware('auth.any');
// 3. 提交创建档案
Route::post('/animal/store', [AnimalProfileController::class, 'createProfile'])->name('animal.store');
// 4. 查看档案详情
Route::get('/animal/{animalId}', [AnimalProfileController::class, 'show'])->name('animal.show');
// 5. 显示编辑档案表单（简化：复用创建表单，预填数据）
Route::get('/animal/{animalId}/edit', function ($animalId) {
    $animal = App\Models\Animal::findOrFail($animalId);
    return view('animal.edit', compact('animal'));
})->name('animal.edit')->middleware('auth.any');
// 6. 提交更新档案
Route::post('/animal/{animalId}/update', [AnimalProfileController::class, 'updateProfile'])->name('animal.update');