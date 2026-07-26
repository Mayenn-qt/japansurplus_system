<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController; // I-import ang bagong DashboardController

Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Palitan ang Route::view ng DashboardController para sa owner at staff dashboards
Route::get('/owner/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('owner.dashboard');

Route::view('/owner/product', 'owner.product')
    ->middleware(['auth'])
    ->name('owner.product');

Route::get('/staff/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('staff.dashboard');