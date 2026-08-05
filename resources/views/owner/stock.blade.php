@extends('layouts.app')

@section('title', 'Sales Recording - Ohaiyo Japan Surplus')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stock.css') }}">

    <!--Sidebar-->
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
                        <p class="text-muted mb-0" style="font-size:13.5px;">Real-time inventory levels and warehouse tracking for <strong>Naga Branch</strong></p>
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

                <!-- Filters & Search Toolbar -->
                <div class="card mb-3 border-0 shadow-sm rounded-3" style="background-color: var(--bs-card-bg, #fff);">
                    <div class="p-3 d-flex gap-3 flex-wrap align-items-center justify-content-between">
                        <div class="search-box flex-grow-1 d-flex align-items-center px-3 py-2 rounded-2 border bg-light" style="min-width:280px;">
                            <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                            <input type="text" placeholder="Search by product name or SKU..." style="border:none; background:transparent; outline:none; font-size:13.5px; width:100%; color: var(--ink);">
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <select class="form-select border-0 bg-light px-3 py-2" style="border-radius:8px; font-size:13px; font-weight: 500;">
                                <option>All Categories</option>
                                <option>Appliances</option>
                                <option>Electronics</option>
                                <option>Furniture</option>
                            </select>
                            <select class="form-select border-0 bg-light px-3 py-2" style="border-radius:8px; font-size:13px; font-weight: 500;">
                                <option>All Stock Levels</option>
                                <option>Healthy Stock</option>
                                <option>Below Reorder Level</option>
                                <option>Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Main Data Table -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="background-color: var(--bs-card-bg, #fff);">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-3 ps-4">Product Details</th>
                                    <th class="py-3">Current Stock</th>
                                    <th class="py-3">Reorder Level</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 pe-4 text-end">Quick Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-2 bg-light border d-flex align-items-center justify-content-center text-danger flex-shrink-0" style="width: 40px; height: 40px;"><i class="fa-solid fa-bowl-rice"></i></div>
                                            <div><span class="fw-semibold d-block text-dark" style="font-size: 14px;">Panasonic Rice Cooker</span><span class="text-muted" style="font-size: 11.5px;">SKU: PRC-8821</span></div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark">8 units</td>
                                    <td><span class="text-muted fw-medium">5 units</span></td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Healthy</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm" title="Stock Out" style="border-radius: 6px;"><i class="fa-solid fa-arrow-down text-danger" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm" title="Stock In" style="border-radius: 6px;"><i class="fa-solid fa-arrow-up text-success" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-2 bg-light border d-flex align-items-center justify-content-center text-primary flex-shrink-0" style="width: 40px; height: 40px;"><i class="fa-solid fa-tv"></i></div>
                                            <div><span class="fw-semibold d-block text-dark" style="font-size: 14px;">Toshiba TV 32"</span><span class="text-muted" style="font-size: 11.5px;">SKU: TV-32-TSB</span></div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark">1 unit</td>
                                    <td><span class="text-muted fw-medium">3 units</span></td>
                                    <td><span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Below Reorder</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm" title="Stock Out" style="border-radius: 6px;"><i class="fa-solid fa-arrow-down text-danger" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm" title="Stock In" style="border-radius: 6px;"><i class="fa-solid fa-arrow-up text-success" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-2 bg-light border d-flex align-items-center justify-content-center text-warning flex-shrink-0" style="width: 40px; height: 40px;"><i class="fa-solid fa-volume-high"></i></div>
                                            <div><span class="fw-semibold d-block text-dark" style="font-size: 14px;">Sony Speaker Set</span><span class="text-muted" style="font-size: 11.5px;">SKU: SPK-SN-99</span></div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark">0 units</td>
                                    <td><span class="text-muted fw-medium">3 units</span></td>
                                    <td><span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Out of Stock</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm" title="Stock Out" style="border-radius: 6px;"><i class="fa-solid fa-arrow-down text-danger" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm" title="Stock In" style="border-radius: 6px;"><i class="fa-solid fa-arrow-up text-success" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-2 bg-light border d-flex align-items-center justify-content-center text-success flex-shrink-0" style="width: 40px; height: 40px;"><i class="fa-solid fa-chair"></i></div>
                                            <div><span class="fw-semibold d-block text-dark" style="font-size: 14px;">Office Swivel Chair</span><span class="text-muted" style="font-size: 11.5px;">SKU: CHR-SW-01</span></div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark">15 units</td>
                                    <td><span class="text-muted fw-medium">5 units</span></td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Healthy</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm" title="Stock Out" style="border-radius: 6px;"><i class="fa-solid fa-arrow-down text-danger" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm" title="Stock In" style="border-radius: 6px;"><i class="fa-solid fa-arrow-up text-success" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-2 bg-light border d-flex align-items-center justify-content-center text-info flex-shrink-0" style="width: 40px; height: 40px;"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                                            <div><span class="fw-semibold d-block text-dark" style="font-size: 14px;">Makita Cordless Drill</span><span class="text-muted" style="font-size: 11.5px;">SKU: MKT-DR-55</span></div>
                                        </div>
                                    </td>
                                    <td class="fw-semibold text-dark">10 units</td>
                                    <td><span class="text-muted fw-medium">4 units</span></td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2" style="font-weight: 500; font-size: 11.5px;">Healthy</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm" title="Stock Out" style="border-radius: 6px;"><i class="fa-solid fa-arrow-down text-danger" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm" title="Stock In" style="border-radius: 6px;"><i class="fa-solid fa-arrow-up text-success" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Stock In Modal (UI Preview Only) -->
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
                                <option value="1">Panasonic Rice Cooker</option>
                                <option value="2">Toshiba TV 32"</option>
                                <option value="3">Sony Speaker Set</option>
                                <option value="4">Office Swivel Chair</option>
                                <option value="5">Makita Cordless Drill</option>
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

    <!-- Stock Out Modal (UI Preview Only) -->
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
                                <option value="1">Panasonic Rice Cooker</option>
                                <option value="2">Toshiba TV 32"</option>
                                <option value="3">Sony Speaker Set</option>
                                <option value="4">Office Swivel Chair</option>
                                <option value="5">Makita Cordless Drill</option>
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