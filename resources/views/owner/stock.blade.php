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

            <div class="page-section active-page" id="page-stock">
                
                <!-- Header & Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--ink); letter-spacing: -0.5px;">Stock Management</h4>
                        <p class="text-muted mb-0" style="font-size:13.5px;">Real-time inventory levels and multi-branch warehouse tracking</p>
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
                                    <h4 class="fw-bold mb-0" style="color: var(--ink);">35.4K</h4>
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
                                    <h4 class="fw-bold mb-0" style="color: var(--ink);">3 Products</h4>
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
                                    <h4 class="fw-bold mb-0" style="color: var(--ink);">1 Product</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refined Filters & Search Toolbar with Accent Colors & Filter Button -->
<div class="card mb-4 border-0 shadow-sm rounded-3" style="background-color: var(--bs-card-bg, #fff);">
    <div class="p-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
        
        <!-- Search Box with Integrated Filter Button -->
        <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 400px; min-width: 280px;">
            <div class="search-box d-flex align-items-center px-3 py-2 rounded-2 border bg-light flex-grow-1">
                <i class="fa-solid fa-magnifying-glass text-danger me-2" style="font-size: 13px;"></i>
                <input type="text" placeholder="Search product or SKU..." style="border:none; background:transparent; outline:none; font-size:13px; width:100%; color: var(--ink);">
            </div>
            <button class="btn btn-light border px-3 py-2 d-flex align-items-center gap-2 shadow-sm text-secondary" style="border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap;">
                <i class="fa-solid fa-filter text-danger" style="font-size: 12px;"></i> Filter
            </button>
        </div>

        <!-- Clean Filter Dropdowns with Colored Icons -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="input-group input-group-sm bg-light rounded-2 border" style="width: 170px;">
                <span class="input-group-text bg-transparent border-0 text-danger ps-2 pe-1" style="font-size: 12px;"><i class="fa-solid fa-store"></i></span>
                <select class="form-select form-select-sm border-0 bg-transparent shadow-none px-1" style="font-size: 12.5px; font-weight: 500;">
                    <option value="">All Branches</option>
                    <option>Main Branch</option>
                    <option>Gubat Branch</option>
                    <option>Naga Branch</option>
                </select>
            </div>

            <div class="input-group input-group-sm bg-light rounded-2 border" style="width: 170px;">
                <span class="input-group-text bg-transparent border-0 text-dark ps-2 pe-1" style="font-size: 12px;"><i class="fa-solid fa-sliders"></i></span>
                <select class="form-select form-select-sm border-0 bg-transparent shadow-none px-1" style="font-size: 12.5px; font-weight: 500;">
                    <option value="">All Stock Levels</option>
                    <option>Well Stocked</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
            </div>
        </div>

    </div>
