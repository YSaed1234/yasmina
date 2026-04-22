<?php

use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\CurrencyController;
use Modules\Admin\Http\Controllers\ProductController;

use Modules\Admin\Http\Controllers\RoleController;

Route::prefix('admin-dashboard-2026')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('roles', RoleController::class);
});
