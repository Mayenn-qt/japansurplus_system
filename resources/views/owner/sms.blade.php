@extends('layouts.app')

@section('title', 'SMS Notifications - Ohaiyo Japan Surplus')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

    <!-- Sidebar -->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div class="container-fluid px-4 py-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">SMS Notifications</h4>
                    <p class="text-muted mb-0" style="font-size: 13.5px;">Manage branch-specific customer broadcasts and track message history.</p>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <span class="text-muted text-uppercase fw-semibold d-block" style="font-size: 11px;">Total Branch Customers</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0">50 <span class="text-primary fs-6 fw-normal"><i class="fa-solid fa-users ms-1"></i></span></h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <span class="text-muted text-uppercase fw-semibold d-block" style="font-size: 11px;">Messages Sent Today</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0">35 <span class="text-success fs-6 fw-normal"><i class="fa-solid fa-paper-plane ms-1"></i></span></h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <span class="text-muted text-uppercase fw-semibold d-block" style="font-size: 11px;">Last Announcement</span>
                        <h4 class="fw-bold text-dark mt-1 mb-0" style="font-size: 15px;">Main Branch Promo</h4>
                    </div>
                </div>
            </div>

            <!-- Main Layout: Customer Contacts & Compose Message -->
            <div class="row g-4 mb-4">
                
                <!-- Left Panel: Customer Contacts Selection with Branch Filtering -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-3 h-100 bg-white overflow-hidden">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h6 class="fw-bold text-dark m-0">Customer Contacts</h6>
                            
                            <!-- Branch Filter & Search Controls -->
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 11px;"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Search..." style="font-size: 12px;">
                                </div>
                                <select class="form-select form-select-sm text-dark fw-medium" style="width: 140px; font-size: 12px;">
                                    <option value="all">All Branches</option>
                                    <option value="main" selected>Main Branch</option>
                                    <option value="juban">Juban Branch</option>
                                    <option value="magallanes">Magallanes</option>
                                </select>
                            </div>
                        </div>

                        <!-- Customer Table -->
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="bg-light text-muted text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">
                                    <tr>
                                        <th class="ps-3 py-2.5" style="width: 40px;">
                                            <input class="form-check-input" type="checkbox" checked id="selectAll">
                                        </th>
                                        <th class="py-2.5">Customer</th>
                                        <th class="py-2.5">Mobile Number</th>
                                        <th class="pe-3 py-2.5">Branch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-3"><input class="form-check-input" type="checkbox" checked></td>
                                        <td class="fw-medium text-dark">Aling Susan</td>
                                        <td class="text-muted">0917-123-4567</td>
                                        <td class="pe-3"><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 py-1" style="font-size: 11px;">Main</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3"><input class="form-check-input" type="checkbox" checked></td>
                                        <td class="fw-medium text-dark">Mr. King</td>
                                        <td class="text-muted">0917-987-6543</td>
                                        <td class="pe-3"><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 py-1" style="font-size: 11px;">Magallanesphp</span></td>
                                    </tr>

                                    <tr>
                                        <td class="ps-3"><input class="form-check-input" type="checkbox" checked></td>
                                        <td class="fw-medium text-dark">Don Juan</td>
                                        <td class="text-muted">0913-235-7643</td>
                                        <td class="pe-3"><span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-2 py-1" style="font-size: 11px;">Juban</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Compose Message & Preview -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">Compose Message</h6>
                        
                        <form>
                            <!-- Target Branch Indicator / Selection -->
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Target Branch Scope</label>
                                <select class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option value="main" selected>Main Branch Only</option>
                                    <option value="juban">Juban Branch Only</option>
                                    <option value="magallanes">Magallanes Branch Only</option>
                                    <option value="all">All Branches (Global Broadcast)</option>
                                </select>
                            </div>

                            <!-- Title Field -->
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Title</label>
                                <input type="text" class="form-control form-control-sm" value="Main Branch Arrival Announcement" style="border-radius: 8px;">
                            </div>

                            <!-- Message Content -->
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Message</label>
                                <textarea class="form-control form-control-sm" rows="4" style="border-radius: 8px; resize: none;">📢 MAIN BRANCH UPDATE!

New Japanese appliances are now available. Drop by our store today!</textarea>
                                <div class="d-flex justify-content-between mt-1 text-muted" style="font-size: 11px;">
                                    <span>Character counter:</span>
                                    <span class="fw-semibold text-dark">114 / 160</span>
                                </div>
                            </div>

                            <!-- SMS Preview Box -->
                            <div class="mb-4 p-3 bg-light rounded-3 border">
                                <span class="text-muted fw-semibold d-block mb-1" style="font-size: 11px;"><i class="fa-solid fa-mobile-screen-button me-1"></i> SMS Preview</span>
                                <div class="bg-white p-2.5 rounded border text-dark" style="font-size: 12.5px; line-height: 1.4;">
                                    <strong class="d-block text-secondary mb-1" style="font-size: 11px;">Ohaiyo Japan Surplus - Main</strong>
                                    📢 MAIN BRANCH UPDATE!<br>
                                    New Japanese appliances are now available.<br>
                                    Drop by our store today!
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-50 py-2" style="border-radius: 8px; font-size: 12.5px;">
                                    <i class="fa-regular fa-floppy-disk me-1"></i> Save Draft
                                </button>
                                <button type="submit" class="btn btn-dark btn-sm w-50 py-2 shadow-sm" style="border-radius: 8px; background-color: #0f172a; font-size: 12.5px;">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Send SMS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- SMS History Section -->
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark m-0">SMS History</h6>
                    <span class="badge bg-light text-dark border" style="font-size: 11px;">Main Branch Logs</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-3 py-2.5">Date</th>
                                <th class="py-2.5">Title</th>
                                <th class="py-2.5">Branch Scope</th>
                                <th class="py-2.5">Recipients</th>
                                <th class="pe-3 py-2.5">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 text-muted">Aug 7, 2026</td>
                                <td class="fw-medium text-dark">Main Branch Promo Alert</td>
                                <td><span class="badge bg-light text-dark border" style="font-size: 11px;">Main Branch</span></td>
                                <td>120 customers</td>
                                <td class="pe-3"><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-weight: 500;">Delivered</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection