<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([\Modules\Web\Http\Middleware\ResolveVendor::class])->group(function () {
    require __DIR__.'/auth.php';
});
