@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div class="container-fluid px-4 py-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">SMS Notifications</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Broadcast text alerts, track message delivery status, and monitor SMS history</p>
                </div>
            </div>

            <!-- 1. Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-primary h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Sent (This Month)</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">1,420</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-paper-plane"></i> Broadcasted successfully</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-success h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Delivered</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">1,395</h3>
                        <span class="text-success small mt-1"><i class="fa-solid fa-check-double"></i> 98.2% Delivery Rate</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-warning h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Pending Queue</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">12</h3>
                        <span class="text-warning small mt-1"><i class="fa-solid fa-clock"></i> Processing dispatch</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-4 border-danger h-100">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Failed / Undelivered</span>
                        <h3 class="fw-bold text-dark mt-1 mb-0">13</h3>
                        <span class="text-danger small mt-1"><i class="fa-solid fa-triangle-exclamation"></i> Network error / invalid</span>
                    </div>
                </div>
            </div>

            <!-- Main Grid for Compose and Preview / History -->
            <div class="row g-4 mb-4">
                <!-- Compose Message & Recipient Selection -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <h6 class="fw-bold text-dark mb-3">Compose & Send SMS</h6>
                        <form>
                            <!-- Recipient Selection -->
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Recipient Selection</label>
                                <select class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option selected>All Customers</option>
                                    <option>Main Branch Customers</option>
                                    <option>Juban Branch Customers</option>
                                    <option>Magallanes Branch Customers</option>
                                    <option>Custom Number / Specific Client</option>
                                </select>
                            </div>

                            <!-- Compose Message Textarea -->
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Message Content</label>
                                <textarea class="form-control form-control-sm" rows="4" placeholder="Type your promotional message or alert here..." style="border-radius: 8px;"></textarea>
                                <div class="form-text text-muted" style="font-size: 11px;">Characters: 0 / 160 (1 SMS Part)</div>
                            </div>

                            <!-- SMS Preview Box -->
                            <div class="mb-4 p-3 bg-light rounded-3 border">
                                <span class="text-muted fw-semibold d-block mb-1" style="font-size: 11px;"><i class="fa-solid fa-eye me-1"></i> SMS Preview</span>
                                <p class="mb-0 text-dark" style="font-size: 13px; font-style: italic;">"Type your promotional message or alert here..."</p>
                            </div>

                            <!-- Send Button -->
                            <button type="submit" class="btn btn-dark btn-sm w-100 py-2 shadow-sm" style="border-radius: 8px; background-color: #0f172a;"><i class="fa-solid fa-paper-plane me-1"></i> Send SMS Broadcast</button>
                        </form>
                    </div>
                </div>

                <!-- SMS History & Delivery Status -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden bg-white">
                        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark m-0">SMS History & Delivery Status</h6>
                            <span class="badge bg-light text-dark border" style="font-size: 11px;">Recent Logs</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="bg-light text-muted text-uppercase" style="font-size: 10px;">
                                    <tr>
                                        <th class="ps-3 py-2">Recipient</th>
                                        <th class="py-2">Message Preview</th>
                                        <th class="py-2">Delivery Status</th>
                                        <th class="pe-3 py-2 text-end">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-3 fw-medium">0912-345-6789</td>
                                        <td class="text-muted text-truncate" style="max-width: 130px;">Your order #INV-1092 is ready...</td>
                                        <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Delivered</span></td>
                                        <td class="pe-3 text-end text-muted" style="font-size: 11px;">Apr 6, 2:42 PM</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-medium">0919-876-5432</td>
                                        <td class="text-muted text-truncate" style="max-width: 130px;">Flash sale alert: 20% off on...</td>
                                        <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Delivered</span></td>
                                        <td class="pe-3 text-end text-muted" style="font-size: 11px;">Apr 6, 11:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-medium">0920-111-2233</td>
                                        <td class="text-muted text-truncate" style="max-width: 130px;">Your account statement for...</td>
                                        <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Failed</span></td>
                                        <td class="pe-3 text-end text-muted" style="font-size: 11px;">Apr 5, 4:15 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection