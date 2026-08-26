@extends('layouts.app')

@section('title', 'Product Management - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px);">
        
        <!-- Header & Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark m-0">Product Inventory</h4>
                <p class="text-muted small m-0">Manage and monitor Japan surplus item stocks.</p>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="card border-0 shadow-sm rounded-3 p-3 bg-white mb-4">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-center">
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 shadow-none" placeholder="Search product or SKU..." style="font-size: 13px; border-radius: 0 8px 8px 0;">
                </div>
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <select class="form-select form-select-sm bg-light border-0 text-dark fw-semibold" style="font-size: 13px; border-radius: 8px;">
                        <option selected>All Categories</option>
                        <option value="ceramics">Ceramics</option>
                        <option value="furniture">Furniture</option>
                        <option value="utensils">Utensils</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Product Table Card -->
        <div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 13px;">
                    <thead class="bg-light text-muted" style="font-size: 11px; text-transform: uppercase;">
                        <tr>
                            <th class="py-3 px-4">Image</th>
                            <th class="py-3">Product</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 text-center">Stock</th>
                            <th class="py-3 text-end px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td class="py-3 px-4">
                                <div class="bg-light rounded-2 d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-dark d-block">Japanese Wooden Wardrobe Cabinet</span>
                                <span class="text-muted small">SKU-HS-001</span>
                            </td>
                            <td class="py-3 text-muted">Ceramics</td>
                            <td class="py-3 fw-semibold text-danger">₱350.00</td>
                            <td class="py-3 text-center">
                                <span class="badge bg-light text-success border border-success border-opacity-25 px-2 py-1" style="font-size: 11px;">12 in stock</span>
                            </td>
                            <td class="py-3 text-end px-4">
                                <!-- Siguraduhin na may route ka para sa show/details -->
                                <a href="{{ route('staff.products.show', 1) }}" class="btn btn-sm btn-outline-secondary bg-white text-dark px-2 py-1 shadow-sm" style="border-radius: 6px; border-color: #e2e8f0; font-size: 12px;">
                                    <i class="fa-solid fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td class="py-3 px-4">
                                <div class="bg-light rounded-2 d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-lamp"></i>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-dark d-block">Vintage Desk Lamp</span>
                                <span class="text-muted small">SKU-LMP-02</span>
                            </td>
                            <td class="py-3 text-muted">Furniture</td>
                            <td class="py-3 fw-semibold text-danger">₱1,200.00</td>
                            <td class="py-3 text-center">
                                <span class="badge bg-light text-warning border border-warning border-opacity-25 px-2 py-1 text-dark" style="font-size: 11px;">8 in stock</span>
                            </td>
                            <td class="py-3 text-end px-4">
                                <a href="{{ route('staff.products.show', 2) }}" class="btn btn-sm btn-outline-secondary bg-white text-dark px-2 py-1 shadow-sm" style="border-radius: 6px; border-color: #e2e8f0; font-size: 12px;">
                                    <i class="fa-solid fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection