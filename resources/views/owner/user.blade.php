@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div id="content">

            <div class="page-section active-page" id="page-users">
                <!-- Header & Action Button -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--ink); letter-spacing: -0.5px;">User Management</h4>
                        <p class="text-muted mb-0" style="font-size:13.5px;">Manage administrator and staff accounts across all branches</p>
                    </div>
                    <button class="btn btn-dark px-3 py-2 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddStaff" style="border-radius: 8px; font-size: 13.5px; font-weight: 500; background-color: #0f172a; border-color: #0f172a;">
                        <i class="fa-solid fa-user-plus text-white" style="font-size: 12px;"></i> Add Staff
                    </button>
                </div>

                <!-- Users Table Card -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-5" style="background-color: var(--bs-card-bg, #fff);">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-3 ps-4">Name</th>
                                    <th class="py-3">Role</th>
                                    <th class="py-3">Branch</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 pe-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- User 1: Marianne -->
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar rounded-circle d-flex align-items-center justify-content-center fw-bold text-white bg-dark" style="width: 36px; height: 36px; font-size: 12px; background-color: #0f172a !important;">MT</div>
                                            <div>
                                                <span class="fw-semibold text-dark d-block" style="font-size: 14px;">Marianne T. Gabion</span>
                                                <span class="text-muted" style="font-size: 11.5px;">marianne@ohaiyo.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-dark fw-medium" style="font-size: 13.5px;">Branch Manager</span></td>
                                    <td><span class="badge rounded-pill bg-light text-dark border px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Main Branch</span></td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Active</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm text-secondary" title="Edit User" style="border-radius: 6px;"><i class="fa-solid fa-pen" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm text-secondary" title="Reset Password" style="border-radius: 6px;"><i class="fa-solid fa-key" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm text-danger" title="Ban / Deactivate" style="border-radius: 6px;"><i class="fa-solid fa-ban" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>

                                <!-- User 2: Mark -->
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar rounded-circle d-flex align-items-center justify-content-center fw-bold text-white bg-dark" style="width: 36px; height: 36px; font-size: 12px; background-color: #334155 !important;">MA</div>
                                            <div>
                                                <span class="fw-semibold text-dark d-block" style="font-size: 14px;">Mark</span>
                                                <span class="text-muted" style="font-size: 11.5px;">mark@ohaiyo.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-dark fw-medium" style="font-size: 13.5px;">Branch Manager</span></td>
                                    <td><span class="badge rounded-pill bg-light text-dark border px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Juban</span></td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Active</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm text-secondary" title="Edit User" style="border-radius: 6px;"><i class="fa-solid fa-pen" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm text-secondary" title="Reset Password" style="border-radius: 6px;"><i class="fa-solid fa-key" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm text-danger" title="Ban / Deactivate" style="border-radius: 6px;"><i class="fa-solid fa-ban" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>

                                <!-- User 3: Robin -->
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar rounded-circle d-flex align-items-center justify-content-center fw-bold text-white bg-dark" style="width: 36px; height: 36px; font-size: 12px; background-color: #475569 !important;">RB</div>
                                            <div>
                                                <span class="fw-semibold text-dark d-block" style="font-size: 14px;">Robin</span>
                                                <span class="text-muted" style="font-size: 11.5px;">robin@ohaiyo.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-dark fw-medium" style="font-size: 13.5px;">Cashier</span></td>
                                    <td><span class="badge rounded-pill bg-light text-dark border px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Magallanes</span></td>
                                    <td><span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1.5" style="font-weight: 500; font-size: 11.5px;">Active</span></td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm text-secondary" title="Edit User" style="border-radius: 6px;"><i class="fa-solid fa-pen" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 me-1 shadow-sm text-secondary" title="Reset Password" style="border-radius: 6px;"><i class="fa-solid fa-key" style="font-size: 12px;"></i></button>
                                        <button class="btn btn-sm btn-light border px-2 py-1 shadow-sm text-danger" title="Ban / Deactivate" style="border-radius: 6px;"><i class="fa-solid fa-ban" style="font-size: 12px;"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection