<?php

use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\CurrencyController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\RoleController;
use Modules\Admin\Http\Controllers\Auth\LoginController;
use Modules\Admin\Http\Controllers\SlideController;
use Modules\Admin\Http\Controllers\PointSettingController;

Route::prefix('admin-dashboard-2026')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin', 'verified', 'admin'])->name('admin.')->group(function () {
        Route::get('/', [\Modules\Admin\Http\Controllers\AdminController::class, 'index'])->name('index');

        Route::resource('categories', CategoryController::class);
        Route::patch('products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::resource('products', ProductController::class);
        Route::resource('currencies', CurrencyController::class);
        Route::resource('roles', RoleController::class);
        
        Route::get('contact-requests', [\Modules\Admin\Http\Controllers\ContactRequestController::class, 'index'])->name('contact_requests.index')->middleware('permission:manage contact requests');
        Route::post('contact-requests/{id}/replied', [\Modules\Admin\Http\Controllers\ContactRequestController::class, 'markAsReplied'])->name('contact_requests.replied')->middleware('permission:manage contact requests');

        Route::get('users/search', [\Modules\Admin\Http\Controllers\UserController::class, 'search'])->name('users.search')->middleware('permission:manage users');
        Route::resource('users', \Modules\Admin\Http\Controllers\UserController::class)->middleware('permission:manage users');

        Route::get('orders', [\Modules\Admin\Http\Controllers\OrderController::class, 'index'])->name('orders.index')->middleware('permission:manage orders');
        Route::get('orders/{order}', [\Modules\Admin\Http\Controllers\OrderController::class, 'show'])->name('orders.show')->middleware('permission:manage orders');
        Route::put('orders/{order}/status', [\Modules\Admin\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status')->middleware('permission:manage orders');
        Route::put('orders/{order}/payment-status', [\Modules\Admin\Http\Controllers\OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status')->middleware('permission:manage orders');
        Route::delete('orders/{order}', [\Modules\Admin\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy')->middleware('permission:manage orders');
        
        // Returns
        Route::get('returns', [\Modules\Admin\Http\Controllers\ReturnRequestController::class, 'index'])->name('returns.index')->middleware('permission:manage orders');
        Route::get('returns/{returnRequest}', [\Modules\Admin\Http\Controllers\ReturnRequestController::class, 'show'])->name('returns.show')->middleware('permission:manage orders');
        Route::put('returns/{returnRequest}/status', [\Modules\Admin\Http\Controllers\ReturnRequestController::class, 'updateStatus'])->name('returns.update-status')->middleware('permission:manage orders');

        Route::resource('coupons', \Modules\Admin\Http\Controllers\CouponController::class)->middleware('permission:manage coupons');
        Route::resource('promotions', \Modules\Admin\Http\Controllers\PromotionController::class)->middleware('permission:manage coupons');

        Route::resource('addresses', \Modules\Admin\Http\Controllers\AddressController::class)->names('addresses')->middleware('permission:manage addresses');
        Route::delete('addresses/{address}', [\Modules\Admin\Http\Controllers\AddressController::class, 'destroy'])->name('addresses.destroy')->middleware('permission:manage addresses');

        Route::resource('shipping-zones', \Modules\Admin\Http\Controllers\ShippingZoneController::class)->names('shipping_zones')->middleware('permission:manage shipping');
        Route::resource('governorates', \Modules\Admin\Http\Controllers\GovernorateController::class)->names('governorates')->middleware('permission:manage shipping');
        Route::resource('regions', \Modules\Admin\Http\Controllers\RegionController::class)->names('regions')->middleware('permission:manage shipping');

        Route::resource('slides', SlideController::class)->names('slides')->middleware('permission:manage slides');

        // Points Settings
        Route::get('settings/points', [PointSettingController::class, 'index'])->name('settings.points')->middleware('permission:manage points');
        Route::post('settings/points', [PointSettingController::class, 'update'])->name('settings.points.update')->middleware('permission:manage points');

        // Finances/Reports
        Route::get('finances', [\Modules\Admin\Http\Controllers\FinanceController::class, 'index'])->name('finances.index')->middleware('permission:manage vendors');
        Route::get('finances/{vendor}', [\Modules\Admin\Http\Controllers\FinanceController::class, 'show'])->name('finances.show')->middleware('permission:manage vendors');

        // Vendor Management
        Route::get('vendor-payments', [\Modules\Admin\Http\Controllers\VendorPaymentController::class, 'index'])->name('vendor_payments.index')->middleware('permission:manage vendors');
        Route::get('vendor-payments/{vendor}', [\Modules\Admin\Http\Controllers\VendorPaymentController::class, 'show'])->name('vendor_payments.show')->middleware('permission:manage vendors');
        Route::post('vendor-payments', [\Modules\Admin\Http\Controllers\VendorPaymentController::class, 'store'])->name('vendor_payments.store')->middleware('permission:manage vendors');
        Route::delete('vendor-payments/{payment}', [\Modules\Admin\Http\Controllers\VendorPaymentController::class, 'destroy'])->name('vendor_payments.destroy')->middleware('permission:manage vendors');

        Route::resource('vendors', \Modules\Admin\Http\Controllers\VendorController::class)->names('vendors')->middleware('permission:manage vendors');

        // Reports
        Route::get('inventory', [\Modules\Admin\Http\Controllers\ReportController::class, 'inventory'])->name('inventory.index');
        Route::get('traffic', [\Modules\Admin\Http\Controllers\ReportController::class, 'traffic'])->name('traffic.index');
    });
});