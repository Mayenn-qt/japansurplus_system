@extends('layouts.app')

@section('title', 'POS Terminal - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

  <link rel="stylesheet" href="{{ asset('css/pos.css') }}">

    <div class="pos-screen">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show pos-alert" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show pos-alert" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="GET" action="{{ route('staff.pos') }}" id="posFilterForm">
            <div class="pos-layout">
                <section class="pos-catalog" aria-label="Product catalog">
                    

                    <div class="pos-search mb-3">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search item name or SKU..." aria-label="Search item name or SKU" onchange="this.form.submit()">
                    </div>

                    
                    <div class="pos-categories" aria-label="Filter by category">
                        <input type="hidden" name="category_id" id="categoryIdInput" value="{{ request('category_id') }}">

                        <button type="button" onclick="filterCategory('')" class="pos-category {{ request('category_id') == '' ? 'active' : '' }}">
                            All stock
                        </button>

                        @foreach($categories as $cat)
                            <button type="button" onclick="filterCategory('{{ $cat->id }}')" class="pos-category {{ request('category_id') == $cat->id ? 'active' : '' }}">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>

                    <div class="pos-products-grid">
                        @forelse($products as $product)
                            @php
                                $stockRecord = $product->inventories->first();
                                $currentStock = (int) ($stockRecord?->current_stock ?? 0);
                            @endphp
                            <article class="pos-product">
                                <div class="pos-product-image">
                                    @if($product->image)
                                        <img src="{{ asset('images/products/' . basename($product->image)) }}" alt="{{ $product->name }}" loading="lazy">
                                    @else
                                        <i class="fa-solid fa-box-open text-secondary" aria-hidden="true" style="font-size: 25px;"></i>
                                    @endif
                                    <span class="pos-stock {{ $currentStock > 0 ? '' : 'out' }}">
                                        {{ $currentStock }} IN STOCK
                                    </span>
                                </div>
                                <div class="pos-product-body">
                                    <h3 class="pos-product-name" title="{{ $product->name }}">{{ $product->name }}</h3>
                                    <span class="pos-product-sku">{{ $product->sku }}</span>
                                    <div class="pos-product-footer">
                                        <span class="pos-price">₱{{ number_format($product->price, 2) }}</span>
                                        <div class="pos-product-actions">
                                            <button type="button" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $currentStock }})" class="pos-add-button" {{ $currentStock <= 0 ? 'disabled' : '' }} title="Add paid item" aria-label="Add {{ $product->name }} to order">
                                                <i class="fa-solid fa-plus" aria-hidden="true"></i> Add
                                            </button>
                                            <button type="button" onclick="addFreeItem({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $currentStock }})" class="pos-gift-button" {{ $currentStock <= 0 ? 'disabled' : '' }} title="Add free item" aria-label="Add {{ $product->name }} as a free item">
                                                <i class="fa-solid fa-gift" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="pos-empty">
                                <i class="fa-solid fa-box-open" aria-hidden="true"></i>
                                No products available for your branch.
                            </div>
                        @endforelse
                    </div>

                    <div class="pos-pagination">
                        {{ $products->links() }}
                    </div>
                </section>

                <aside class="pos-order-panel" aria-label="Current order">
                    <div class="pos-order-heading">
                        <div>
                            <span class="pos-order-kicker">Order slip <span class="pos-order-count" id="posCartCount">0 items</span></span>
                            <h2>My Order</h2>
                        </div>
                        <button type="button" onclick="clearCart()" class="pos-clear" title="Clear order" aria-label="Clear order">
                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="cart-items">
                            <div class="py-4 text-center d-flex flex-column justify-content-center align-items-center">
                                <div class="text-muted opacity-50 mb-2" style="font-size: 26px;"><i class="fa-solid fa-basket-shopping" style="color: #a9b4a8;"></i></div>
                                <span class="text-muted small">No items added yet.</span>
                            </div>
                    </div>

                    <div class="pos-summary">
                            <div class="pos-summary-row">
                                <span>Subtotal</span>
                                <span class="fw-semibold text-dark" id="posSubtotal">₱0.00</span>
                            </div>
                            <div class="pos-summary-row pos-summary-total">
                                <span>Total Amount</span>
                                <strong class="fs-4" id="posGrandTotal">₱0.00</strong>
                            </div>
                    </div>

                    <button type="button" onclick="proceedToCheckout()" class="pos-checkout d-flex align-items-center justify-content-center gap-2">
                        Checkout <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </aside>

            </div>
        </form>

    </div>

    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                <form action="{{ route('staff.sales.store') }}" method="POST" onsubmit="return prepareCheckoutData();">
                    @csrf
                    <input type="hidden" name="cart_data" id="cartDataInput">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold"><i class="fa-solid fa-cash-register text-danger me-2"></i>Checkout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-7">
                                <h6 class="fw-bold mb-3">Order Summary</h6>
                                <div id="checkoutModalItems" class="border rounded-3 p-3" style="max-height: 260px; overflow-y: auto;"></div>
                            </div>
                            <div class="col-md-5">
                                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Total</span><strong id="checkoutTotal">₱0.00</strong></div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Discount</label>
                                    <div class="input-group"><span class="input-group-text">₱</span><input type="number" min="0" step="0.01" name="discount" id="manualDiscount" class="form-control" value="0" oninput="updateCheckoutTotals()"></div>
                                </div>
                                <div class="d-flex justify-content-between mb-3"><span class="text-muted">Amount Due</span><strong class="text-danger" id="checkoutDue">₱0.00</strong></div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Cash Tendered</label>
                                    <div class="input-group"><span class="input-group-text">₱</span><input type="number" min="0" step="0.01" name="money_received" id="cashTendered" class="form-control" required oninput="updateCheckoutTotals()"></div>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-3"><span class="fw-bold">Change</span><strong class="text-success" id="checkoutChange">₱0.00</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light"><button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-danger px-4">Complete Sale</button></div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/pos.js') }}"></script>
@endsection