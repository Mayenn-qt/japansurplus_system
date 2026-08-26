@extends('layouts.app')

@section('title', 'Inventory Reports - Executive Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

    <!-- Sidebar -->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <!-- Main Content Wrapper -->
    <div class="content-wrapper" style=" background-color: #f8fafc; min-height: 100vh;">
        <div class="container-fluid px-4 py-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Inventory Reports</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Monitor stock levels, track item movements, and manage low-stock alerts</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-file-pdf text-danger"></i> Export PDF</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-file-excel text-success"></i> Export Excel</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-print"></i> Print</button>
                </div>
            </div>

            <!-- 1. Inventory Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Products</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">0</h3>
                        <span class="text-muted small mt-1">Across all categories</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">In Stock Items</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">0</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-check"></i> Ready for sale</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Low Stock Alerts</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">0</h3>
                        <span class="text-warning small mt-1"><i class="fa-solid fa-triangle-exclamation"></i> Needs reorder</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-danger h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Out of Stock</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">0</h3>
                        <span class="text-danger small mt-1"><i class="fa-solid fa-ban"></i> Action required</span>
                    </div>
                </div>
            </div>

            <!-- 2. Simplified Filters Section -->
            <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
                <form class="row g-3 align-items-end">
                    <div class="col-xl-4 col-md-5">
                        <label class="form-label text-muted small fw-semibold">Category</label>
                        <select class="form-select form-select-sm" style="border-radius: 8px;">
                            <option selected>All Categories</option>
                            <option>Appliances</option>
                            <option>Furniture</option>
                            <option>Electronics</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <label class="form-label text-muted small fw-semibold">Branch</label>
                        <select class="form-select form-select-sm" style="border-radius: 8px;">
                            <option selected>All Branches</option>
                            <option>Main Branch</option>
                            <option>Juban</option>
                            <option>Magallanes</option>
                        </select>
                    </div>
                    <div class="col-xl-4 col-md-3">
                        <button type="submit" class="btn btn-danger btn-sm w-100 py-1.5 shadow-sm" style="border-radius: 8px; background-color: #db2828;"><i class="fa-solid fa-magnifying-glass me-1"></i>Filter</button>
                    </div>
                </form>
            </div>

            <!-- 3. Stock Status Table Section -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark m-0">Critical Stock Status & Items</h6>
                    <span class="badge bg-light text-dark border" style="font-size: 11px;">Showing low & out of stock items</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 10px;">
                            <tr>
                                <th class="ps-3 py-2">Product Name</th>
                                <th class="py-2">Category</th>filter
                                <th class="py-2">Branch</th>
                                <th class="py-2">Current Stock</th>
                                <th class="py-2">Status</th>
                                <th class="pe-3 py-2 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium">Shindaiwa Gasoline Engine Chainsaw</td>
                                <td>Tools & Equipment</td>
                                <td>Main</td>
                                <td><span class="fw-bold text-danger">2</span></td>
                                <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Low Stock</span></td>
                                <td class="pe-3 text-end">
                                    <button class="btn btn-sm btn-outline-dark py-0 px-2" style="font-size: 11px; border-radius: 6px;">Reorder</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Japanese Wooden Wardrobe Cabinet</td>
                                <td>Furniture</td>
                                <td>Juban</td>
                                <td><span class="fw-bold text-danger">0</span></td>
                                <td><span class="badge bg-dark text-white px-2 py-1">Out of Stock</span></td>
                                <td class="pe-3 text-end">
                                    <button class="btn btn-sm btn-outline-dark py-0 px-2" style="font-size: 11px; border-radius: 6px;">Reorder</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection