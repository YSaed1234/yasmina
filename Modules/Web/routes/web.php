<?php

use Illuminate\Support\Facades\Route;
use Modules\Web\Http\Controllers\HomeController;
use Modules\Web\Http\Controllers\ProductDisplayController;
use Modules\Web\Http\Controllers\CartController;
use Modules\Web\Http\Controllers\CheckoutController;
use Modules\Web\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('web.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('web.contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('web.contact.submit');
Route::get('/shop', [ProductDisplayController::class, 'index'])->name('web.shop');
Route::get('/products/{id}', [ProductDisplayController::class, 'show'])->name('web.products.show');

Route::get('/cart', [CartController::class, 'index'])->name('web.cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('web.cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('web.cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('web.cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('web.cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('web.cart.coupon.remove');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('web.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('web.checkout.store');
});

// Profile & Orders
Route::middleware('auth')->group(function () {
    Route::get('/my-account', [ProfileController::class, 'index'])->name('web.profile');
    Route::get('/my-account/orders', [ProfileController::class, 'orders'])->name('web.profile.orders');
    Route::get('/my-account/addresses', [ProfileController::class, 'addresses'])->name('web.profile.addresses');
    Route::post('/my-account/addresses', [ProfileController::class, 'storeAddress'])->name('web.profile.addresses.store');
    Route::put('/my-account/addresses/{address}', [ProfileController::class, 'updateAddress'])->name('web.profile.addresses.update');
    Route::delete('/my-account/addresses/{address}', [ProfileController::class, 'deleteAddress'])->name('web.profile.addresses.delete');

    // Wishlist
    Route::get('/wishlist', [\Modules\Web\Http\Controllers\WishlistController::class, 'index'])->name('web.wishlist');
    Route::post('/wishlist/toggle/{product}', [\Modules\Web\Http\Controllers\WishlistController::class, 'toggle'])->name('web.wishlist.toggle');

    // Reviews
    Route::post('/reviews', [ProfileController::class, 'storeReview'])->name('web.reviews.store');

    // Notifications
    Route::get('/notifications', [\Modules\Web\Http\Controllers\NotificationController::class, 'index'])->name('web.notifications');
    Route::post('/notifications/{id}/read', [\Modules\Web\Http\Controllers\NotificationController::class, 'markAsRead'])->name('web.notifications.read');
    Route::post('/notifications/mark-all-read', [\Modules\Web\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('web.notifications.mark-all-read');

    // Regions API
    Route::get('/api/governorates/{governorate}/regions', function(\App\Models\Governorate $governorate) {
        return $governorate->regions()->where('is_active', true)->orderBy('name')->get();
    })->name('api.regions');
});
