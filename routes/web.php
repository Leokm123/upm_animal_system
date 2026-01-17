<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalProfileController; // 引入动物档案控制器
use App\Http\Controllers\SightingController; // 引入目击控制器
use App\Http\Controllers\ManagerController;

// 基础登录/登出/仪表盘路由
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// ====== 动物目击模块路由（场景1）======
Route::get('/sighting/report', [SightingController::class, 'create'])->name('sighting.create');
Route::post('/sighting/report', [SightingController::class, 'reportSighting'])->name('sighting.report');
Route::get('/sightings', [SightingController::class, 'index'])->name('sighting.index');

// ====== 动物档案模块路由（场景1）======
Route::post('/animal/match', [AnimalProfileController::class, 'matchProfiles'])->name('animal.match');

// 新增：动物列表页面路由（放在 /animal/create 之前）
Route::get('/animals', [AnimalProfileController::class, 'index'])->name('animal.index')->middleware('auth');

Route::get('/animal/create', function () {
    return view('animal.create');
})->name('animal.create')->middleware('auth');
Route::post('/animal/store', [AnimalProfileController::class, 'createProfile'])->name('animal.store');
Route::get('/animal/{animalId}', [AnimalProfileController::class, 'show'])->name('animal.show');
Route::get('/animal/{animalId}/edit', function ($animalId) {
    $animal = App\Models\Animal::findOrFail($animalId);
    return view('animal.edit', compact('animal'));
})->name('animal.edit')->middleware('auth');
Route::post('/animal/{animalId}/update', [AnimalProfileController::class, 'updateProfile'])->name('animal.update');

// API路由：获取最新动物记录（仅限AJAX）
Route::get('/api/animals', [SightingController::class, 'getAnimals'])->name('api.animals');

// ====== UPM用户捐款+财务报告路由（场景3）======
// 引入财务捐赠控制器
use App\Http\Controllers\DonationController;
// 登录验证：改用Laravel内置auth中间件（替代错误的匿名闭包）
Route::middleware('auth')->group(function () {
    // ====== 新增：UPM功能选择主页 (登录后默认进这个页面) ======
    Route::get('/upm-user/dashboard', [DonationController::class, 'home'])->name('upmuser.dashboard');
    // ====== 我要捐款 按钮 跳转的页面 ======
    Route::get('/upm-user/donate-page', [DonationController::class, 'donatePage'])->name('upmuser.donate_page');
    // 提交捐款数据处理
    Route::post('/upm-user/donate', [DonationController::class, 'submitDonation'])->name('upmuser.submit_donation');
    // ====== 查看财务报告 按钮 跳转的页面 ======
    Route::get('/upm-user/financialreports', [DonationController::class, 'financialreportList'])->name('upmuser.financialreport_list');
    // 财务报告详情页面
    Route::get('/upm-user/financialreport/{reportId}', [DonationController::class, 'financialreportDetails'])->name('upmuser.financialreport_details');
});

// ✅ 修改后 无 auth 中间件 ↓↓↓ 直接写路由，其他代码一行不改！
// 管理员创建喂养点 路由组
Route::get('/manager/create-feeding-point', [ManagerController::class, 'createFeedingPoint'])->name('manager.create_feeding');
Route::post('/manager/store-feeding-point', [ManagerController::class, 'storeFeedingPoint'])->name('manager.store_feeding');
Route::get('/manager/feeding-point-list', [ManagerController::class, 'feedingPointList'])->name('manager.feeding_list');

// 管理员分配任务 路由组
Route::get('/manager/assign-task', [ManagerController::class, 'assignTask'])->name('manager.assign_task');
Route::post('/manager/store-task', [ManagerController::class, 'storeTask'])->name('manager.store_task');
Route::get('/manager/task-list', [ManagerController::class, 'taskList'])->name('manager.task_list');

// 志愿者提交报告 + 管理员查看报告 路由组
Route::get('/manager/volunteer-report', [ManagerController::class, 'volunteerReport'])->name('manager.volunteer_report');
Route::post('/manager/store-report', [ManagerController::class, 'storeReport'])->name('manager.store_report');
Route::get('/manager/view-reports', [ManagerController::class, 'viewReports'])->name('manager.view_reports');