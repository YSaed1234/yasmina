<?php

use Illuminate\Support\Facades\Route;
use Modules\Web\Http\Controllers\HomeController;
use Modules\Web\Http\Controllers\ProductDisplayController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{id}', [ProductDisplayController::class, 'show'])->name('web.products.show');
