@extends('layouts.app')

@section('title', 'Sales Recording - Ohaiyo Japan Surplus')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sales.css') }}">

    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content">

           
            <div class="page-section active-page" id="page-pos">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0">Sales Recording & POS</h5>
                        <p class="text-muted mb-0" style="font-size:13px;">Main Branch — Terminal 01</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="chip bg-light text-dark border"><i class="fa-solid fa-cash-register me-1 text-primary"></i> Register: Open</span>
                        <span class="chip"><i class="fa-solid fa-receipt me-1"></i> Invoice: <b>INV-10232</b></span>
                    </div>
                </div>
                
                <div class="row g-3">

                    <!-- Product Selection Area -->
                    <div class="col-lg-8">

                        <!-- Search & Categories Card -->
                        <div class="card p-3 mb-3 border-0 shadow-sm">
                            <div class="search-box w-100 mb-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" placeholder="Scan barcode (e.g., SKU-HS-8839) or search product name..." style="border:none; background:transparent; outline:none; font-size:13.5px; width:100%;">
                            </div>
                            
                            <!-- Category Filter Pills -->
                            <div class="d-flex gap-2 overflow-auto pb-1" style="white-space: nowrap;">
                                <button class="btn btn-sm btn-primary px-3 rounded-pill">All Items</button>
                                <button class="btn btn-sm btn-outline-secondary px-3 rounded-pill">Kitchenware</button>
                                <button class="btn btn-sm btn-outline-secondary px-3 rounded-pill">Tools & Hardware</button>
                                <button class="btn btn-sm btn-outline-secondary px-3 rounded-pill">Furniture</button>
                                <button class="btn btn-sm btn-outline-secondary px-3 rounded-pill">Electronics</button>
                            </div>
                        </div>

                        <!-- Product Grid -->
                        <div class="row g-2">
                            <div class="col-6 col-md-4">
                                <div class="pos-item">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-light text-muted border" style="font-size:10px;">SKU-HS-HS-001</span>
                                        <span class="text-success fw-semibold" style="font-size:11px;">5 units avail</span>
                                    </div>
                                    <img src="{{ asset('images/products/cabinet.jpg') }}" alt="Cabinet" class="prod-thumb">
                                    <div style="font-size:12.5px; font-weight:600; line-height:1.3;" class="text-truncate">Wooden Wardrobe
                                        Cabinet</div>
                                    <div class="mt-1"><b style="font-size:14px; color:var(--brand);">₱10,000.00</b></div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="pos-item">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-light text-muted border" style="font-size:10px;">SKU-HS-002</span>
                                        <span class="text-success fw-semibold" style="font-size:11px;">5 sets avail</span>
                                    </div>
                                    <img src="{{ asset('images/products/plateandbowl.jpg') }}" alt="Plate" class="prod-thumb">                                          
                                    <div style="font-size:12.5px; font-weight:600; line-height:1.3;" class="text-truncate">Ceramic Bowl & Plate Set</div>
                                    <div class="mt-1"><b style="font-size:14px; color:var(--brand);">₱450.00</b></div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="pos-item">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-light text-muted border" style="font-size:10px;">SKU-HS-003</span>
                                        <span class="text-success fw-semibold" style="font-size:11px;">15 units avail</span>
                                    </div>
                                    <img src="{{ asset('images/products/chair.jpg') }}" alt="chair" class="prod-thumb">
                                    <div style="font-size:12.5px; font-weight:600; line-height:1.3;" class="text-truncate">Office Swivel Chair</div>
                                    <div class="mt-1"><b style="font-size:14px; color:var(--brand);">₱1,200.00</b></div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="pos-item">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-light text-muted border" style="font-size:10px;">SKU-HS-104</span>
                                        <span class="text-success fw-semibold" style="font-size:11px;">10 units avail</span>
                                    </div>
                                    <img src="{{asset('images/products/luggage.jpg')}}" alt="luggage" class="prod-thumb">
                                    <div style="font-size:12.5px; font-weight:600; line-height:1.3;" class="text-truncate">Japanese Hard-Case Luggage </div>
                                    <div class="mt-1"><b style="font-size:14px; color:var(--brand);">₱1,450.00</b></div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="pos-item out-of-stock" style="opacity:.45; cursor:not-allowed;">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-light text-muted border" style="font-size:10px;">SKU-HS-105</span>
                                        <span class="text-danger fw-semibold" style="font-size:11px;">Sold Out</span>
                                    </div>
                                    <img src="{{asset('images/products/generator.jpg')}}" alt="generator" class="prod-thumb">
                                    <div style="font-size:12.5px; font-weight:600; line-height:1.3;" class="text-truncate">Denyo Gasoline Generator Set</div>
                                    <div class="mt-1"><b style="font-size:14px; color:var(--brand);">₱12,500.00</b></div>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="pos-item">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span class="badge bg-light text-muted border" style="font-size:10px;">SKU-HS-106</span>
                                        <span class="text-warning text-dark fw-semibold" style="font-size:11px;">5 units avail</span>
                                    </div>
                                    <img src="{{asset('images/products/chainsaw.jpg')}}" alt="Chainsaw" class="prod-thumb">
                                    <div style="font-size:12.5px; font-weight:600; line-height:1.3;" class="text-truncate">Shindaiwa Gasoline Engine Chainsaw</div>
                                    <div class="mt-1"><b style="font-size:14px; color:var(--brand);">₱4,200.00</b></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Transaction / Cart Area -->
                    <div class="col-lg-4">
                        <div class="card p-3 d-flex flex-column border-0 shadow-sm" style="min-height:560px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark">Current Transaction</span>
                                <span class="badge bg-secondary-subtle text-secondary" style="font-size:11px;">Walk-in Customer</span>
                            </div>

                            <!-- Cart Items Container -->
                            <div class="flex-grow-1 overflow-auto pe-1" style="max-height: 230px;">
                                <div class="cart-row">
                                    <div class="flex-grow-1">
                                        <div style="font-size:13px; font-weight:600;">Japanese Wooden Wardrobe Cabinet</div>
                                        <div class="text-muted" style="font-size:11.5px;">₱10,000.00 × 2</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="qty-box">-</div>
                                        <span class="mx-1 fw-semibold" style="font-size:13px;">2</span>
                                        <div class="qty-box">+</div>
                                        <button class="btn btn-sm text-danger p-0 ms-2" title="Remove"><i class="fa-solid fa-trash-can" style="font-size:12px;"></i></button>
                                    </div>
                                </div>

                                <div class="cart-row">
                                    <div class="flex-grow-1">
                                        <div style="font-size:13px; font-weight:600;">Shindaiwa Gasoline Engine Chainsaw</div>
                                        <div class="text-muted" style="font-size:11.5px;">₱4,200.00 × 1</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="qty-box">-</div>
                                        <span class="mx-1 fw-semibold" style="font-size:13px;">1</span>
                                        <div class="qty-box">+</div>
                                        <button class="btn btn-sm text-danger p-0 ms-2" title="Remove"><i class="fa-solid fa-trash-can" style="font-size:12px;"></i></button>
                                    </div>
                                </div>

                                <div class="cart-row">
                                    <div class="flex-grow-1">
                                        <div style="font-size:13px; font-weight:600;">Ceramic Plate & Bowl Set</div>
                                        <div class="text-muted" style="font-size:11.5px;">₱450.00 × 3</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="qty-box">-</div>
                                        <span class="mx-1 fw-semibold" style="font-size:13px;">3</span>
                                        <div class="qty-box">+</div>
                                        <button class="btn btn-sm text-danger p-0 ms-2" title="Remove"><i class="fa-solid fa-trash-can" style="font-size:12px;"></i></button>
                                    </div>
                                </div>
                            </div>

                            <!-- Totals & Payment Section -->
                            <div class="border-top pt-3 mt-2">
                                <div class="d-flex justify-content-between mb-1" style="font-size:13px;">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₱25,550.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" style="font-size:13px;">
                                    <span class="text-muted">Discount (0%)</span>
                                    <span>₱0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 p-2 bg-light rounded" style="font-size:16px; font-weight:700;">
                                    <span>Total Amount</span>
                                    <span class="text-primary">₱25,550.00</span>
                                </div>

                                <label class="small-caps">Cash Received</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bg-white">₱</span>
                                    <input type="text" class="form-control" value="30,000.00" style="border-radius:0 9px 9px 0;">
                                </div>

                               

                                <div class="d-flex justify-content-between mb-3 px-1" style="font-size:13.5px;">
                                    <span class="text-muted">Change</span>
                                    <b class="text-success fs-6">₱4,450.00</b>
                                </div>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-danger py-2 px-3" style="border-radius:9px;" title="Cancel Sale"><i class="fa-solid fa-ban"></i></button>
                                    <button class="btn btn-primary flex-grow-1 py-2 fw-semibold" style="border-radius:9px;"><i class="fa-solid fa-check me-1"></i> Complete Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection