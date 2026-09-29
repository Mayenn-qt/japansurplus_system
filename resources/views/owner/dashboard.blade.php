@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Sidebar -->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')
     <div class="page-selection active-page" id="page-dashboard">
            
            <!-- Header & Quick Actions -->
            <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
                <div>
                    <h4 class="text-black mb-1 fw-bold">
                        Welcome back, <span id="dashName">{{ $user->name ?? 'Admin' }}</span>!
                    </h4>
                    <p class="text-black-50 mb-0" style="font-size: 13.5px;">
                        Store sales performance and customer reach overview.
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('owner.customers') }}" class="btn btn-outline-dark btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px;">
                        <i class="fa-solid fa-address-book"></i> Contacts
                    </a>
                    <a href="{{ route('owner.sms') }}" class="btn btn-dark btn-sm px-3 shadow-sm d-flex align-items-center gap-1" style="border-radius: 8px; background-color: #0f172a; border-color: #0f172a;">
                        <i class="fa-solid fa-paper-plane"></i> Send SMS Update
                    </a>
                </div>
            </div>
            
            <!-- SALES METRICS ROW -->
            <div class="row g-3 mb-4">
                <!-- Today Sales -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm" style="border-left: 4px solid #dc3545 !important;">
                        <span class="text-black-50 small fw-medium d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Today's Sales</span>
                        <h3 class="fw-bold mb-0 text-black">₱ {{ number_format($todaySales ?? 0, 2) }}</h3>
                    </div>
                </div>

                <!-- This Week Sales -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm" style="border-left: 4px solid #f59e0b !important;">
                        <span class="text-black-50 small fw-medium d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">This Week</span>
                        <h3 class="fw-bold mb-0 text-black">₱ {{ number_format($weekSales ?? 0, 2) }}</h3>
                    </div>
                </div>

                <!-- This Month Sales -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm" style="border-left: 4px solid #10b981 !important;">
                        <span class="text-black-50 small fw-medium d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">This Month</span>
                        <h3 class="fw-bold mb-0 text-black">₱ {{ number_format($monthSales ?? 0, 2) }}</h3>
                    </div>
                </div>

                <!-- This Year Sales -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm" style="border-left: 4px solid #6366f1 !important;">
                        <span class="text-black-50 small fw-medium d-block mb-1 text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">This Year</span>
                        <h3 class="fw-bold mb-0 text-black">₱ {{ number_format($yearSales ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- TOTAL PRODUCTS & TOTAL CUSTOMERS ROW -->
            <div class="row g-3 mb-4">
                <div class="col-xl-6 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm" style="border-left: 4px solid #0f172a !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-black-50 small fw-medium d-block text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Total Products</span>
                                <h3 class="fw-bold mb-0 text-black">{{ number_format($totalProducts ?? 0) }}</h3>
                            </div>
                            <span class="badge bg-light text-dark border px-2.5 py-1" style="font-size: 0.75rem;">Surplus Items</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm" style="border-left: 4px solid #0ea5e9 !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-black-50 small fw-medium d-block text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Total Customers</span>
                                <h3 class="fw-bold mb-0 text-black">{{ number_format($totalCustomers ?? 0) }}</h3>
                            </div>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1" style="font-size: 0.75rem;">Profiles Database</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT SALES TABLE SECTION -->
            <div class="dashboard-card p-4 shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-black m-0">Recent Sales</h6>
                    <span class="text-muted small">Latest transactions log</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover" style="font-size: 13px;">
                        <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-3 px-3">Branch</th>
                                <th class="py-3 px-3">Items Summary</th>
                                <th class="py-3 px-3 text-center">Total Amount</th>
                                <th class="py-3 px-3">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales ?? [] as $sale)
                                <tr>
                                    <td class="py-3 px-3 fw-semibold text-dark">{{ $sale->user?->name ?? 'Walk-in Customer' }}</td>
                                    <td class="py-3 px-3 text-muted">
                                        @forelse($sale->items as $item)
                                            <span class="d-block">{{ $item->product?->name ?? 'Product removed' }} x{{ $item->quantity }}</span>
                                        @empty
                                            <span>Items unavailable</span>
                                        @endforelse
                                    </td>
                                    <td class="py-3 px-3 text-center fw-bold text-dark">₱ {{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="py-3 px-3 text-muted small">{{ $sale->created_at?->format('M d, Y h:i A') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No recent sales recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection