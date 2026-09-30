@extends('layouts.app')

@section('title', 'Inventory Management - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stock.css') }}">

    <!-- Sidebar & Top NavBar -->
    @include('dashboard.sidebar')
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content" class="px-4 py-3">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3 py-2 small" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3 py-2 small" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-1 text-dark">Inventory Management</h5>
        <p class="text-muted small mb-0">Monitor stock levels, branch-specific availability, item locations, and product conditions.</p>
    </div>
</div>

                <!-- Filter Card -->
                <div class="card mb-3 border-0 shadow-sm rounded-3">
                    <form method="GET" action="{{ route('owner.stock') }}" class="p-2">
                        <div class="row g-2">
                            <div class="col-12 col-lg-6">
                                <div class="input-group bg-light rounded-2 border">
                                    <span class="input-group-text bg-transparent border-0 text-danger ps-3 py-1">
                                        <i class="fa-solid fa-magnifying-glass small"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm border-0 bg-transparent shadow-none py-1" placeholder="Search product name..." aria-label="Search by product name" onchange="this.form.submit()" onkeydown="if (event.key === 'Enter') this.form.submit();">
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="category_id" class="form-select form-select-sm bg-light border py-1" aria-label="Filter by category" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="branch_id" class="form-select form-select-sm bg-light border py-1" aria-label="Filter by branch" onchange="this.form.submit()">
                                    <option value="">All Branches</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ (string) request('branch_id', 1) === (string) $branch->id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="condition" class="form-select form-select-sm bg-light border py-1" aria-label="Filter by condition" onchange="this.form.submit()">
                                    <option value="">All Conditions</option>
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition }}" {{ request('condition') === $condition ? 'selected' : '' }}>{{ $condition }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table Card -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="bg-light  text-muted fs-8 tracking-wide">
                                <tr>
                                    <th class="py-2.5 ps-3" style="width: 38%;">Product</th>
                                    <th class="py-2.5" style="width: 15%;">Branch</th>
                                    <th class="py-2.5" style="width: 20%;">Item Location</th>
                                    <th class="py-2.5" style="width: 14%;">Condition</th>
                                    <th class="py-2.5 pe-3" style="width: 13%;">Date Arrived</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks ?? [] as $item)
                                    @php
                                        $product = $item->product;
                                        $primaryImage = $product?->image ?? $product?->images?->first()?->image;
                                        $condition = strtolower(trim($product?->condition ?? ''));
                                        $conditionClass = match (true) {
                                            str_contains($condition, 'damaged') => 'bg-danger bg-opacity-10 text-danger border-danger-subtle',
                                            str_contains($condition, 'repair') => 'bg-warning bg-opacity-25 text-dark border-warning',
                                            str_contains($condition, 'minor defect'), str_contains($condition, 'fair') => 'bg-warning bg-opacity-10 text-warning-emphasis border-warning-subtle',
                                            str_contains($condition, 'good'), str_contains($condition, 'new') => 'bg-success bg-opacity-10 text-success border-success-subtle',
                                            default => 'bg-light text-dark border',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="ps-3 py-2">
                                            <!-- Pinalaki ang gap sa gap-3 para may magandang space sa pagitan ng image at text -->
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light rounded-2 overflow-hidden d-flex align-items-center justify-content-center border flex-shrink-0" style="width: 56px; height: 56px;">
                                                @if($primaryImage)
                                                    <img src="{{ asset('images/products/' . basename($primaryImage)) }}" alt="{{ $product?->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <i class="fa-solid fa-image text-muted fs-5" aria-hidden="true"></i>
                                                @endif
                                                </div>
                                                <div class="lh-sm">
                                                    <span class="fw-semibold text-dark d-block text-truncate" style="max-width: 250px;">{{ $product?->name ?? 'N/A' }}</span>
                                                    <span class="text-muted fw-normal fs-8 d-block mt-1">{{ $product?->category?->name ?? 'Uncategorized' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-secondary py-2">{{ $item->branch?->branch_name ?? 'Unassigned' }}</td>
                                        <td class="text-secondary py-2">{{ $product?->location ?? 'Not specified' }}</td>
                                        <td class="py-2">
                                            <span class="badge {{ $conditionClass }} fw-normal px-2 py-1 fs-8">{{ $product?->condition ?? 'Not specified' }}</span>
                                        </td>
                                        <td class="text-secondary py-2 pe-3">{{ $product?->created_at?->format('M j, Y') ?? 'Not specified' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted small">No products found in inventory.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($stocks instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-2">
                        {{ $stocks->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection