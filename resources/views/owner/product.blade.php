@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="main-content-wrapper">

    <div class= "page-selection action-page" id="page-products">
        <div class = "d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-0 ">Product Management</h5>
                <p class="text-muted mb-0" style="font-size:13px;">sourr many products dzai</p>
            </div>
            <button class="btn btn-danger" data-bs-toogle="modal" data-bs-target="#modalAddProduct">
                <i class="fa-solid fa-plus me-1">Add Product </i>
            </button>
</div>

<div class="p-3 d-flex gap-2 flex-wrap">
    <div class="search-box flex-grow-1" style="width:auto; min-width:220px">
        <i class="fa-solidfa-magnifying-glass">

        </i>
    </div>
</div>



    
