@extends('layouts.app')

@section('title', 'Sales Reports - Executive Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">

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
                    <a href="{{ route('owner.reports.sales.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1 report-action" style="border-radius: 8px;"><i class="fa-solid fa-file-csv text-success"></i> Export CSV</a>
                    <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1 report-action" style="border-radius: 8px;"><i class="fa-solid fa-file-pdf text-danger"></i> Print / Save PDF</button>
                </div>
            </div>

            <!-- 1. Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Sales in period</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱{{ number_format($totalSales, 2) }}</h3>
                        <span class="text-muted small mt-1">Based on selected filters</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Transactions</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ number_format($transactionCount) }}</h3>
                        <span class="text-muted small mt-1">In selected period</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Items sold</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ number_format($unitsSold) }}</h3>
                        <span class="text-muted small mt-1">Units in selected period</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-info h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Average sale</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">₱{{ number_format($transactionCount ? $totalSales / $transactionCount : 0, 2) }}</h3>
                        <span class="text-info small mt-1"><i class="fa-solid fa-receipt"></i> Per transaction</span>
                    </div>
                </div>
            </div>

            <!-- 2. Filters Section -->
        <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white report-filters">
                <form method="GET" action="{{ route('owner.reports.sales') }}" class="row g-3 align-items-end">
                    <div class="col-xl-4 col-md-5">
                        <label for="salesStartDate" class="form-label text-muted small fw-semibold">From</label>
                        <input id="salesStartDate" type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" max="{{ now()->toDateString() }}" class="form-control form-control-sm" style="border-radius: 8px;">
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <label for="salesEndDate" class="form-label text-muted small fw-semibold">To</label>
                        <input id="salesEndDate" type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" max="{{ now()->toDateString() }}" class="form-control form-control-sm" style="border-radius: 8px;">
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <label for="salesBranch" class="form-label text-muted small fw-semibold">Branch</label>
                        <select id="salesBranch" name="branch_id" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="">All branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" @selected((string) ($filters['branch_id'] ?? '') === (string) $branch->id)>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-danger btn-sm w-100 py-1.5 shadow-sm" style="border-radius: 8px; background-color: #db2828;"><i class="fa-solid fa-magnifying-glass me-1"></i>Filter</button>
                        <a href="{{ route('owner.reports.sales') }}" class="btn btn-outline-secondary btn-sm" title="Clear filters" aria-label="Clear filters"><i class="fa-solid fa-rotate-left"></i></a>
                    </div>
                </form>
            </div>
            <!-- 3. Chart Section -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h6 class="fw-bold text-dark m-0">Daily sales trend</h6>
                    <span class="text-muted small">Up to 30 days in the selected period</span>
                </div>
                @php($maxTrendValue = max($trendData ?: [0]))
                <div class="report-chart" role="img" aria-label="Daily sales trend bar chart">
                    @foreach($trendData as $index => $value)
                        <div class="report-chart-column" title="{{ $trendLabels[$index] }}: ₱{{ number_format($value, 2) }}">
                            <span class="report-chart-value">{{ $value > 0 ? number_format($value, 0) : '' }}</span>
                            <div class="report-chart-bar" style="height: {{ $maxTrendValue > 0 ? max(2, ($value / $maxTrendValue) * 100) : 2 }}%;"></div>
                            <span class="report-chart-label">{{ $trendLabels[$index] }}</span>
                        </div>
                    @endforeach
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
                                    @forelse($bestSellingProducts ?? [] as $item)
                                        <tr>
                                            <td class="ps-3 fw-medium">{{ $item->product?->name ?? 'Product removed' }}</td>
                                            <td><span class="badge bg-light text-dark border">{{ $item->quantity_sold }}</span></td>
                                            <td class="pe-3 text-end fw-semibold">₱{{ number_format($item->revenue, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center py-4 text-muted">No product sales recorded yet.</td></tr>
                                    @endforelse
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
                                        <th class="py-2">Type</th>
                                        <th class="py-2">Total</th>
                                        <th class="pe-3 py-2">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSales ?? [] as $sale)
                                        <tr>
                                            <td class="ps-3">#{{ $sale->id }}</td>
                                            <td>{{ $sale->branch?->branch_name ?? 'Unassigned' }}</td>
                                            <td>{{ $sale->user?->name ?? 'Unassigned' }}</td>
                                            <td>{{ $sale->order_type ?: 'Walk-in' }}</td>
                                            <td class="fw-bold">₱{{ number_format($sale->total_amount, 2) }}</td>
                                            <td class="pe-3 text-muted" style="font-size: 11px;">{{ $sale->created_at?->format('M d, Y h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center py-4 text-muted">No sales transactions recorded yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-3 py-2 report-pagination">{{ $recentSales->links() }}</div>
                </div>
            </div>

        </div>
    </div>
@endsection