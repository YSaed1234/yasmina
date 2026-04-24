<?php

use Illuminate\Support\Facades\Route;
use Modules\Vendor\Http\Controllers\CategoryController;
use Modules\Vendor\Http\Controllers\ProductController;
use Modules\Vendor\Http\Controllers\OrderController;
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
        Route::get('finances', [VendorController::class, 'finances'])->name('vendor.finances.index');

        // Products
        Route::patch('products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('vendor.products.update-stock');
        Route::resource('products', ProductController::class)->names('vendor.products');

        // Categories
        Route::resource('categories', CategoryController::class)->names('vendor.categories');

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('vendor.orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('vendor.orders.show');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('vendor.orders.update-status');
        Route::put('orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('vendor.orders.update-payment-status');

        // Shipping
        Route::resource('shipping', \Modules\Vendor\Http\Controllers\RegionController::class)->names('vendor.shipping');

        // Sliders
        Route::resource('sliders', \Modules\Vendor\Http\Controllers\SliderController::class)->names('vendor.sliders');

        // Promotions (BOGO)
        Route::resource('promotions', \Modules\Vendor\Http\Controllers\PromotionController::class)->names('vendor.promotions');

        // Contact Requests
        Route::get('contact-requests', [\Modules\Vendor\Http\Controllers\ContactController::class, 'index'])->name('vendor.contacts.index');
        Route::get('contact-requests/{contact}', [\Modules\Vendor\Http\Controllers\ContactController::class, 'show'])->name('vendor.contacts.show');
        Route::put('contact-requests/{contact}/read', [\Modules\Vendor\Http\Controllers\ContactController::class, 'markAsRead'])->name('vendor.contacts.read');
        Route::put('contact-requests/{contact}/replied', [\Modules\Vendor\Http\Controllers\ContactController::class, 'markAsReplied'])->name('vendor.contacts.replied');
        Route::delete('contact-requests/{contact}', [\Modules\Vendor\Http\Controllers\ContactController::class, 'destroy'])->name('vendor.contacts.destroy');

        // Profile
        Route::get('profile', [VendorController::class, 'editProfile'])->name('vendor.profile.edit');
        Route::put('profile', [VendorController::class, 'updateProfile'])->name('vendor.profile.update');
    });
});
