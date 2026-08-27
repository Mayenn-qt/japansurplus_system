@extends('layouts.app')

@section('title', 'POS Terminal - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px); padding: 20px;">
        
        <div class="row g-4">
            <!-- KALIWA: Product Catalog & Search -->
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-3">
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                        <div class="input-group" style="max-width: 350px;">
                            <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 shadow-none" placeholder="Search product name or barcode..." style="font-size: 13px; border-radius: 0 8px 8px 0;">
                        </div>
                        <div class="d-flex gap-2 w-100 w-md-auto overflow-auto pb-1">
                            <button class="btn btn-dark btn-sm px-3 fw-semibold" style="border-radius: 6px;">All</button>
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-semibold bg-white text-dark" style="border-radius: 6px; border-color: #e2e8f0;">Furniture</button>
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-semibold bg-white text-dark" style="border-radius: 6px; border-color: #e2e8f0;">Kitchenware</button>
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-semibold bg-white text-dark" style="border-radius: 6px; border-color: #e2e8f0;">Bags</button>
                            <button class="btn btn-outline-secondary btn-sm px-3 fw-semibold bg-white text-dark" style="border-radius: 6px; border-color: #e2e8f0;">Tools</button>
                        </div>
                    </div>
                </div>

                <!-- Product Cards Grid -->
                <div class="row g-3">
                    
                    <!-- Product 1 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 15</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/cabinet.jpg') }}" alt="Japanese Wooden Wardrobe Cabinet" style="width: 100%; height: 100%; object-fit: cover;">
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
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 18</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/plateandbowl.jpg') }}" alt="Ceramic Plate & Bowl Set" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Ceramic Plate & Bowl Set</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-002</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱450.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 24</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/chair.jpg') }}" alt="Office Swivel Chair" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Office Swivel Chair</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-003</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱1,200.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 3</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/luggage.jpg') }}" alt="Japanese Hard-Case Travel Luggage" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Japanese Hard-Case Travel Luggage</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-004</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱1,450.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 5 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 9</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/chainsaw.jpg') }}" alt="Shindaiwa Gasoline Engine Chainsaw" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Shindaiwa Gasoline Engine Chainsaw</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-005</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱4,200.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 6 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 18</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/teapot.jpg') }}" alt="Traditional Cast Iron Teapot Set" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Traditional Cast Iron Teapot Set</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-006</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱850.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 7 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 20</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/clock.jpg') }}" alt="Vintage Seiko Wooden Wall Clock" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Vintage Seiko Wooden Wall Clock</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-007</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱1,500.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 8 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 9</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/wood.jpg') }}" alt="Hitachi Electric Wood Planer" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Hitachi Electric Wood Planer</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-008</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱2,800.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 9 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 15</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/travel.jpg') }}" alt="Outdoor Camping Backpack & Gear Set" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Outdoor Camping Backpack & Gear Set</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-009</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱2,100.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 10 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100 position-relative" style="cursor: pointer;">
                            <div class="badge bg-light text-danger border border-danger border-opacity-25 position-absolute top-0 end-0 m-3" style="font-size: 10px; z-index: 2;">Stock: 25</div>
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden" style="height: 120px;">
                                <img src="{{ asset('images/products/ramen.jpg') }}" alt="Japanese Ceramic Ramen Bowl Set" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">Japanese Ceramic Ramen Bowl Set</h6>
                            <span class="text-muted small mb-2 d-block">SKU-HS-010</span>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-danger">₱650.00</span>
                                <button class="btn btn-sm btn-dark px-2 py-1" style="border-radius: 6px;"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection