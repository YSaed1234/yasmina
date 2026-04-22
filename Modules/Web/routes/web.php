<?php

use Illuminate\Support\Facades\Route;
use Modules\Web\Http\Controllers\HomeController;
use Modules\Web\Http\Controllers\ProductDisplayController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('web.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('web.contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('web.contact.submit');
Route::get('/shop', [ProductDisplayController::class, 'index'])->name('web.shop');
Route::get('/products/{id}', [ProductDisplayController::class, 'show'])->name('web.products.show');