</div>

                <!-- Stock Monitoring Table -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-5" style="background-color: var(--bs-card-bg, #fff);">
    <div class="p-3 border-bottom bg-light">
        <h6 class="fw-bold mb-0" style="color: var(--ink);">Stock Monitoring</h6>
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
                <tr>
                    <td class="ps-4 py-3 fw-semibold text-secondary">Main Branch</td>
                    <td class="fw-semibold text-dark">Minoyaki Ceramic Ramen Bowl</td>
                    <td><span class="text-muted" style="font-size: 11.5px;">MINO-RAM-01</span></td>
                    <td class="fw-semibold text-dark">15 units</td>
                    <td class="pe-4"><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Well Stocked</span></td>
                </tr>
                <tr>
                    <td class="ps-4 py-3 fw-semibold text-secondary">Main Branch</td>
                    <td class="fw-semibold text-dark">Handcrafted Damascus Santoku Knife</td>
                    <td><span class="text-muted" style="font-size: 11.5px;">DKN-SAN-99</span></td>
                    <td class="fw-semibold text-dark">15 units</td>
                    <td class="pe-4"><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Well Stocked</span></td>
                </tr>
                <tr>
                    <td class="ps-4 py-3 fw-semibold text-secondary">Main Branch</td>
                    <td class="fw-semibold text-dark">Retro Bandai Gundam Model Kit 1995</td>
                    <td><span class="text-muted" style="font-size: 11.5px;">BAN-GUN-95</span></td>
                    <td class="fw-semibold text-dark">4 units</td>
                    <td class="pe-4"><span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Low Stock</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

                <!-- Stock Movement History Table -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="background-color: var(--bs-card-bg, #fff);">
                    <div class="p-3 border-bottom bg-light">
                        <h6 class="fw-bold mb-0" style="color: var(--ink);">Stock Movement History</h6>
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
                                <tr>
                                    <td class="ps-4 py-3 text-muted" style="font-size: 13px;">Aug 02, 2026 07:10 AM</td>
                                    <td class="fw-semibold text-secondary">Main Branch</td>
                                    <td><span class="text-muted">RYO-PLN-08</span></td>
                                    <td class="fw-semibold text-dark">1 unit</td>
                                    <td><span class="badge border text-primary bg-light px-2 py-1" style="font-weight: 500; font-size: 11px;">Sale</span></td>
                                    <td>Aiko Tanaka</td>
                                    <td class="pe-4 text-muted" style="font-size: 13px;">Sold via POS</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3 text-muted" style="font-size: 13px;">Jul 26, 2026 02:47 AM</td>
                                    <td class="fw-semibold text-secondary">Gubat Branch</td>
                                    <td><span class="text-muted">RYO-PLN-08</span></td>
                                    <td class="fw-semibold text-dark">1 unit</td>
                                    <td><span class="badge border text-primary bg-light px-2 py-1" style="font-weight: 500; font-size: 11px;">Sale</span></td>
                                    <td>Sakura Ito</td>
                                    <td class="pe-4 text-muted" style="font-size: 13px;">Sold via POS</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3 text-muted" style="font-size: 13px;">Jul 26, 2026 02:40 AM</td>
                                    <td class="fw-semibold text-secondary">Main Branch</td>
                                    <td><span class="text-muted">MINO-RAM-01</span></td>
                                    <td class="fw-semibold text-dark">15 units</td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-2 py-1" style="font-weight: 500; font-size: 11px;">Stock In</span></td>
                                    <td>Kenji Sato (Owner)</td>
                                    <td class="pe-4 text-muted" style="font-size: 13px;">Initial system seeding</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Modals -->
    <!-- Stock In Modal -->
    <div class="modal fade" id="modalStockIn" tabindex="-1" aria-labelledby="modalStockInLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold" id="modalStockInLabel" style="color: var(--ink);">Stock In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <form action="#" method="GET" onsubmit="event.preventDefault(); alert('Stock In UI Preview Only!');">
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Product</label>
                            <select class="form-select bg-light border-0 py-2" style="border-radius: 8px; font-size: 13.5px;">
                                <option selected disabled>Select product...</option>
                                <option value="1">Minoyaki Ceramic Ramen Bowl</option>
                                <option value="2">Handcrafted Damascus Santoku Knife</option>
                                <option value="3">Retro Bandai Gundam Model Kit 1995</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Quantity to Add</label>
                            <input type="number" class="form-control bg-light border-0 py-2" placeholder="e.g. 20" style="border-radius: 8px; font-size: 13.5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Supplier / Source</label>
                            <input type="text" class="form-control bg-light border-0 py-2" placeholder="e.g. Japan Surplus Consolidator Co." style="border-radius: 8px; font-size: 13.5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Remarks</label>
                            <textarea class="form-control bg-light border-0" rows="3" placeholder="Add remarks here..." style="border-radius: 8px; font-size: 13.5px;"></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-size: 13.5px; font-weight: 500; background-color: #0f172a; border-color: #0f172a;">Confirm Stock In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Out Modal -->
    <div class="modal fade" id="modalStockOut" tabindex="-1" aria-labelledby="modalStockOutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-danger" id="modalStockOutLabel" style="color: var(--ink);">Stock Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <form action="#" method="GET" onsubmit="event.preventDefault(); alert('Stock Out UI Preview Only!');">
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Product</label>
                            <select class="form-select bg-light border-0 py-2" style="border-radius: 8px; font-size: 13.5px;">
                                <option selected disabled>Select product...</option>
                                <option value="1">Minoyaki Ceramic Ramen Bowl</option>
                                <option value="2">Handcrafted Damascus Santoku Knife</option>
                                <option value="3">Retro Bandai Gundam Model Kit 1995</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Quantity to Deduct</label>
                            <input type="number" class="form-control bg-light border-0 py-2" placeholder="e.g. 5" style="border-radius: 8px; font-size: 13.5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Reason / Destination</label>
                            <input type="text" class="form-control bg-light border-0 py-2" placeholder="e.g. Damaged, Branch Transfer, Sold" style="border-radius: 8px; font-size: 13.5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Remarks</label>
                            <textarea class="form-control bg-light border-0" rows="3" placeholder="Add remarks here..." style="border-radius: 8px; font-size: 13.5px;"></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4 py-2" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Confirm Stock Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection