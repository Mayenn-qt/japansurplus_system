@extends('layouts.app')

@section('title', 'Product Management - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <!-- Responsive Styling: List style sa Desktop, Square Cards sa Mobile -->
    <style>
        @media (max-width: 767.98px) {
            .desktop-view-container { display: none !important; }
            .mobile-square-container { display: flex !important; }
        }
        @media (min-width: 768px) {
            .desktop-view-container { display: block !important; }
            .mobile-square-container { display: none !important; }
        }
    </style>

    <!-- Japanese Warm Neutral Minimalist Background -->
    <div style="background-color: #ffffff; min-height: calc(100vh - 70px); padding: 20px; font-family: 'Inter', sans-serif;">
        
        <!-- Header & Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold m-0" style="color: #2c2925;">Product Inventory</h4>
                <p class="small m-0" style="color: #8c857b;">Manage and monitor Japan surplus item stocks for your branch.</p>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <form method="GET" action="{{ route('staff.products.index') }}" class="card border-0 shadow-sm p-3 bg-white mb-4" style="border-radius: 20px !important; border: 1px solid #f0ece1 !important;">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text border-end-0 text-muted" style="background-color: #f7f5f0; border-color: #f0ece1; border-radius: 12px 0 0 12px;">
                        <i class="fa-solid fa-magnifying-glass" style="color: #e2062c;"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 shadow-none text-dark" placeholder="Search product or SKU..." style="font-size: 13px; background-color: #f7f5f0; border-color: #f0ece1; border-radius: 0 12px 12px 0;" onchange="this.form.submit()">
                </div>
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <select name="category_id" class="form-select form-select-sm text-dark fw-semibold py-2 px-3" style="font-size: 13px; border-radius: 12px; background-color: #f7f5f0; border: 1px solid #f0ece1; color: #2c2925 !important;" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <!-- 1. DESKTOP VIEW: Table / List Style -->
        <div class="desktop-view-container card border-0 shadow-sm bg-white overflow-hidden" style="border-radius: 20px !important; border: 1px solid #f0ece1 !important;">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 13px;">
                    <thead style="font-size: 11px; text-transform: uppercase; background-color: #f7f5f0; color: #8c857b !important;">
                        <tr>
                            <th class="py-3 px-4">Image</th>
                            <th class="py-3">Product</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 text-center">Stock</th>
                            <th class="py-3 text-end px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            @php
                                $stockRecord = $product->inventories->first();
                                $branchStock = $stockRecord ? $stockRecord->current_stock : 0;
                            @endphp
                            <tr style="border-color: #f0ece1;">
                                <td class="py-3 px-4">
                                    <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: #f7f5f0;">
                                        @if($product->image)
                                            <img src="{{ asset('images/products/' . basename($product->image)) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fa-solid fa-image text-muted" aria-hidden="true" style="font-size: 18px;"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="fw-bold d-block" style="color: #2c2925;">{{ $product->name }}</span>
                                    <span class="small" style="color: #8c857b;">{{ $product->sku }}</span>
                                </td>
                                <td class="py-3" style="color: #8c857b;">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td class="py-3 fw-semibold" style="color: #e2062c;">₱{{ number_format($product->price, 2) }}</td>
                                <td class="py-3 text-center">
                                    @if($branchStock <= 0)
                                        <span class="badge px-2.5 py-1" style="font-size: 11px; background-color: #fef2f2; color: #e2062c; border: 1px solid rgba(200, 90, 83, 0.2);">Out of Stock</span>
                                    @elseif($branchStock <= 5)
                                        <span class="badge px-2.5 py-1" style="font-size: 11px; background-color: #fffbeb; color: #d97706; border: 1px solid rgba(217, 119, 6, 0.2);">{{ $branchStock }} low stock</span>
                                    @else
                                        <span class="badge px-2.5 py-1" style="font-size: 11px; background-color: #f0fdf4; color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">{{ $branchStock }} in stock</span>
                                    @endif
                                </td>
                                <td class="py-3 text-end px-4">
                                    <a href="{{ route('staff.products.show', $product->id) }}" class="btn btn-sm text-white px-3 py-1.5 fw-semibold shadow-sm text-decoration-none d-inline-flex align-items-center gap-1 border-0" style="border-radius: 10px; font-size: 12px; background-color: #e2062c;">
                                        <i class="fa-solid fa-eye" style="font-size: 11px;"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5" style="color: #8c857b;">No products found for your branch.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. MOBILE VIEW: Square Cards Grid Style -->
        <div class="mobile-square-container row g-2">
            @forelse($products as $product)
                @php
                    $stockRecord = $product->inventories->first();
                    $branchStock = $stockRecord ? $stockRecord->current_stock : 0;
                @endphp
                <div class="col-6">
                    <div class="card border-0 shadow-sm p-2 bg-white h-100 position-relative d-flex flex-column justify-content-between" style="border-radius: 16px !important; border: 1px solid #f0ece1 !important;">
                        
                        <!-- Badge -->
                        <div class="position-absolute top-0 end-0 m-2 z-2">
                            @if($branchStock <= 0)
                                <span class="badge px-1.5 py-0.5" style="font-size: 8.5px; background-color: #fef2f2; color: #e2062c; border: 1px solid rgba(200, 90, 83, 0.2);">Out</span>
                            @elseif($branchStock <= 5)
                                <span class="badge px-1.5 py-0.5" style="font-size: 8.5px; background-color: #fffbeb; color: #d97706; border: 1px solid rgba(217, 119, 6, 0.2);">{{ $branchStock }} low</span>
                            @else
                                <span class="badge px-1.5 py-0.5" style="font-size: 8.5px; background-color: #f0fdf4; color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">{{ $branchStock }} stock</span>
                            @endif
                        </div>

                        <!-- Image Box -->
                        <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center mb-2" style="height: 100px; background-color: #f7f5f0;">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . basename($product->image)) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fa-solid fa-image text-muted" aria-hidden="true" style="font-size: 20px;"></i>
                            @endif
                        </div>

                        <!-- Details -->
                        <div class="mb-2">
                            <h6 class="fw-bold mb-1 text-truncate" style="font-size: 12px; color: #2c2925;">{{ $product->name }}</h6>
                            <span class="d-block text-truncate" style="font-size: 10px; color: #8c857b;">SKU: {{ $product->sku }}</span>
                        </div>

                        <!-- Price & Button -->
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: #f7f5f0 !important;">
                            <span class="fw-bold" style="font-size: 12px; color: #e2062c;">₱{{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('staff.products.show', $product->id) }}" class="btn btn-sm text-white px-2.5 py-1 fw-semibold shadow-sm border-0 text-decoration-none" style="border-radius: 8px; font-size: 10.5px; background-color: #e2062c;">
                                View
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 bg-white rounded-4 shadow-sm" style="border-radius: 16px !important; border: 1px solid #f0ece1 !important;">
                    <p class="mb-0 small" style="color: #8c857b;">No products found for your branch.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>
@endsection