@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/branch.css') }}">

    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content">

            <div class="page-section active-page" id="page-branches">
                <!-- Header & Action Button -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--ink); letter-spacing: -0.5px;">Branch Management</h4>
                        <p class="text-muted mb-0" style="font-size:13.5px;">Manage all Ohaiyo Japan Surplus locations and warehouse branches</p>
                    </div>
                    <button class="btn btn-dark px-3 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddBranch" style="border-radius: 8px; font-size: 13.5px; font-weight: 500; background-color: #0f172a; border-color: #0f172a;">
                        <i class="fa-solid fa-plus text-white" style="font-size: 12px;"></i> Add Branch
                    </button>
                </div>

                <!-- Branch Cards Grid -->
                <div class="row g-3">
                    <!-- Naga Branch -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-3 h-100 branch-card" style="background-color: var(--bs-card-bg, #fff);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0" style="color: var(--ink); font-size: 16px;">Naga Branch</h6>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Active</span>
                            </div>
                            <div class="text-muted mb-3 d-flex align-items-center gap-1.5" style="font-size: 13px;">
                                <i class="fa-solid fa-location-dot text-danger" style="font-size: 12px;"></i> Magsaysay Ave, Naga City
                            </div>
                            
                            <hr class="text-muted opacity-10 my-3">

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                                <span class="text-muted">Branch Manager</span>
                                <span class="fw-semibold text-dark">Rico Delmonte</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                                <span class="text-muted">Active Staff</span>
                                <span class="fw-semibold text-dark">4 members</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4" style="font-size: 13.5px;">
                                <span class="text-muted">Total Products</span>
                                <span class="fw-semibold text-dark">512 units</span>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <button class="btn btn-light border btn-sm flex-fill shadow-sm text-secondary py-2" style="border-radius: 8px; font-weight: 500; font-size: 13px;">Edit</button>
                                <button class="btn btn-outline-dark btn-sm flex-fill py-2" style="border-radius: 8px; font-weight: 500; font-size: 13px;">View</button>
                            </div>
                        </div>
                    </div>

                    <!-- Legazpi Branch -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-3 h-100 branch-card" style="background-color: var(--bs-card-bg, #fff);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0" style="color: var(--ink); font-size: 16px;">Legazpi Branch</h6>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Active</span>
                            </div>
                            <div class="text-muted mb-3 d-flex align-items-center gap-1.5" style="font-size: 13px;">
                                <i class="fa-solid fa-location-dot text-danger" style="font-size: 12px;"></i> Rizal St, Legazpi City
                            </div>
                            
                            <hr class="text-muted opacity-10 my-3">

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                                <span class="text-muted">Branch Manager</span>
                                <span class="fw-semibold text-dark">Jenny Ocampo</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                                <span class="text-muted">Active Staff</span>
                                <span class="fw-semibold text-dark">3 members</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4" style="font-size: 13.5px;">
                                <span class="text-muted">Total Products</span>
                                <span class="fw-semibold text-dark">398 units</span>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <button class="btn btn-light border btn-sm flex-fill shadow-sm text-secondary py-2" style="border-radius: 8px; font-weight: 500; font-size: 13px;">Edit</button>
                                <button class="btn btn-outline-dark btn-sm flex-fill py-2" style="border-radius: 8px; font-weight: 500; font-size: 13px;">View</button>
                            </div>
                        </div>
                    </div>

                    <!-- Sorsogon Branch -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm p-4 rounded-3 h-100 branch-card" style="background-color: var(--bs-card-bg, #fff);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0" style="color: var(--ink); font-size: 16px;">Sorsogon Branch</h6>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Active</span>
                            </div>
                            <div class="text-muted mb-3 d-flex align-items-center gap-1.5" style="font-size: 13px;">
                                <i class="fa-solid fa-location-dot text-danger" style="font-size: 12px;"></i> Burgos St, Sorsogon City
                            </div>
                            
                            <hr class="text-muted opacity-10 my-3">

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                                <span class="text-muted">Branch Manager</span>
                                <span class="fw-semibold text-dark">Mark Antolin</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                                <span class="text-muted">Active Staff</span>
                                <span class="fw-semibold text-dark">3 members</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4" style="font-size: 13.5px;">
                                <span class="text-muted">Total Products</span>
                                <span class="fw-semibold text-dark">374 units</span>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <button class="btn btn-light border btn-sm flex-fill shadow-sm text-secondary py-2" style="border-radius: 8px; font-weight: 500; font-size: 13px;">Edit</button>
                                <button class="btn btn-outline-dark btn-sm flex-fill py-2" style="border-radius: 8px; font-weight: 500; font-size: 13px;">View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection