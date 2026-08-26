@extends('layouts.app')

@section('title', 'Sales Reports - Executive Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    

    <!-- Sidebar -->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <!-- Main Content Wrapper -->
    <div class="content-wrapper" style=" margin-top: -20px; padding-top: 10px; background-color: #f8fafc; min-height: 100vh;">
        <div class="container-fluid px-4 py-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Sales Reports</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Comprehensive sales analytics, revenue trends, and recent transaction insights</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-file-pdf text-danger"></i> Export PDF</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-file-excel text-success"></i> Export Excel</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-print"></i> Print</button>
                </div>
            </div>

            <!-- 1. Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Today's Sales</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱0.00</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-arrow-up"></i> 0% from yesterday</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">This Week</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱0.00</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-arrow-up"></i> 0% vs last week</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">This Month</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱0.00</h3>
                        <span class="text-muted small mt-1">Updated just now</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-info h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Transactions</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">0</h3>
                        <span class="text-info small mt-1"><i class="fa-solid fa-receipt"></i> Across all branches</span>
                    </div>
                </div>
            </div>

            <!-- 2. Filters Section -->
        <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
                <form class="row g-3 align-items-end">
                    <div class="col-xl-4 col-md-5">
                        <label class="form-label text-muted small fw-semibold">Date Range</label>
                        <input type="date" class="form-control form-control-sm" style="border-radius: 8px;">
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
            <!-- 3. Chart Section -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h6 class="fw-bold text-dark m-0">Sales Trend Chart</h6>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-dark active">Daily Sales</button>
                        <button type="button" class="btn btn-outline-dark">Weekly Sales</button>
                        <button type="button" class="btn btn-outline-dark">Monthly Sales</button>
                    </div>
                </div>
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="height: 250px; font-size: 14px;">
                    [ Sales Trend Chart Area: Daily / Weekly / Monthly ]
                </div>
            </div>

            <!-- 4. Tables Section -->
            <div class="row g-4 mb-4">
                <!-- Best Selling Products Table -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden bg-white">
                        <div class="card-header bg-white py-3 border-0">
                            <h6 class="fw-bold text-dark m-0">Best Selling Products</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="bg-light text-muted text-uppercase" style="font-size: 10px;">
                                    <tr>
                                        <th class="ps-3 py-2">Product</th>
                                        <th class="py-2">Sold</th>
                                        <th class="pe-3 py-2 text-end">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-3 fw-medium">Office Swivel Chair</td>
                                        <td><span class="badge bg-light text-dark border">20</span></td>
                                        <td class="pe-3 text-end fw-semibold">₱24,000</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-medium">Ceramic Plate & Bowl Set</td>
                                        <td><span class="badge bg-light text-dark border">50</span></td>
                                        <td class="pe-3 text-end fw-semibold">₱22,500</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-medium">Japanese Hard-Case Travel Luggage</td>
                                        <td><span class="badge bg-light text-dark border">15</span></td>
                                        <td class="pe-3 text-end fw-semibold">₱21,750</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions Table -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden bg-white">
                        <div class="card-header bg-white py-3 border-0">
                            <h6 class="fw-bold text-dark m-0">Recent Transactions</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="bg-light text-muted text-uppercase" style="font-size: 10px;">
                                    <tr>
                                        <th class="ps-3 py-2">Invoice</th>
                                        <th class="py-2">Branch</th>
                                        <th class="py-2">Staff</th>
                                        <th class="py-2">Customer</th>
                                        <th class="py-2">Total</th>
                                        <th class="pe-3 py-2">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-3 fw-semibold text-primary">#INV-1092</td>
                                        <td>Main</td>
                                        <td>Marianne</td>
                                        <td>Walk-in</td>
                                        <td class="fw-bold">₱43,500</td>
                                        <td class="pe-3 text-muted" style="font-size: 11px;">Apr 6, 4:40 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-semibold text-primary">#INV-1091</td>
                                        <td>Juban</td>
                                        <td>Mark</td>
                                        <td>Ronnel D.</td>
                                        <td class="fw-bold">₱6,200</td>
                                        <td class="pe-3 text-muted" style="font-size: 11px;">Apr 6, 1:15 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection