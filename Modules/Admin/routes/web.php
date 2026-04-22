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
    
    Route::get('contact-requests', [\Modules\Admin\Http\Controllers\ContactRequestController::class, 'index'])->name('contact_requests.index')->middleware('permission:manage contact requests');
    Route::post('contact-requests/{id}/replied', [\Modules\Admin\Http\Controllers\ContactRequestController::class, 'markAsReplied'])->name('contact_requests.replied')->middleware('permission:manage contact requests');

    Route::get('users/search', [\Modules\Admin\Http\Controllers\UserController::class, 'search'])->name('users.search')->middleware('permission:manage users');
    Route::resource('users', \Modules\Admin\Http\Controllers\UserController::class)->middleware('permission:manage users');

    Route::get('orders', [\Modules\Admin\Http\Controllers\OrderController::class, 'index'])->name('orders.index')->middleware('permission:manage orders');
    Route::get('orders/{order}', [\Modules\Admin\Http\Controllers\OrderController::class, 'show'])->name('orders.show')->middleware('permission:manage orders');
    Route::post('orders/{order}/status', [\Modules\Admin\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update_status')->middleware('permission:manage orders');
    Route::delete('orders/{order}', [\Modules\Admin\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy')->middleware('permission:manage orders');

    Route::get('addresses', [\Modules\Admin\Http\Controllers\AddressController::class, 'index'])->name('addresses.index')->middleware('permission:manage addresses');
    Route::delete('addresses/{address}', [\Modules\Admin\Http\Controllers\AddressController::class, 'destroy'])->name('addresses.destroy')->middleware('permission:manage addresses');
});
