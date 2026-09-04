@extends('layouts.app')

@section('title', 'POS Terminal - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <!-- Japanese Warm Neutral Minimalist Background -->
    <div style="background-color: #ffffff; min-height: calc(100vh - 70px); padding: 16px; font-family: 'Inter', sans-serif;">

        <form method="GET" action="{{ route('staff.pos') }}" id="posFilterForm">
            <div class="row g-3">
                <!-- KALIWA: Product Catalog, Search & Categories -->
                <div class="col-lg-8">

                    <!-- Search Bar -->
                    <div class="card border-0 shadow-sm rounded-pill p-1 bg-white mb-3" style="border: 1px solid #eae5d9 !important;">
                        <div class="input-group align-items-center">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fa-solid fa-magnifying-glass" style="color: #b22222;"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none text-dark ps-2" placeholder="Search product name or SKU..." style="font-size: 13.5px;" onchange="this.form.submit()">
                        </div>
                    </div>

                    <!-- Categories (Japanese Zen Scroll Style) -->
                    <div class="d-flex gap-2 overflow-auto pb-2 mb-3" style="scrollbar-width: none;">
                        <input type="hidden" name="category_id" id="categoryIdInput" value="{{ request('category_id') }}">

                        <!-- All Products Button -->
                        <button type="button" onclick="filterCategory('')" class="btn btn-sm px-4 fw-semibold flex-shrink-0 shadow-sm border-0 rounded-pill" style="font-size: 13px; background-color: {{ request('category_id') == '' ? '#e2062c' : '#ffffff' }}; color: {{ request('category_id') == '' ? '#ffffff' : '#5c554b' }};">
                            All
                        </button>

                        <!-- Loop Categories -->
                        @foreach($categories as $cat)
                            <button type="button" onclick="filterCategory('{{ $cat->id }}')" class="btn btn-sm px-4 fw-semibold flex-shrink-0 shadow-sm border-0 rounded-pill" style="font-size: 13px; background-color: {{ request('category_id') == $cat->id ? '#e2062c' : '#ffffff' }}; color: {{ request('category_id') == $cat->id ? '#ffffff' : '#5c554b' }};">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Product Cards Grid -->
                    <div class="row g-2 g-md-3">
                        @forelse($products as $product)
                            @php
                                $stockRecord = $product->inventories->first();
                                $branchStock = $stockRecord ? $stockRecord->current_stock : 0;
                            @endphp
                            <div class="col-6 col-md-4">
                                <div class="card border-0 shadow-sm p-3 bg-white h-100 position-relative transition-all" style="cursor: pointer; border-radius: 20px !important; border: 1px solid #f0ece1 !important;">
                                    <div class="badge bg-light text-dark border position-absolute top-0 end-0 m-3 px-2 py-1 rounded-pill" style="font-size: 10px; z-index: 2; background-color: #f7f5f0 !important; color: #5c554b !important;">
                                        Qty: {{ $branchStock }}
                                    </div>
                                    <div class="rounded-4 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 110px; background-color: #f7f5f0;">
                                        @if($product->image)
                                            <img src="{{ asset('images/products/' . basename($product->image)) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fa-solid fa-image text-muted" aria-hidden="true" style="font-size: 24px;"></i>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 13px; color: #2c2925 !important;">{{ $product->name }}</h6>
                                    <span class="text-muted small mb-2 d-block text-truncate" style="font-size: 11px; color: #8c857b !important;">{{ $product->sku }}</span>
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-1">
                                        <span class="fw-bold" style="font-size: 13.5px; color: #e2062c;">₱{{ number_format($product->price, 2) }}</span>
                                        <button type="button" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $branchStock }})" class="btn btn-sm text-white px-2.5 py-1 fw-semibold shadow-sm border-0" style="border-radius: 10px; font-size: 12px; background-color: #e2062c;" {{ $branchStock <= 0 ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm" style="border-radius: 20px !important;">
                                <div class="text-muted opacity-50 mb-2" style="font-size: 32px;"><i class="fa-solid fa-box-open"></i></div>
                                <p class="text-muted mb-0">No products available for your branch.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>

                <!-- KANAN: My Order / Cart Summary Panel -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 bg-white sticky-top" style="top: 20px; border-radius: 24px !important; border: 1px solid #f0ece1 !important;">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold m-0" style="font-size: 17px; color: #2c2925;">My Order</h5>
                            <button type="button" onclick="clearCart()" class="btn text-muted border-0 rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 34px; height: 34px; background-color: #f7f5f0;" title="Clear Order">
                                <i class="fa-solid fa-trash-can" style="font-size: 13px; color: #8c857b;"></i>
                            </button>
                        </div>

                        <!-- Order Type Tabs -->
                        <div class="d-flex p-1 rounded-pill mb-3" style="gap: 4px; background-color: #f7f5f0;">
                            <input type="radio" class="btn-check" name="order_type" id="walkIn" value="walk-in" checked>
                            <label class="flex-fill btn btn-sm fw-semibold text-white shadow-sm border-0 py-2 text-center rounded-pill" for="walkIn" style="font-size: 12px; background-color: #2c2925; cursor: pointer;">Walk-in</label>

                            <input type="radio" class="btn-check" name="order_type" id="pickUp" value="pickup">
                            <label class="flex-fill btn btn-sm fw-semibold border-0 py-2 text-center rounded-pill" for="pickUp" style="font-size: 12px; color: #8c857b; cursor: pointer;">Pick Up</label>

                            <input type="radio" class="btn-check" name="order_type" id="delivery" value="delivery">
                            <label class="flex-fill btn btn-sm fw-semibold border-0 py-2 text-center rounded-pill" for="delivery" style="font-size: 12px; color: #8c857b; cursor: pointer;">Delivery</label>
                        </div>

                        <!-- Cart Items List Container -->
                        <div class="cart-items mb-3 border-bottom pb-3" style="max-height: 220px; overflow-y: auto; border-color: #f0ece1 !important;">
                            <div class="py-4 text-center d-flex flex-column justify-content-center align-items-center">
                                <div class="text-muted opacity-50 mb-2" style="font-size: 28px;"><i class="fa-solid fa-basket-shopping" style="color: #d1cdc7;"></i></div>
                                <span class="text-muted small" style="color: #8c857b;">No items added yet.</span>
                            </div>
                        </div>

                        <!-- Totals Summary Preview -->
                        <div class="d-flex flex-column gap-2 mb-4" style="font-size: 13.5px;">
                            <div class="d-flex justify-content-between" style="color: #8c857b;">
                                <span>Subtotal</span>
                                <span class="fw-semibold text-dark">₱0.00</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: #f0ece1 !important;">
                                <span class="fw-bold text-dark" style="font-size: 15px; color: #2c2925;">Total Amount</span>
                                <span class="fw-bold fs-4" style="color: #e2062c;">₱0.00</span>
                            </div>
                        </div>

                        <!-- Proceed Button -->
                        <button type="button" onclick="proceedToCheckout()" class="btn w-100 py-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-2 border-0" style="border-radius: 16px; font-size: 14px; background-color: #e2062c;">
                            <span>Proceed to Checkout</span> <i class="fa-solid fa-arrow-right" style="font-size: 14px;"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <script src="{{ asset('js/pos.js') }}"></script>
@endsection