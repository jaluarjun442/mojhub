<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WebsiteController;

Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('admin.home');
Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login_submit');
Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth.admin'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
    });
    Route::name('admin.')->group(function () {
        Route::resource('website', WebsiteController::class);
    });
});
