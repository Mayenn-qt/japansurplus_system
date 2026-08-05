<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;

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

Route::middleware(['auth'])->prefix('staff')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('staff.product');
});

Route::middleware(['auth'])->prefix('owner')->group(function () {
    Route::get('/sales-recording', [SalesController::class, 'index'])->name('owner.salesrecording');
    Route::get('/product', [ProductController::class, 'index'])->name('owner.product');
    Route::get('/stock', [ProductController::class, 'stockManagement'])->name('owner.stock');
});