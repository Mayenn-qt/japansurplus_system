@extends('layouts.app')

@section('title', $branch->branch_name . ' Operations - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

    @include('dashboard.sidebar')
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content">
            <div class="page-section active-page">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <a href="{{ route('owner.branch') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-2 mb-2">
                            <i class="fa-solid fa-arrow-left"></i> Branch Management
                        </a>
                        <h4 class="fw-bold mb-1" style="color: var(--ink); letter-spacing: -0.5px;">{{ $branch->branch_name }} Operations</h4>
                        <p class="text-muted mb-0" style="font-size:13.5px;">Sales operations overview for this branch</p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-3 h-100">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">Today's Sales</span>
                            <h4 class="fw-bold text-dark mt-2 mb-0">₱{{ number_format($todaysSales, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-3 h-100">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">This Week's Sales</span>
                            <h4 class="fw-bold text-dark mt-2 mb-0">₱{{ number_format($thisWeeksSales, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-3 h-100">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px; letter-spacing: 0.5px;">This Month's Sales</span>
                            <h4 class="fw-bold text-dark mt-2 mb-0">₱{{ number_format($thisMonthsSales, 2) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                            <div class="p-3 border-bottom bg-light">
                                <h6 class="fw-bold mb-0 text-dark">Recent Sales</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                                        <tr>
                                            <th class="py-3 ps-4">Date &amp; Time</th>
                                            <th class="py-3">Items</th>
                                            <th class="py-3">Total</th>
                                            <th class="py-3 pe-4">Staff</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentSales as $sale)
                                            <tr>
                                                <td class="ps-4 text-muted small">{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                                                <td class="text-secondary small">
                                                    @forelse($sale->items as $item)
                                                        <span class="d-block">{{ $item->product?->name ?? 'Product removed' }} x{{ $item->quantity }}</span>
                                                    @empty
                                                        <span class="text-muted">No items recorded</span>
                                                    @endforelse
                                                </td>
                                                <td class="fw-semibold text-dark">₱{{ number_format($sale->total_amount, 2) }}</td>
                                                <td class="pe-4 text-secondary">{{ $sale->user?->name ?? 'Unassigned' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted">No sales transactions recorded for this branch.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($recentSales->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $recentSales->links() }}
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="p-3 border-bottom bg-light">
                                <h6 class="fw-bold mb-0 text-dark">Branch Information</h6>
                            </div>
                            <div class="p-4">
                                <dl class="row mb-0 small">
                                    <dt class="col-5 text-muted">Branch Name</dt>
                                    <dd class="col-7 text-dark">{{ $branch->branch_name }}</dd>
                                    <dt class="col-5 text-muted">Location</dt>
                                    <dd class="col-7 text-dark">{{ $branch->address ?: 'Not specified' }}</dd>
                                    <dt class="col-5 text-muted">Assigned Staff</dt>
                                    <dd class="col-7 text-dark">
                                        @forelse($branch->users as $staff)
                                            <span class="d-block">{{ $staff->name }}</span>
                                        @empty
                                            No staff assigned
                                        @endforelse
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
