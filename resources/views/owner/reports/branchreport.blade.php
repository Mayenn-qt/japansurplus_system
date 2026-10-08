@extends('layouts.app')

@section('title', 'Branch Performance Reports - Executive Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">


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
                    <a href="{{ route('owner.reports.branchreport.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1 report-action" style="border-radius: 8px;"><i class="fa-solid fa-file-csv text-success"></i> Export CSV</a>
                    <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1 report-action" style="border-radius: 8px;"><i class="fa-solid fa-file-pdf text-danger"></i> Print / Save PDF</button>
                </div>
            </div>

            <!-- 1. Branch Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Top Performing Branch</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $topBranch?->branch_name ?? 'No sales yet' }}</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-arrow-up"></i> ₱{{ number_format($topBranch?->sales_sum_total_amount ?? 0, 2) }} total sales</span>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Active Branches</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $branches->where('sales_count', '>', 0)->count() }} Branches</h3>
                        <span class="text-muted small mt-1">With sales in the selected period</span>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Revenue in period</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱{{ number_format($branches->sum('sales_sum_total_amount'), 2) }}</h3>
                        <span class="text-info small mt-1"><i class="fa-solid fa-chart-line"></i> Across all locations</span>
                    </div>
                </div>
            </div>

            <!-- 2. Simplified Filters Section -->
            <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white report-filters">
                <form method="GET" action="{{ route('owner.reports.branchreport') }}" class="row g-3 align-items-end">
                    <div class="col-xl-3 col-md-4">
                        <label for="branchStartDate" class="form-label text-muted small fw-semibold">From</label>
                        <input id="branchStartDate" type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" max="{{ now()->toDateString() }}" class="form-control form-control-sm" style="border-radius: 8px;">
                    </div>
                    <div class="col-xl-3 col-md-4">
                        <label for="branchEndDate" class="form-label text-muted small fw-semibold">To</label>
                        <input id="branchEndDate" type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" max="{{ now()->toDateString() }}" class="form-control form-control-sm" style="border-radius: 8px;">
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <label for="branchFilter" class="form-label text-muted small fw-semibold">Branch</label>
                        <select id="branchFilter" name="branch_id" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="">All branches</option>
                            @foreach($allBranches as $branch)
                                <option value="{{ $branch->id }}" @selected((string) ($filters['branch_id'] ?? '') === (string) $branch->id)>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-danger btn-sm w-100 py-1.5 shadow-sm" style="border-radius: 8px; background-color: #db2828;"><i class="fa-solid fa-magnifying-glass me-1"></i>Filter</button>
                        <a href="{{ route('owner.reports.branchreport') }}" class="btn btn-outline-secondary btn-sm" title="Clear filters" aria-label="Clear filters"><i class="fa-solid fa-rotate-left"></i></a>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $branch->branch_name }}</td>
                                    <td class="text-muted">{{ $branch->address ?: 'Not specified' }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $branch->sales_count }}</span></td>
                                    <td class="fw-bold text-success">₱{{ number_format($branch->sales_sum_total_amount ?? 0, 2) }}</td>
                                    <td><span class="badge bg-light text-dark border px-2 py-1">{{ $branch->sales_count ? 'Active' : 'No sales yet' }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No branch data available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection