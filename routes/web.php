<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BranchReportController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffSalesController;
use App\Http\Controllers\Staff\StaffProductController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 1. Owner / Admin Routes (Executive Dashboard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('owner')->group(function () {
    
    // Overview / Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('owner.dashboard');

    // Management (Products, Stock, Branches, Users)
    Route::get('/product', [ProductController::class, 'index'])->name('owner.product');
    Route::post('/product', [ProductController::class, 'store'])->name('owner.product.store');
    
    // Stock Management & Backend Actions
    Route::get('/stock', [ProductController::class, 'stockManagement'])->name('owner.stock');
    Route::post('/stock/in', [ProductController::class, 'storeStockIn'])->name('owner.stock.in');
    Route::post('/stock/out', [ProductController::class, 'storeStockOut'])->name('owner.stock.out');
    Route::get('/owner/stock/all', [ProductController::class, 'allStocks'])->name('owner.stock.all');

    Route::get('/branches', [BranchController::class, 'branch'])->name('owner.branch'); 
    Route::get('/users', [UserController::class, 'user'])->name('owner.user');

    // Reports (Sales, Inventory, Branch Reports)
    Route::get('/reports/sales', [SalesController::class, 'salesReport'])->name('owner.reports.sales');
    Route::get('/reports/inventory', [InventoryController::class, 'inventoryReport'])->name('owner.reports.inventory');
    Route::get('/reports/branch', [BranchReportController::class, 'branchReport'])->name('owner.reports.branchreport');

    // Communication (SMS Notifications)
    Route::get('/sms', [SmsController::class, 'smsIndex'])->name('owner.sms');

    // System (Settings)
    Route::get('/settings', [SettingController::class, 'setting'])->name('owner.settings');

    // Additional Account & Sales Recording
    Route::get('/sales-recording', [SalesController::class, 'index'])->name('owner.salesrecording');
    Route::get('/profile', [ProductController::class, 'profile'])->name('owner.profile');
});


/*
|--------------------------------------------------------------------------
| 2. Staff Routes (Staff Side UI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('staff')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

    // Sales Recording / POS
    Route::get('/sales', [StaffSalesController::class, 'sales'])->name('staff.sales.pos');
    Route::get('/sales/cart', [StaffSalesController::class, 'cart'])->name('staff.sales.cart');
    Route::get('/sales/checkout', [StaffSalesController::class, 'checkout'])->name('staff.sales.checkout');

    // Products
    Route::get('/products', [StaffProductController::class, 'index'])->name('staff.products.index');
    Route::get('/products/{id}', [StaffProductController::class, 'show'])->name('staff.products.show');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('staff.inventory.index');
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('staff.inventory.low-stock');

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('staff.profile.index');
});