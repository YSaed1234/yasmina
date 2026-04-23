<?php

use Illuminate\Support\Facades\Route;
use Modules\Vendor\Http\Controllers\VendorController;
use Modules\Vendor\Http\Controllers\Auth\LoginController;

Route::prefix('vendor-panel')->group(function () {
    // Auth Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('login', [LoginController::class, 'login'])->name('vendor.login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('vendor.logout');

    // Dashboard - Protected
    Route::middleware(['auth:vendor'])->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('vendor.dashboard');
    });
});
