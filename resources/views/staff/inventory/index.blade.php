@extends('layouts.app')

@section('title', 'Current Inventory - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div class="main-content" style="background-color: #f8fafc; min-height: calc(100vh - 70px); padding: 2rem;">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark m-0">
                    <i class="fa-solid fa-boxes-stacked me-2 text-danger"></i>Current Inventory
                </h4>
                <p class="text-muted small m-0 mt-1">Real-time stock monitoring and item availability across your branch.</p>
            </div>
            <div class="badge bg-dark bg-opacity-10 text-dark px-3 py-2 rounded-pill fw-semibold" style="font-size: 12px;">
                <i class="fa-solid fa-store me-1 text-secondary"></i>
                {{ auth()->user()->branch->branch_name ?? auth()->user()->branch->name ?? 'Assigned Branch' }}
            </div>
        </div>

        <!-- Success / Error Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; font-size: 13px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px; font-size: 13px;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 1. Summary Metrics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white h-100" style="border-radius: 12px; border-left: 4px solid #0f172a !important;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-3 me-3 text-dark bg-light" style="font-size: 18px;">
                            <i class="fa-solid fa-cubes"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Total Quantity</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ number_format($totalItems ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white h-100" style="border-radius: 12px; border-left: 4px solid #f59e0b !important;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-3 me-3 text-warning bg-warning bg-opacity-10" style="font-size: 18px;">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Low Stock (≤ 5)</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ number_format($lowStockCount ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3 bg-white h-100" style="border-radius: 12px; border-left: 4px solid #e11d48 !important;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-3 me-3 text-danger bg-danger bg-opacity-10" style="font-size: 18px;">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Out of Stock</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ number_format($outOfStockCount ?? 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Search & Filter Bar -->
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-4">
            <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 shadow-none" placeholder="Search by product name or SKU..." style="font-size: 13px; border-radius: 0 8px 8px 0;">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="branch" class="form-select bg-light border-0 text-dark fw-semibold" style="font-size: 13px; border-radius: 8px;">
                        <option value="">All Branches</option>
                        @foreach($branches ?? [] as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name ?? $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="stock_level" class="form-select bg-light border-0 text-dark fw-semibold" style="font-size: 13px; border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="in" {{ request('stock_level') == 'in' ? 'selected' : '' }}>🟢 In Stock</option>
                        <option value="low" {{ request('stock_level') == 'low' ? 'selected' : '' }}>🟡 Low Stock</option>
                        <option value="out" {{ request('stock_level') == 'out' ? 'selected' : '' }}>🔴 Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100 fw-semibold shadow-sm" style="font-size: 13px; border-radius: 8px;"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-light w-100 text-muted fw-semibold border" style="font-size: 13px; border-radius: 8px;">Reset</a>
                </div>
            </form>
        </div>

        <!-- 3. Inventory Data Table Card -->
        <div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover" style="font-size: 13px;">
                    <thead class="bg-light text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-4">Product Image</th>
                            <th class="py-3 px-4">Product Name & SKU</th>
                            <th class="py-3 text-center">Current Stock</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stocks ?? [] as $stock)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="bg-light rounded-3 overflow-hidden d-flex align-items-center justify-content-center border" style="width: 56px; height: 56px;">
                                        @if($stock->product?->image)
                                            <img src="{{ asset('images/products/' . basename($stock->product->image)) }}"
                                                 alt="{{ $stock->product->name }}"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fa-solid fa-image text-muted" aria-hidden="true"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="fw-bold text-dark d-block">{{ $stock->product->name ?? 'Unknown Product' }}</span>
                                    <span class="text-muted small"><code class="text-danger bg-light px-1 py-0.5 rounded">{{ $stock->product->sku ?? 'N/A' }}</code></span>
                                </td>
                                <td class="py-3 text-center fw-bold text-dark">
                                    <span class="fs-6">{{ number_format($stock->current_stock) }}</span> <span class="text-muted small fw-normal">pcs</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($stock->current_stock > 5)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5" style="font-size: 11px;">
                                            <i class="fa-solid fa-circle-check me-1"></i> In Stock
                                        </span>
                                    @elseif($stock->current_stock > 0 && $stock->current_stock <= 5)
                                        <span class="badge bg-warning bg-opacity-10 text-warning text-dark border border-warning border-opacity-25 px-2.5 py-1.5" style="font-size: 11px;">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Low Stock
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1.5" style="font-size: 11px;">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> Out of Stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <i class="fa-solid fa-box-open fa-3x mb-3 text-secondary opacity-50"></i>
                                        <h6 class="fw-bold text-dark mb-1">No inventory records found</h6>
                                        <p class="small text-muted mb-0">Try adjusting your search criteria or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            @if(isset($stocks) && method_exists($stocks, 'hasPages') && $stocks->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing <b>{{ $stocks->firstItem() ?? 0 }}</b> to <b>{{ $stocks->lastItem() ?? 0 }}</b> of <b>{{ $stocks->total() ?? 0 }}</b> entries
                    </div>
                    <div>
                        {{ $stocks->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection