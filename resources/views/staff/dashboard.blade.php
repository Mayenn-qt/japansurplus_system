@extends('layouts.app')

@section('title', 'Staff Dashboard - Ohaiyo Japan Surplus')

@section('content')
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- Include Sidebar Partial -->
    @include('staff.partials.sidebar')

    <!-- Include Top Navbar Partial -->
    @include('staff.partials.navbar')

    <!-- Main Content Wrapper (Pushed right for sidebar and down for topnavbar) -->
    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px);">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Dashboard Overview</h4>
                <p class="text-muted mb-0" style="font-size: 13.5px;">Here is your live counter and branch inventory summary for today.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('staff.sales.pos') }}" class="btn btn-danger btn-sm px-3 py-2 fw-semibold shadow-sm" style="border-radius: 8px;">
                    <i class="fa-solid fa-cash-register me-1"></i> Start New Sale
                </a>
                <a href="{{ route('staff.products.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold bg-white shadow-sm" style="border-radius: 8px; border-color: #e2e8f0; color: #475569;">
                    <i class="fa-solid fa-box me-1"></i> View Products
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <!-- Today's Sales -->
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-danger h-100">
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Today's Sales</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">₱18,450.00</h3>
                    <span class="text-success small mt-1"><i class="fa-solid fa-arrow-trend-up"></i> +8.4% vs yesterday</span>
                </div>
            </div>

            <!-- Transactions Today -->
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Transactions Today</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">32</h3>
                    <span class="text-muted small mt-1"><i class="fa-solid fa-receipt"></i> Completed tickets</span>
                </div>
            </div>

            <!-- Products Sold -->
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Products Sold</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">64 pcs</h3>
                    <span class="text-muted small mt-1"><i class="fa-solid fa-boxes-stacked"></i> Items checked out</span>
                </div>
            </div>

            <!-- Current Inventory (Branch) -->
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Current Inventory</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">1,280</h3>
                    <span class="text-success small mt-1"><i class="fa-solid fa-warehouse"></i> Total active stock</span>
                </div>
            </div>
        </div>

        <!-- Row Grid for Chart and Low Stock Alert -->
        <div class="row g-4 mb-4">
            <!-- Sales Chart: Today's Sales Trend -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-chart-line text-danger me-2"></i> Today's Sales Trend</h6>
                        <span class="badge bg-light text-muted border border-secondary border-opacity-15 px-2 py-1" style="font-size: 11px;">Hourly Realtime</span>
                    </div>
                    <div style="height: 250px; display: flex; align-items: center; justify-content: center; background-color: #f8fafc; border-radius: 8px; border: 1px dashed #e2e8f0;">
                        <!-- Ilagay dito ang iyong Chart.js canvas o sales graph component -->
                        <span class="text-muted small"><i class="fa-solid fa-chart-area me-1"></i> Sales Trend Chart Integration Area</span>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert Small Table -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> Low Stock Alert</h6>
                        <a href="{{ route('staff.inventory.low-stock') }}" class="text-decoration-none text-danger fw-semibold" style="font-size: 12px;">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0" style="font-size: 12.5px;">
                            <thead class="text-muted bg-light">
                                <tr>
                                    <th class="py-2 rounded-start">Item Name</th>
                                    <th class="py-2 text-end rounded-end">Stock Left</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom border-light">
                                    <td class="py-2 fw-medium text-dark">Japanese Ceramic Bowl</td>
                                    <td class="py-2 text-end text-danger fw-bold">2 pcs</td>
                                </tr>
                                <tr class="border-bottom border-light">
                                    <td class="py-2 fw-medium text-dark">Vintage Desk Lamp</td>
                                    <td class="py-2 text-end text-danger fw-bold">3 pcs</td>
                                </tr>
                                <tr>
                                    <td class="py-2 fw-medium text-dark">Minimalist Wooden Stool</td>
                                    <td class="py-2 text-end text-danger fw-bold">1 pc</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark m-0"><i class="fa-solid fa-clock-rotate-left text-secondary me-2"></i> Recent Transactions</h6>
                <a href="{{ route('staff.sales.pos') }}" class="text-decoration-none text-danger fw-semibold" style="font-size: 12px;">Go to POS <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                    <thead class="bg-light text-muted text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-3 rounded-start">Invoice</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Total Amount</th>
                            <th class="py-3 rounded-end">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-3 px-3 fw-bold text-dark">#INV-2026-089</td>
                            <td class="py-3 text-muted">Walk-in Customer</td>
                            <td class="py-3 fw-semibold text-dark">₱1,250.00</td>
                            <td class="py-3 text-muted">10:45 AM</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 fw-bold text-dark">#INV-2026-088</td>
                            <td class="py-3 text-muted">Juan Dela Cruz</td>
                            <td class="py-3 fw-semibold text-dark">₱3,400.00</td>
                            <td class="py-3 text-muted">10:12 AM</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-3 fw-bold text-dark">#INV-2026-087</td>
                            <td class="py-3 text-muted">Walk-in Customer</td>
                            <td class="py-3 fw-semibold text-dark">₱850.00</td>
                            <td class="py-3 text-muted">09:50 AM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection