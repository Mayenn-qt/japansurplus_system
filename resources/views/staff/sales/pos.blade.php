@extends('layouts.app')

@section('title', 'POS Terminal - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px);">
        
        <div class="row g-4">
            <!-- KALIWA: Product Catalog & Search -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-3">
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                        <div class="input-group" style="max-width: 350px;">
                            <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 shadow-none" placeholder="Search product name or barcode..." style="font-size: 13px; border-radius: 0 8px 8px 0;">
                        </div>
                        <div class="d-flex gap-2 w-100 w-md-auto overflow-auto pb-1">
                            <button class="btn btn-dark btn-sm px-3 fw-semibold" style="border-radius: 6px;">All</button>
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-semibold bg-white text-dark" style="border-radius: 6px; border-color: #e2e8f0;">Ceramics</button>
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-semibold bg-white text-dark" style="border-radius: 6px; border-color: #e2e8f0;">Furniture</button>
                        </div>
                    </div>
                </div>

                <!-- Product Cards Grid -->
                <div class="row g-3">
                    <!-- Product 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px;">Stock: 12</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 120px; color: #94a3b8;">
                                <i class="fa-solid fa-box-open fa-2x"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Japanese Wooden Wardrobe Cabinet</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-001</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱10,000.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px;">Stock: 8</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 120px; color: #94a3b8;">
                                <i class="fa-solid fa-lamp fa-2x"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Vintage Desk Lamp</h6>
                            <span class="text-muted small mb-2 d-block">SKU-LMP-02</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱1,200.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px;">Stock: 5</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 120px; color: #94a3b8;">
                                <i class="fa-solid fa-mug-hot fa-2x"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Aesthetic Tea Set</h6>
                            <span class="text-muted small mb-2 d-block">SKU-TEA-03</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱850.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px;">Stock: 15</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 120px; color: #94a3b8;">
                                <i class="fa-solid fa-utensils fa-2x"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Wooden Chopsticks Set</h6>
                            <span class="text-muted small mb-2 d-block">SKU-UTN-04</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱150.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px;">Stock: 4</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" style="height: 120px; color: #94a3b8;">
                                <i class="fa-solid fa-chair fa-2x"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Minimalist Wooden Stool</h6>
                            <span class="text-muted small mb-2 d-block">SKU-FUR-05</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱1,500.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
@endsection 