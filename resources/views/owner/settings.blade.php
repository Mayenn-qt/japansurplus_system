@extends('layouts.app')

@section('title', 'Settings - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

    <!-- Sidebar -->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div class="container-fluid px-4 py-3">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">System Settings</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Manage store profile details, security credentials, and API integrations</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- 1. Store Information Section -->
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <div class="bg-primary-subtle text-primary p-2 rounded-3 me-3"><i class="fa-solid fa-store fa-lg"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Store Information</h6>
                                <small class="text-muted">Update your general store details, address, and contact information</small>
                            </div>
                        </div>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Store Name</label>
                                    <input type="text" class="form-control form-control-sm" value="Ohaiyo Japan Surplus" style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Contact Number</label>
                                    <input type="text" class="form-control form-control-sm" value="0912-345-6789" style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Email Address</label>
                                    <input type="email" class="form-control form-control-sm" value="support@ohaiyojapansurplus.com" style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-semibold">Branch Location / Address</label>
                                    <input type="text" class="form-control form-control-sm" value="City Center, Sorsogon" style="border-radius: 8px;">
                                </div>
                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-dark btn-sm px-4 py-2 shadow-sm" style="border-radius: 8px; background-color: #0f172a;"><i class="fa-solid fa-floppy-disk me-1"></i> Save Store Info</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 2. Change Password Section -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <div class="bg-warning-subtle text-warning p-2 rounded-3 me-3"><i class="fa-solid fa-lock fa-lg"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Change Password</h6>
                                <small class="text-muted">Ensure your account is using a secure password</small>
                            </div>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Current Password</label>
                                <input type="password" class="form-control form-control-sm" placeholder="••••••••" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">New Password</label>
                                <input type="password" class="form-control form-control-sm" placeholder="••••••••" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Confirm New Password</label>
                                <input type="password" class="form-control form-control-sm" placeholder="••••••••" style="border-radius: 8px;">
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-dark btn-sm px-4 py-2 shadow-sm" style="border-radius: 8px; background-color: #0f172a;"><i class="fa-solid fa-key me-1"></i> Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 3. SMS API Settings Section -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <div class="bg-success-subtle text-success p-2 rounded-3 me-3"><i class="fa-solid fa-comments fa-lg"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">SMS API Settings</h6>
                                <small class="text-muted">Configure your gateway API credentials for text broadcasts</small>
                            </div>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">SMS Gateway Provider</label>
                                <select class="form-select form-select-sm" style="border-radius: 8px;">
                                    <option selected>Semaphore / PhilSMS</option>
                                    <option>Twilio</option>
                                    <option>Globe Labs API</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">API Token / Secret Key</label>
                                <input type="password" class="form-control form-control-sm" value="************************" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-semibold">Sender ID / Name</label>
                                <input type="text" class="form-control form-control-sm" value="OhaiyoSurplus" style="border-radius: 8px;">
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-dark btn-sm px-4 py-2 shadow-sm" style="border-radius: 8px; background-color: #0f172a;"><i class="fa-solid fa-plug me-1"></i> Save API Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection