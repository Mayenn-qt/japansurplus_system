@extends('layouts.app')

@section('title', 'Current Inventory - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <div style="background-color: #f8fafc; min-height: calc(100vh - 70px);">
        
        <!-- Header & Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark m-0">Current Inventory</h4>
                <p class="text-muted small m-0">Monitor real-time stock levels of Japan surplus items.</p>
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
                        <option selected>All Status</option>
                        <option value="in_stock">🟢 In Stock</option>
                        <option value="low_stock">🟡 Low Stock</option>
                        <option value="out_of_stock">🔴 Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Inventory Table Card -->
        <div class="card border-0 shadow-sm rounded-3 bg-white overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 13px;">
                    <thead class="bg-light text-muted" style="font-size: 11px; text-transform: uppercase;">
                        <tr>
                            <th class="py-3 px-4">Product</th>
                            <th class="py-3 text-center">Current Stock</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1: In Stock -->
                        <tr>
                            <td class="py-3 px-4">
                                <span class="fw-bold text-dark d-block">Japanese Ceramic Bowl</span>
                                <span class="text-muted small">SKU-CER-01</span>
                            </td>
                            <td class="py-3 text-center fw-semibold">12 pcs</td>
                            <td class="py-3 px-4">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1" style="font-size: 11px;">
                                    🟢 In Stock
                                </span>
                            </td>
                        </tr>

                        <!-- Row 2: Low Stock -->
                        <tr>
                            <td class="py-3 px-4">
                                <span class="fw-bold text-dark d-block">Vintage Desk Lamp</span>
                                <span class="text-muted small">SKU-LMP-02</span>
                            </td>
                            <td class="py-3 text-center fw-semibold">3 pcs</td>
                            <td class="py-3 px-4">
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1 text-dark" style="font-size: 11px;">
                                    🟡 Low Stock
                                </span>
                            </td>
                        </tr>

                        <!-- Row 3: Out of Stock -->
                        <tr>
                            <td class="py-3 px-4">
                                <span class="fw-bold text-dark d-block">Antique Tea Set</span>
                                <span class="text-muted small">SKU-TEA-05</span>
                            </td>
                            <td class="py-3 text-center fw-semibold text-muted">0 pcs</td>
                            <td class="py-3 px-4">
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1" style="font-size: 11px;">
                                    🔴 Out of Stock
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection