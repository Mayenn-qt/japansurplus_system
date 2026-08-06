@extends('layouts.app')

@section('title', 'Checkout - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="margin-left: 250px; margin-top: 70px; padding: 28px; background-color: #f8fafc; min-height: calc(100vh - 70px);">
        
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark m-0"><i class="fa-solid fa-cash-register text-danger me-2"></i> Order Checkout</h5>
                        <a href="{{ route('staff.sales.pos') }}" class="btn btn-outline-secondary btn-sm bg-white" style="font-size: 12px; border-color: #e2e8f0;"><i class="fa-solid fa-arrow-left me-1"></i> Back to POS</a>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold text-uppercase">Customer Information</label>
                        <input type="text" class="form-control bg-light border-0" value="Walk-in Customer" readonly style="font-size: 13.5px;">
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold text-uppercase">Payment Method</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="payment_method" id="cash" checked>
                                <label class="btn btn-outline-dark w-100 py-2 fw-semibold bg-light text-dark border-0 shadow-sm" for="cash" style="font-size: 13px;"><i class="fa-solid fa-money-bill-wave me-1 text-success"></i> Cash</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="payment_method" id="gcash">
                                <label class="btn btn-outline-dark w-100 py-2 fw-semibold bg-light text-dark border-0 shadow-sm" for="gcash" style="font-size: 13px;"><i class="fa-solid fa-mobile-screen me-1 text-primary"></i> GCash</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="payment_method" id="card">
                                <label class="btn btn-outline-dark w-100 py-2 fw-semibold bg-light text-dark border-0 shadow-sm" for="card" style="font-size: 13px;"><i class="fa-solid fa-credit-card me-1 text-warning"></i> Card</label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Computations -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Amount Due:</span>
                            <span class="fw-bold text-dark fs-5">₱1,050.00</span>
                        </div>
                        <div class="mb-2">
                            <label class="form-label text-muted small fw-semibold">Cash Received</label>
                            <input type="number" class="form-control fw-bold text-success fs-5" value="1500.00" style="border-radius: 8px;">
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="text-muted fw-semibold">Change:</span>
                            <span class="fw-bold text-danger fs-5">₱450.00</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary w-50 py-2 fw-semibold bg-white text-dark shadow-sm" style="border-radius: 8px; border-color: #e2e8f0;">
                            <i class="fa-solid fa-print me-1"></i> Print Receipt
                        </button>
                        <button type="button" class="btn btn-danger w-50 py-2 fw-semibold shadow-sm" style="border-radius: 8px;">
                            <i class="fa-solid fa-check-circle me-1"></i> Complete Sale
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection