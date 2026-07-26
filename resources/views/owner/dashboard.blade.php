@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!--Sidebar-->
    @include('dashboard.sidebar')

    
        
        <!-- Top NavBar -->
        @include('dashboard.topnavbar')

        <div class="main-content-wrapper">
     
        <div class="page-selection active-page" id="page-dashboard">
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="text-black mb-1 ">
                    Welcome back,
                    <span id="dashName"></span>
                    
                </h4>
                <p class="text-black-50">
                    Here's an overview of your store's performance today.
                </p>
            </div>
            <div class="d-flex gap-2">
            <button class="btn btn-danger btn-sm px-3" onClick="showPage('pos', document.querySelector('[data-page=pos]'))">
               <i class="fa-solid fa-plus me-1">
               </i> 
               New Sale
            </button>
            <button class="btn btn-soft btn-sm px-3" onClick="showPage('stock', document.querySelector('[data-page=stock]'))">
                <i class="fa-solid fa-truck-ramp-box me-1"></i>
            Restock
            </button>
            </div>
        </div>
        
       
       <!-- TOP ROW CARDS (4 Stats Cards) -->
            <div class="row g-3 mb-4">
                <!-- Card 1: Total Sales (Red Theme) -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm simple-card" onclick="showPage('reports', document.querySelector('[data-page=reports]'))">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                            <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                            <span class="badge bg-success bg-opacity-10 text-success fw-semibold" style="font-size: 0.7rem;">Sales</span>
                        </div>
                        <span class="text-black small fw-medium d-block mb-1">Total Sales</span>
                        <h3 class="fw-bold mb-1 text-black">₱ 0.00</h3>
                        <span class="text-black-50" style="font-size: 0.65rem;"><i class="fa-solid fa-arrow-pointer me-1"></i> Click to view</span>
                    </div>
                </div>

                <!-- Card 2: Monthly Revenue (Green Theme) -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm simple-card" onclick="showPage('analytics', document.querySelector('[data-page=analytics]'))">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold" style="font-size: 0.7rem;">Revenue</span>
                        </div>
                        <span class="text-black small fw-medium d-block mb-1">Monthly Revenue</span>
                        <h3 class="fw-bold mb-1 text-black">0</h3>
                        <span class="text-black-50" style="font-size: 0.65rem;"><i class="fa-solid fa-arrow-pointer me-1"></i> Click to view</span>
                    </div>
                </div>

                <!-- Card 3: Total Visitors (Primary/Blue Theme) -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm simple-card" onclick="showPage('customers', document.querySelector('[data-page=customers]'))">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-info bg-opacity-10 text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <span class="badge bg-info bg-opacity-10 text-info fw-semibold" style="font-size: 0.7rem;">3 Branches</span>
                        </div>
                        <span class="text-black small fw-medium d-block mb-1">Total Products</span>
                        <h3 class="fw-bold mb-1 text-black">0</h3>
                        <span class="text-black-50" style="font-size: 0.65rem;"><i class="fa-solid fa-arrow-pointer me-1"></i> Click to view</span>
                    </div>
                </div>

                <!-- Card 4: Total Products Sold (Warning/Yellow Theme) -->
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card p-4 h-100 shadow-sm simple-card" onclick="showPage('stock', document.querySelector('[data-page=stock]'))">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <span class="badge bg-danger bg-opacity-10 text-danger fw-semibold" style="font-size: 0.7rem;">Low Stock</span>
                        </div>
                        <span class="text-black small fw-medium d-block mb-1">Low Stock Items</span>
                        <h3 class="fw-bold mb-1 text-black">0</h3>
                        <span class="text-black-50" style="font-size: 0.65rem;"><i class="fa-solid fa-arrow-pointer me-1"></i> Click to view</span>
                    </div>
                </div>
            </div>

        <!-- MIDDLE SECTION: Bar Chart & Product Statistic Donut Style Card -->
        @include('dashboard.statistic')

        <!-- 3 BRANCH PERFORMANCE CARDS -->
        @include('dashboard.branch')

        
        <div class="row g-4">
    <!-- Recent Activities Component -->
    <div class="col-lg-7">
        <div class="dashboard-card h-100 p-4 d-flex flex-column justify-content-between">
            <div>
                <div class="fw-bold h6 mb-4 text-black">Recent Activities</div>
                
                <div class="d-flex flex-column gap-3">
                    <!-- Activity 1 -->
                    <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background-color: #f8fafc; box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 34px; height: 34px; font-size: 13px; background-color: rgba(37, 99, 235, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2);">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-black" style="font-size: 13px;">Sale <b class="text-black">INV-10231</b> recorded at <b class="text-black">Naga Branch</b></div>
                            <div class="text-black-50" style="font-size: 11.5px;">2 minutes ago</div>
                        </div>
                    </div>

                    <!-- Activity 2 -->
                    <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background-color: #f1f5f9; box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 34px; height: 34px; font-size: 13px; background-color: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                            <i class="fa-solid fa-truck-ramp-box"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-black" style="font-size: 13px;">Stock In: <b class="text-black">20 units</b> Steel Kitchen Rack — Naga</div>
                            <div class="text-black-50" style="font-size: 11.5px;">38 minutes ago</div>
                        </div>
                    </div>

                    <!-- Activity 3 -->
                    <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background-color: #f8fafc; box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 34px; height: 34px; font-size: 13px; background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2);">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-black" style="font-size: 13px;">Low stock alert: <b class="text-black">Toshiba TV 32"</b> — Sorsogon Branch</div>
                            <div class="text-black-50" style="font-size: 11.5px;">1 hour ago</div>
                        </div>
                    </div>

                    <!-- Activity 4 -->
                    <div class="d-flex align-items-center gap-3 p-2.5 rounded-3" style="background-color: #f1f5f9; box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 34px; height: 34px; font-size: 13px; background-color: rgba(0, 0, 0, 0.05); color: #0f172a; border: 1px solid rgba(0, 0, 0, 0.1);">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-black" style="font-size: 13px;">New staff account created for <b class="text-black">Legazpi Branch</b></div>
                            <div class="text-black-50" style="font-size: 11.5px;">Yesterday, 4:18 PM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS Notification Status Component -->
    <div class="col-lg-5">
        <div class="dashboard-card h-100 p-4 d-flex flex-column justify-content-between">
            <div>
                <div class="fw-bold h6 mb-4 text-black">SMS Notification Status</div>
                
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background-color: #f8fafc; box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);">
                        <span class="text-black" style="font-size: 13px;">Gateway status</span>
                        <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">Online</span>
                    </div>

                    <div class="p-3 rounded-3 d-flex flex-column gap-2.5" style="background-color: #f1f5f9; box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);">
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 13px;">
                            <span class="text-black-50">Sent today</span>
                            <b class="text-black">142</b>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 13px;">
                            <span class="text-black-50">Delivered</span>
                            <b class="text-black">139</b>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 13px;">
                            <span class="text-black-50">Failed</span>
                            <b class="text-danger">3</b>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-light w-100 btn-sm py-2 border border-secondary border-opacity-25 text-black shadow-sm rounded-pill fw-medium" style="font-size: 0.8rem;" onclick="showPage('sms', document.querySelector('[data-page=sms]'))">
                    <i class="fa-solid fa-paper-plane me-2 text-primary"></i> Compose Broadcast
                </button>
            </div>
        </div>
    </div>
</div>

    </div>