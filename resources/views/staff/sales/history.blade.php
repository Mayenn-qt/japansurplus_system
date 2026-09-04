@extends('layouts.app')

@section('title', 'Sales History - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <!-- Responsive Styling: Table sa Desktop, Modern Cards sa Mobile -->
    <style>
        @media (max-width: 767.98px) {
            .desktop-view-container { display: none !important; }
            .mobile-card-container { display: block !important; }
        }
        @media (min-width: 768px) {
            .desktop-view-container { display: block !important; }
            .mobile-card-container { display: none !important; }
        }
    </style>

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px); padding: 20px; font-family: 'Inter', sans-serif;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Sales History</h4>
                <p class="small m-0 text-muted">Monitor and track previous branch transactions.</p>
            </div>
            <a href="{{ route('staff.pos', ['clear_cart' => 'true']) }}" class="btn btn-danger btn-sm px-3 rounded-pill">
    <i class="fa-solid fa-cash-register me-1"></i> New Sale
</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 1. DESKTOP VIEW: Table Layout -->
        <div class="desktop-view-container card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 13.5px;">
                    <thead class="bg-light text-muted" style="font-size: 11px; text-transform: uppercase;">
                        <tr>
                            <th class="py-3">Transaction ID</th>
                            <th class="py-3">Order Type</th>
                            <th class="py-3">Suki Discount</th>
                            <th class="py-3">Total Amount</th>
                            <th class="py-3">Cash / Change</th>
                            <th class="py-3">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td class="fw-bold text-dark">#POS-{{ $sale->id }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 text-uppercase" style="font-size: 10.5px;">
                                        {{ $sale->order_type }}
                                    </span>
                                </td>
                                <td>
                                    @if($sale->is_suki)
                                        <span class="text-success fw-semibold"><i class="fa-solid fa-check me-1"></i> Yes (-₱{{ number_format($sale->discount, 2) }})</span>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </td>
                                <td class="fw-bold text-danger">₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    <div class="small text-dark">Rec: ₱{{ number_format($sale->money_received, 2) }}</div>
                                    <div class="small text-muted">Change: ₱{{ number_format($sale->change, 2) }}</div>
                                </td>
                                <td class="text-muted small">{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open fs-3 mb-2 d-block opacity-50"></i>
                                    No sales history recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. MOBILE VIEW: Clean Vertical Stack Cards Layout -->
        <div class="mobile-card-container">
            <div class="d-flex flex-column gap-3">
                @forelse($sales as $sale)
                    <div class="card border-0 shadow-sm p-3 bg-white" style="border-radius: 16px !important; border: 1px solid #f0ece1 !important;">
                        
                        <!-- Top Row: ID and Order Type Badge -->
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: #f7f5f0 !important;">
                            <span class="fw-bold text-dark" style="font-size: 13px;">#POS-{{ $sale->id }}</span>
                            <span class="badge bg-light text-dark border px-2 py-1 text-uppercase" style="font-size: 9.5px;">
                                {{ $sale->order_type }}
                            </span>
                        </div>

                        <!-- Details Body -->
                        <div class="d-flex flex-column gap-1.5 mb-3" style="font-size: 12.5px;">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Amount:</span>
                                <span class="fw-bold text-danger" style="font-size: 14px;">₱{{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Suki Discount:</span>
                                <span>
                                    @if($sale->is_suki)
                                        <span class="text-success fw-semibold">Yes (-₱{{ number_format($sale->discount, 2) }})</span>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Cash Received:</span>
                                <span class="text-dark">₱{{ number_format($sale->money_received, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Change:</span>
                                <span class="text-dark">₱{{ number_format($sale->change, 2) }}</span>
                            </div>
                        </div>

                        <!-- Footer: Date & Time -->
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="font-size: 11px; border-color: #f7f5f0 !important;">
                            <span class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $sale->created_at->format('M d, Y h:i A') }}</span>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm" style="border-radius: 16px !important; border: 1px solid #f0ece1 !important;">
                        <i class="fa-solid fa-folder-open fs-3 mb-2 d-block opacity-50 text-muted"></i>
                        <p class="text-muted small mb-0">No sales history recorded yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $sales->links() }}
        </div>
    </div>
@endsection