@extends('layouts.app')

@section('title', 'Inventory Management - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stock.css') }}">

    <!-- Sidebar & Top NavBar -->
    @include('dashboard.sidebar')
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content">

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
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h4 class="fw-bold mb-1 text-dark">Inventory Management</h4>
                </div>

                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <form method="GET" action="{{ route('owner.stock') }}" class="p-3">
                        <div class="row g-2">
                            <div class="col-12 col-lg-4">
                                <div class="input-group bg-light rounded-2 border">
                                    <span class="input-group-text bg-transparent border-0 text-danger ps-3">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm border-0 bg-transparent shadow-none" placeholder="Search product name..." aria-label="Search by product name" onkeydown="if (event.key === 'Enter') this.form.submit();">
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="category_id" class="form-select form-select-sm bg-light border" aria-label="Filter by category">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="branch_id" class="form-select form-select-sm bg-light border" aria-label="Filter by branch">
                                    <option value="">All Branches</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ (string) request('branch_id', 1) === (string) $branch->id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="condition" class="form-select form-select-sm bg-light border" aria-label="Filter by condition">
                                    <option value="">All Conditions</option>
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition }}" {{ request('condition') === $condition ? 'selected' : '' }}>{{ $condition }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-lg-2">
                                <select name="sort" class="form-select form-select-sm bg-light border" aria-label="Sort by date arrived" onchange="this.form.submit()">
                                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Date Arrived: Newest</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Date Arrived: Oldest</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted fs-8 tracking-wide">
                                <tr>
                                    <th class="py-3 ps-4">Product</th>
                                    <th class="py-3">Branch</th>
                                    <th class="py-3">Item Location</th>
                                    <th class="py-3">Condition</th>
                                    <th class="py-3">Date Arrived</th>
                                    <th class="py-3 pe-4">Action</th>
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
                                        $statusAvailable = (int) ($item->current_stock ?? 0) > 0;
                                    @endphp
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light rounded-3 overflow-hidden d-flex align-items-center justify-content-center border flex-shrink-0" style="width: 56px; height: 56px;">
                                                @if($primaryImage)
                                                    <img src="{{ asset('images/products/' . basename($primaryImage)) }}" alt="{{ $product?->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <i class="fa-solid fa-image text-muted" aria-hidden="true"></i>
                                                @endif
                                                </div>
                                                <div class="fw-semibold text-dark">
                                                    {{ $product?->name ?? 'N/A' }}
                                                    <span class="text-muted fs-8 d-block">{{ $product?->category?->name ?? 'Uncategorized' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-secondary">{{ $item->branch?->branch_name ?? 'Unassigned' }}</td>
                                        <td class="text-secondary">{{ $product?->location ?? 'Not specified' }}</td>
                                        <td>
                                            <span class="badge {{ $conditionClass }} fw-medium">{{ $product?->condition ?? 'Not specified' }}</span>
                                        </td>
                                        <td class="text-secondary">{{ $product?->created_at?->format('F j, Y') ?? 'Not specified' }}</td>
                                        <td>
                                            <span class="badge {{ $statusAvailable ? 'bg-success bg-opacity-10 text-success border-success-subtle' : 'bg-danger bg-opacity-10 text-danger border-danger-subtle' }} fw-medium">
                                                {{ $statusAvailable ? 'Available' : 'Sold Out' }}
                                            </span>
                                        </td>
                                        <td class="pe-4">
                                            <button type="button" class="btn btn-sm btn-light border px-3 rounded-2" data-bs-toggle="modal" data-bs-target="#inventoryDetails{{ $item->id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No products found in inventory.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @foreach($stocks ?? [] as $item)
                    @php
                        $product = $item->product;
                        $images = collect();
                        if ($product?->image) {
                            $images->push($product->image);
                        }
                        $images = $images->merge($product?->images?->pluck('image') ?? collect())->unique();
                    @endphp
                    <div class="modal fade" id="inventoryDetails{{ $item->id }}" tabindex="-1" aria-labelledby="inventoryDetailsLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                                <div class="modal-header bg-light border-bottom px-4 py-3">
                                    <h5 class="modal-title fw-bold text-dark" id="inventoryDetailsLabel{{ $item->id }}">Inventory Details</h5>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row g-4">
                                        <div class="col-md-5">
                                            <div class="bg-light rounded-3 border d-flex align-items-center justify-content-center overflow-hidden" style="height: 220px;">
                                                @if($images->first())
                                                    <img src="{{ asset('images/products/' . basename($images->first())) }}" alt="{{ $product?->name }}" class="w-100 h-100" style="object-fit: contain;">
                                                @else
                                                    <i class="fa-solid fa-image text-muted fa-2x"></i>
                                                @endif
                                            </div>
                                            @if($images->count() > 1)
                                                <div class="d-flex gap-2 mt-2 flex-wrap">
                                                    @foreach($images as $image)
                                                        <img src="{{ asset('images/products/' . basename($image)) }}" alt="{{ $product?->name }}" class="rounded border" style="width: 52px; height: 52px; object-fit: cover;">
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-7">
                                            <h5 class="fw-bold text-dark mb-1">{{ $product?->name ?? 'N/A' }}</h5>
                                            <p class="text-muted mb-4">{{ $product?->category?->name ?? 'Uncategorized' }}</p>
                                            <dl class="row mb-0 small">
                                                <dt class="col-5 text-muted">Branch</dt>
                                                <dd class="col-7 text-dark">{{ $item->branch?->branch_name ?? 'Unassigned' }}</dd>
                                                <dt class="col-5 text-muted">Item Location</dt>
                                                <dd class="col-7 text-dark">{{ $product?->location ?? 'Not specified' }}</dd>
                                                <dt class="col-5 text-muted">Condition</dt>
                                                <dd class="col-7 text-dark">{{ $product?->condition ?? 'Not specified' }}</dd>
                                                <dt class="col-5 text-muted">Date Arrived</dt>
                                                <dd class="col-7 text-dark">{{ $product?->created_at?->format('F j, Y') ?? 'Not specified' }}</dd>
                                                @if($product?->remarks)
                                                    <dt class="col-5 text-muted">Remarks</dt>
                                                    <dd class="col-7 text-dark">{{ $product->remarks }}</dd>
                                                @endif
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($stocks instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-3">
                        {{ $stocks->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection