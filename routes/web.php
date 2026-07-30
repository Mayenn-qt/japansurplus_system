<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboards
Route::get('/owner/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('owner.dashboard');

Route::get('/staff/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('staff.dashboard');

// Product Management Routes (Nakasama na rito ang index, store, update, at destroy)
Route::middleware(['auth'])->prefix('owner')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('owner.product');
    Route::post('/product', [ProductController::class, 'store'])->name('products.store');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});