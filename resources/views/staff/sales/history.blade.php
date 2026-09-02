@extends('layouts.app')

@section('title', 'Sales History - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px); padding: 20px; font-family: 'Inter', sans-serif;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Sales History</h4>
                <p class="text-muted small mb-0">List of all completed branch transactions.</p>
            </div>
            <a href="{{ route('staff.pos') }}" class="btn btn-dark btn-sm px-3 fw-semibold rounded-pill">
                <i class="fa-solid fa-cash-register me-1"></i> Back to POS
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
@endsection