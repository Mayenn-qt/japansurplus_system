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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffSalesController;
use App\Http\Controllers\Staff\StaffProductController;
use App\Http\Controllers\Staff\PosController;

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
    Route::get('/search', [DashboardController::class, 'globalSearch'])->name('owner.global-search');

    // Management (Products, Stock, Branches, Users)
    Route::get('/product', [ProductController::class, 'index'])->name('owner.product');
    Route::post('/product', [ProductController::class, 'store'])->name('owner.product.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('owner.product.update');
    
    // Stock Management & Backend Actions
    Route::get('/stock', [ProductController::class, 'stockManagement'])->name('owner.stock');
    Route::put('/inventory/{inventory}/stock', [InventoryController::class, 'updateStock'])->name('owner.inventory.stock');
    Route::get('/stock/all', [ProductController::class, 'allStocks'])->name('owner.stock.all');

    Route::get('/branches', [BranchController::class, 'branch'])->name('owner.branch'); 
    Route::get('/branches/{branch}/operations', [BranchController::class, 'operations'])->name('owner.branch.operations');
    Route::get('/users', [UserController::class, 'user'])->name('owner.user');
    Route::get('/customers', [CustomerController::class, 'index'])->name('owner.customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('owner.customers.store');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('owner.customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('owner.customers.destroy');

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
    // POS Terminal
    Route::get('/pos', [PosController::class, 'index'])->name('staff.pos');

    // Sales & Checkout Routes
    Route::get('/sales', [StaffSalesController::class, 'sales'])->name('staff.sales.pos');
    Route::get('/sales/cart', [StaffSalesController::class, 'cart'])->name('staff.sales.cart');
    Route::get('/sales/checkout', [StaffSalesController::class, 'checkout'])->name('staff.sales.checkout');
    Route::post('/sales/store', [StaffSalesController::class, 'store'])->name('staff.sales.store'); // <--- Idinagdag para sa pag-record ng sale/checkout
    // Products
    Route::get('/products', [StaffProductController::class, 'index'])->name('staff.products.index');
    Route::get('/products/{id}', [StaffProductController::class, 'show'])->name('staff.products.show');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('staff.inventory.index');
    Route::get('/inventory/out-of-stock', [InventoryController::class, 'outOfStock'])->name('staff.inventory.out-of-stock');

    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('staff.profile.index');
});