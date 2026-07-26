<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::view('/owner/dashboard', 'owner.dashboard')
    ->name('owner.dashboard');

Route::view('/owner/product', 'owner.product')
    ->name('owner.product');

Route::view('/staff/dashboard', 'staff.dashboard')
    ->name('staff.dashboard');