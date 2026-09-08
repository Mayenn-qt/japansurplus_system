@extends('layouts.app')

@section('title', 'Inventory & Stock Management - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stock.css') }}">

    <!-- Sidebar & Top NavBar -->
    @include('dashboard.sidebar')
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content">

            <!-- Success/Error Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="page-section active-page" id="page-stock">
                
                <!-- Header & Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h4 class="fw-bold mb-1 text-dark">Inventory Management</h4>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary px-3 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalStockOut">
                            <i class="fa-solid fa-truck-fast text-danger"></i> Stock Out
                        </button>
                        <button class="btn btn-dark px-3 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalStockIn">
                            <i class="fa-solid fa-truck-ramp-box text-white"></i> Stock In
                        </button>
                    </div>
                </div>

                <!-- Quick Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 rounded-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center icon-box">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block fs-7 fw-medium">TOTAL ITEMS</span>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalItems ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 rounded-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center icon-box">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block fs-7 fw-medium">LOW STOCK ITEMS</span>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $lowStockCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 rounded-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center icon-box">
                                    <i class="fa-solid fa-ban"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block fs-7 fw-medium">OUT OF STOCK</span>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $outOfStockCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters & Search Toolbar -->
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <form method="GET" action="{{ route('owner.stock.all') }}" class="p-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2 flex-grow-1 search-toolbar-container">
                            <div class="input-group bg-light rounded-2 border flex-grow-1">
                                <span class="input-group-text bg-transparent border-0 text-danger ps-3">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm border-0 bg-transparent shadow-none" placeholder="Search product or SKU...">
                            </div>
                            <button type="submit" class="btn btn-light border px-3 py-2 d-flex align-items-center gap-2 shadow-sm text-secondary">
                                <i class="fa-solid fa-filter text-danger"></i> Filter
                            </button>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm bg-light rounded-2 border branch-select-container">
                                <span class="input-group-text bg-transparent border-0 text-danger ps-2 pe-1">
                                    <i class="fa-solid fa-store"></i>
                                </span>
                                <select name="branch_id" class="form-select form-select-sm border-0 bg-transparent shadow-none px-1 fw-medium" onchange="this.form.submit()">
                                    <option value="">All Branches</option>
                                    @foreach($branches ?? [] as $branch)
                                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->branch_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Stock Monitoring Table -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                    <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark">Stock Monitoring</h6>
                        <a href="{{ route('owner.stock.all') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">
                            View All <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted fs-8 tracking-wide">
                                <tr>
                                    <th class="py-3 ps-4">Branch</th>
                                    <th class="py-3">Product Name</th>
                                    <th class="py-3">SKU</th>
                                    <th class="py-3">Current Stock</th>
                                    <th class="py-3 pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks ?? [] as $item)
                                    <tr>
                                        <td class="ps-4 py-3 fw-semibold text-secondary">
                                            {{ str_replace(' Branch', '', $item->branch->branch_name ?? 'Main') }}
                                        </td>
                                        <td class="fw-semibold text-dark">{{ $item->product->name ?? 'N/A' }}</td>
                                        <td><span class="text-muted fs-8">{{ $item->product->sku ?? 'N/A' }}</span></td>
                                        <td class="fw-semibold text-dark">{{ $item->current_stock }} units</td>
                                        <td class="pe-4">
                                            @php
                                                $textColor = 'text-success';
                                                $statusText = 'In Stock';
                                                
                                                if($item->current_stock <= 0) {
                                                    $textColor = 'text-danger';
                                                    $statusText = 'Out of Stock';
                                                } elseif($item->current_stock <= 5) {
                                                    $textColor = 'text-warning';
                                                    $statusText = 'Low Stock';
                                                }
                                            @endphp
                                            <span class="fw-semibold {{ $textColor }} fs-7">{{ $statusText }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No stock inventory records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Stock Movement History Table -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="p-3 border-bottom bg-light">
                        <h6 class="fw-bold mb-0 text-dark">Stock Activity Log</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted fs-8 tracking-wide">
                                <tr>
                                    <th class="py-3 ps-4">Date / Time</th>
                                    <th class="py-3">Branch</th>
                                    <th class="py-3">Product SKU</th>
                                    <th class="py-3">Quantity</th>
                                    <th class="py-3">Type</th>
                                    <th class="py-3">Authorized By</th>
                                    <th class="py-3 pe-4">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities ?? [] as $activity)
                                    <tr>
                                        <td class="ps-4 py-3 text-muted fs-7">{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                        <td class="fw-semibold text-secondary">{{ $activity->branch ?? 'Main Branch' }}</td>
                                        <td><span class="text-muted">{{ $activity->product->sku ?? 'N/A' }}</span></td>
                                        <td class="fw-semibold text-dark">{{ $activity->quantity }} units</td>
                                        <td>
                                            @php
                                                $typeBg = $activity->type == 'Stock In' ? 'bg-success text-success' : 'bg-primary text-primary';
                                            @endphp
                                            <span class="badge border {{ $typeBg }} bg-opacity-10 px-2 py-1 fw-medium fs-8">
                                                {{ $activity->type }}
                                            </span>
                                        </td>
                                        <td>{{ $activity->user->name ?? 'System' }}</td>
                                        <td class="pe-4 text-muted fs-7">{{ $activity->remarks ?? $activity->reason ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No recent stock movement logs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('owner.stocks.stockin')
    @include('owner.stocks.stockout')
@endsection