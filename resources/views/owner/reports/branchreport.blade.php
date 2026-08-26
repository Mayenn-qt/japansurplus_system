@extends('layouts.app')

@section('title', 'Branch Performance Reports - Executive Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">


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
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Branch Performance Reports</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Evaluate branch-wise revenue generation, operational efficiency, and sales comparisons</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-file-pdf text-danger"></i> Export PDF</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-file-excel text-success"></i> Export Excel</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;"><i class="fa-solid fa-print"></i> Print</button>
                </div>
            </div>

            <!-- 1. Branch Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Top Performing Branch</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">Main Branch</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-arrow-up"></i> ₱180,450 total sales</span>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Active Branches</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">3 Branches</h3>
                        <span class="text-muted small mt-1">Main, Juban, Magallanes</span>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Combined Monthly Sales</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱320,450</h3>
                        <span class="text-info small mt-1"><i class="fa-solid fa-chart-line"></i> Across all locations</span>
                    </div>
                </div>
            </div>

            <!-- 2. Simplified Filters Section -->
            <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white">
                <form class="row g-3 align-items-end">
                    <div class="col-xl-4 col-md-5">
                        <label class="form-label text-muted small fw-semibold">Date Range</label>
                        <input type="date" class="form-control form-control-sm" style="border-radius: 8px;">
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <label class="form-label text-muted small fw-semibold">Branch Selection</label>
                        <select class="form-select form-select-sm" style="border-radius: 8px;">
                            <option selected>All Branches Comparison</option>
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

            <!-- 3. Branch Performance Table Section -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark m-0">Branch Revenue & Metrics Breakdown</h6>
                    <span class="badge bg-light text-dark border" style="font-size: 11px;">Real-time overview</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 10px;">
                            <tr>
                                <th class="ps-3 py-2">Branch Name</th>
                                <th class="py-2">Location</th>
                                <th class="py-2">Total Transactions</th>
                                <th class="py-2">Total Revenue</th>
                                <th class="py-2">Performance Status</th>
                                <th class="pe-3 py-2 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-medium">Main Branch</td>
                                <td class="text-muted">Pangpang</td>
                                <td><span class="badge bg-light text-dark border">120</span></td>
                                <td class="fw-bold text-success">₱180,450</td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Top Performer</span></td>
                                <td class="pe-3 text-end">
                                    <button class="btn btn-sm btn-outline-dark py-0 px-2" style="font-size: 11px; border-radius: 6px;">View Details</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Juban</td>
                                <td class="text-muted">Juban Proper</td>
                                <td><span class="badge bg-light text-dark border">65</span></td>
                                <td class="fw-bold text-dark">₱95,200</td>
                                <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Stable</span></td>
                                <td class="pe-3 text-end">
                                    <button class="btn btn-sm btn-outline-dark py-0 px-2" style="font-size: 11px; border-radius: 6px;">View Details</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-3 fw-medium">Magallanes</td>
                                <td class="text-muted">Coastal Area</td>
                                <td><span class="badge bg-light text-dark border">30</span></td>
                                <td class="fw-bold text-dark">₱44,800</td>
                                <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Growing</span></td>
                                <td class="pe-3 text-end">
                                    <button class="btn btn-sm btn-outline-dark py-0 px-2" style="font-size: 11px; border-radius: 6px;">View Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection