@extends('layouts.app')

@section('title', 'Product Details - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stock.css')}}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px); padding: 20px;">
        
        <!-- Navigation Back -->
        <div class="mb-4">
            <a href="{{ route('staff.products.index') }}" class="text-decoration-none text-muted small fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
            </a>
            <h4 class="fw-bold text-dark mt-2 mb-0">Product Details</h4>
        </div>

        @php
            // Kunin ang branch stock ng kasalukuyang staff para sa produktong ito
            $stockRecord = $product->inventories->where('branch_id', $user->branch_id)->first();
            $branchStock = $stockRecord ? $stockRecord->current_stock : 0;
        @endphp

        <div class="row g-4">
            <!-- KALIWA: Product Image & Quick Info -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white text-center">
                    <div class="bg-light rounded-3 overflow-hidden d-flex align-items-center justify-content-center text-muted mb-4 mx-auto shadow-inner" style="width: 100%; height: 240px;">
                        <img src="{{ $product->image ? asset('images/products/'.$product->image) : asset('images/products/default.jpg') }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <span class="badge bg-light text-secondary border border-secondary border-opacity-25 px-3 py-1 mb-2 align-self-center" style="font-size: 12px;">{{ $product->sku }}</span>
                    <h5 class="fw-bold text-dark mb-1">{{ $product->name }}</h5>
                    <span class="text-muted small">{{ $product->category->name ?? 'Uncategorized' }} Category</span>
                </div>
            </div>

            <!-- KANAN: Complete Details -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100 d-flex flex-column">
                    <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="fa-solid fa-circle-info me-2 text-danger"></i> Specifications & Stock Status</h6>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Price</label>
                        <div class="fw-bold text-danger fs-4">₱{{ number_format($product->price, 2) }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Description</label>
                        <p class="text-dark bg-light p-3 rounded-3" style="font-size: 13.5px;">
                            {{ $product->description ?? 'No description available for this product.' }}
                        </p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label text-muted small fw-semibold">Current Stock (Branch)</label>
                            <input type="text" class="form-control fw-bold bg-light border-0" value="{{ $branchStock }} pcs" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small fw-semibold">Availability</label>
                            <div>
                                @if($branchStock > 0)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 mt-1" style="font-size: 12px;">
                                        <i class="fa-solid fa-check-circle me-1"></i> In Stock
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 mt-1" style="font-size: 12px;">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Out of Stock
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection