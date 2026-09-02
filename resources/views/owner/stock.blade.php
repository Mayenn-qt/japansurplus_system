@extends('layouts.app')

@section('title', 'Inventory & Stock Management - Ohaiyo Japan Surplus')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stock.css') }}">

    <!-- Sidebar -->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
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
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--ink); letter-spacing: -0.5px;">Stock Management</h4>
                        </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary px-3 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalStockOut" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">
                            <i class="fa-solid fa-truck-fast text-danger"></i> Stock Out
                        </button>
                        <button class="btn btn-primary px-3 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalStockIn" style="border-radius: 8px; font-size: 13.5px; font-weight: 500; background-color: #0f172a; border-color: #0f172a;">
                            <i class="fa-solid fa-truck-ramp-box text-white"></i> Stock In
                        </button>
                    </div>
                </div>

                <!-- Quick Stats Cards (Enterprise ERP Style) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 rounded-3" style="background-color: var(--bs-card-bg, #fff);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block" style="font-size: 12px; font-weight: 500;">TOTAL ITEMS</span>
                                    <h4 class="fw-bold mb-0" style="color: var(--ink);">{{ $totalItems ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 rounded-3" style="background-color: var(--bs-card-bg, #fff);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block" style="font-size: 12px; font-weight: 500;">LOW STOCK ITEMS</span>
                                    <h4 class="fw-bold mb-0" style="color: var(--ink);">{{ $lowStockCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-3 rounded-3" style="background-color: var(--bs-card-bg, #fff);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 20px;">
                                    <i class="fa-solid fa-ban"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block" style="font-size: 12px; font-weight: 500;">OUT OF STOCK</span>
                                    <h4 class="fw-bold mb-0" style="color: var(--ink);">{{ $outOfStockCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refined Filters & Search Toolbar -->
               <div class="card mb-4 border-0 shadow-sm rounded-3" style="background-color: var(--bs-card-bg, #fff);">
    <form method="GET" action="{{ route('owner.stock.all') }}" class="p-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <!-- Search Bar -->
        <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 450px; min-width: 280px;">
            <div class="search-box d-flex align-items-center px-3 py-2 rounded-2 border bg-light flex-grow-1">
                <i class="fa-solid fa-magnifying-glass text-danger me-2" style="font-size: 13px;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product or SKU..." style="border:none; background:transparent; outline:none; font-size:13px; width:100%; color: var(--ink);">
            </div>
            <button type="submit" class="btn btn-light border px-3 py-2 d-flex align-items-center gap-2 shadow-sm text-secondary" style="border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap;">
                <i class="fa-solid fa-filter text-danger" style="font-size: 12px;"></i> Filter
            </button>
        </div>

        <!-- Branch Filter Only -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="input-group input-group-sm bg-light rounded-2 border" style="width: 200px;">
                <span class="input-group-text bg-transparent border-0 text-danger ps-2 pe-1" style="font-size: 12px;"><i class="fa-solid fa-store"></i></span>
                <select name="branch_id" class="form-select form-select-sm border-0 bg-transparent shadow-none px-1" style="font-size: 12.5px; font-weight: 500;" onchange="this.form.submit()">
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
                <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
    <h6 class="fw-bold mb-0" style="color: var(--ink);">Stock Monitoring</h6>
    <a href="{{ route('owner.stock.all') }}" class="btn btn-sm btn-outline-secondary px-3" style="font-size: 13px; border-radius: 6px;">
        View All <i class="fa-solid fa-arrow-right ms-1"></i>
    </a>
</div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
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
                                        <td><span class="text-muted" style="font-size: 11.5px;">{{ $item->product->sku ?? 'N/A' }}</span></td>
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
                                            <span class="fw-semibold {{ $textColor }}" style="font-size: 12px;">
                                                {{ $statusText }}
                                            </span>
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
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="background-color: var(--bs-card-bg, #fff);">
                    <div class="p-3 border-bottom bg-light">
                        <h6 class="fw-bold mb-0" style="color: var(--ink);">Stock Activity Log</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
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
                                        <td class="ps-4 py-3 text-muted" style="font-size: 13px;">{{ $activity->created_at->format('M d, Y h:i A') }}</td>
                                        <td class="fw-semibold text-secondary">{{ $activity->branch ?? 'Main Branch' }}</td>
                                        <td><span class="text-muted">{{ $activity->product->sku ?? 'N/A' }}</span></td>
                                        <td class="fw-semibold text-dark">{{ $activity->quantity }} units</td>
                                        <td>
                                            @php
                                                $typeBg = $activity->type == 'Stock In' ? 'bg-success text-success' : 'bg-primary text-primary';
                                            @endphp
                                            <span class="badge border {{ $typeBg }} bg-opacity-10 px-2 py-1" style="font-weight: 500; font-size: 11px;">
                                                {{ $activity->type }}
                                            </span>
                                        </td>
                                        <td>{{ $activity->user->name ?? 'System' }}</td>
                                        <td class="pe-4 text-muted" style="font-size: 13px;">{{ $activity->remarks ?? $activity->reason ?? '-' }}</td>
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
    <!-- Stock In Modal -->
    @include('owner.stocks.stockin')

    <!-- Stock Out Modal -->
    @include('owner.stocks.stockout')

@endsection