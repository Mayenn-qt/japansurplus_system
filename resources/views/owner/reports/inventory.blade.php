@extends('layouts.app')

@section('title', 'Inventory Reports - Executive Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
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
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Inventory Reports</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Review item availability across branches</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('owner.reports.inventory.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1 report-action" style="border-radius: 8px;"><i class="fa-solid fa-file-csv text-success"></i> Export CSV</a>
                    <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center gap-1 report-action" style="border-radius: 8px;"><i class="fa-solid fa-file-pdf text-danger"></i> Print / Save PDF</button>
                </div>
            </div>

            <!-- 1. Inventory Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Products</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalProducts ?? 0 }}</h3>
                        <span class="text-muted small mt-1">Across all categories</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Units in Stock</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $inStockItems ?? 0 }}</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-check"></i> Ready for sale</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Inventory Records</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalInventoryRecords ?? 0 }}</h3>
                        <span class="text-muted small mt-1"><i class="fa-solid fa-box"></i> Unique items by branch</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-danger h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Products with Zero Stock</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">{{ $outOfStockItems ?? 0 }}</h3>
                        <span class="text-danger small mt-1"><i class="fa-solid fa-ban"></i> No units remaining</span>
                    </div>
                </div>
            </div>

            <!-- 2. Simplified Filters Section -->
            <div class="card border-0 shadow-sm rounded-3 p-3 mb-4 bg-white report-filters">
                <form method="GET" action="{{ route('owner.reports.inventory') }}" class="row g-3 align-items-end">
                    <div class="col-xl-3 col-md-4">
                        <label for="inventoryCategory" class="form-label text-muted small fw-semibold">Category</label>
                        <select id="inventoryCategory" name="category_id" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="">All categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-4">
                        <label for="inventoryBranch" class="form-label text-muted small fw-semibold">Branch</label>
                        <select id="inventoryBranch" name="branch_id" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="">All branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" @selected((string) ($filters['branch_id'] ?? '') === (string) $branch->id)>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-3">
                        <label for="inventoryStockLevel" class="form-label text-muted small fw-semibold">Stock status</label>
                        <select id="inventoryStockLevel" name="stock_level" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="all" @selected(($filters['stock_level'] ?? 'all') === 'all')>All stock</option>
                            <option value="in_stock" @selected(($filters['stock_level'] ?? '') === 'in_stock')>In stock</option>
                            <option value="out_of_stock" @selected(($filters['stock_level'] ?? '') === 'out_of_stock')>Out of stock</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-danger btn-sm w-100 py-1.5 shadow-sm" style="border-radius: 8px; background-color: #db2828;"><i class="fa-solid fa-magnifying-glass me-1"></i>Filter</button>
                        <a href="{{ route('owner.reports.inventory') }}" class="btn btn-outline-secondary btn-sm" title="Clear filters" aria-label="Clear filters"><i class="fa-solid fa-rotate-left"></i></a>
                    </div>
                </form>
            </div>

            <!-- 3. Stock Status Table Section -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark m-0">Inventory by branch</h6>
                        <span class="badge bg-light text-dark border" style="font-size: 11px;">{{ $inventory->total() }} records</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 10px;">
                            <tr>
                                <th class="ps-3 py-2">Product Name</th>
                                <th class="py-2">Category</th>
                                <th class="py-2">Branch</th>
                                <th class="py-2">Stock</th>
                                <th class="pe-3 py-2 text-end">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventory ?? [] as $item)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $item->product?->name ?? 'Product removed' }}</td>
                                    <td>{{ $item->product?->category?->name ?? 'Uncategorized' }}</td>
                                    <td>{{ $item->branch?->branch_name ?? 'Unassigned' }}</td>
                                    <td>{{ $item->current_stock }} units</td>
                                    <td class="pe-3 text-end"><span class="badge {{ $item->current_stock > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">{{ $item->current_stock > 0 ? 'In stock' : 'Out of stock' }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No inventory records match these filters.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-2 report-pagination">{{ $inventory->links() }}</div>
            </div>

        </div>
    </div>
@endsection