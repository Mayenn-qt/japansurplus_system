@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<link rel="stylesheet" href="{{asset('css/product.css')}}">
    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->
    @include('dashboard.topnavbar')

    <div class="content-wrapper">

        <!-- Main Content -->
        <div class="page-section active-page" id="page-products"> 
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-0">Product Management</h5>
                    <p class="text-muted mb-0" style="font-size:13px;">1,284 products across 3 branches</p>
                </div>
                <button class="btn btn-danger">
                    <i class="fa-solid fa-plus me-1"></i> Add Product
                </button>
            </div>

            <div class="card mb-3">
                <div class="p-3 d-flex gap-2 flex-wrap">
                    <div class="search-box flex-grow-1" style="width:auto; min-width:220px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search product name or SKU..." style="border:none; background:transparent; outline:none; font-size:13.5px; width:100%;">
                    </div>
                    <select class="form-select" style="width:auto; border-radius:9px; font-size:13px;">
                        <option>All Categories</option>
                        <option>Appliances</option>
                        <option>Furniture</option>
                        <option>Electronics</option>
                        <option>Tools</option>
                        <option>Kitchenware</option>
                    </select>
                    <select class="form-select" style="width:auto; border-radius:9px; font-size:13px;">
                        <option>All Branches</option>
                        <option>Sorsogon</option>
                        <option>Juban</option>
                        <option>Magallanes</option>
                    </select>
                    <select class="form-select" style="width:auto; border-radius:9px; font-size:13px;">
                        <option>All Status</option>
                        <option>In Stock</option>
                        <option>Low Stock</option>
                        <option>Out of Stock</option>
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-3"><input type="checkbox"></th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Item 1 -->
                            <tr>
                                <td class="ps-3"><input type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                       <img src="{{ asset('images/products/cabinet.jpg') }}" alt="Cabinet" class="prod-thumb">
                                        <div>
                                            <div class="fw-semibold">Japanese Wooden Wardrobe Cabinet</div>
                                            <div class="text-muted" style="font-size:11.5px;">SKU-HS-001</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Furniture</td>
                                <td class="fw-semibold">₱10,00</td>
                                <td>5 units</td>
                                <td><span class="badge-status badge-instock">In Stock</span></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" class="action-icon"  title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-icon" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Item 2 -->
                            <tr>
                                <td class="ps-3"><input type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                      <img src="{{ asset('images/products/plateandbowl.jpg') }}" alt="Plate" class="prod-thumb">                                          
                                        <div>
                                            <div class="fw-semibold">Ceramic Plate & Bowl Set"</div>
                                            <div class="text-muted" style="font-size:11.5px;">SKU-HS-002</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Kitchenware</td>
                                <td class="fw-semibold">₱450</td>
                                <td>5 sets</td>
                                <td><span class="badge-status badge-low">Low Stock</span></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" class="action-icon"  title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-icon" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Item 3 -->
                            <tr>
                                <td class="ps-3"><input type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/products/chair.jpg') }}" alt="chair" class="prod-thumb">
                                        <div>
                                            <div class="fw-semibold">Office Swivel Chair</div>
                                            <div class="text-muted" style="font-size:11.5px;">SKU-HS-003</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Furniture</td>
                                <td class="fw-semibold">₱1,200</td>
                                <td>15 units</td>
                                <td><span class="badge-status badge-instock">In Stock</span></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" class="action-icon"  title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-icon" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Item 4 -->
                            <tr>
                                <td class="ps-3"><input type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{asset('images/products/generator.jpg')}}" alt="generator" class="prod-thumb">
                                        <div>
                                            <div class="fw-semibold">Denyo Gasoline Generator Set</div>
                                            <div class="text-muted" style="font-size:11.5px;">SKU-HS-004</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Heavy Equipment & Machinery</td>
                                <td class="fw-semibold">₱12,500</td>
                                <td>0 units</td>
                                <td><span class="badge-status badge-out">Out of Stock</span></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" class="action-icon"  title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-icon" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Item 5 -->
                            <tr>
                                <td class="ps-3"><input type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{asset('images/products/luggage.jpg')}}" alt="luggage" class="prod-thumb">
                                        <div>
                                            <div class="fw-semibold">Japanese Hard-Case Travel Luggage</div>
                                            <div class="text-muted" style="font-size:11.5px;">SKU-HS-005</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Bags & Luggage</td>
                                <td class="fw-semibold">₱1,450</td>
                                <td>10 units</td>
                                <td><span class="badge-status badge-instock">In Stock</span></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" class="action-icon"  title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-icon" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Item 6 -->
                            <tr>
                                <td class="ps-3"><input type="checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">l
                                        <img src="{{asset('images/products/chainsaw.jpg')}}" alt="Chainsaw" class="prod-thumb">
                                        <div>
                                            <div class="fw-semibold">Shindaiwa Gasoline Engine Chainsaw</div>
                                            <div class="text-muted" style="font-size:11.5px;">SKU-HS-006</div>
                                        </div>
                                    </img>
                                </td>
                                <td>Tools & Equipment</td>
                                <td class="fw-semibold">₱4,200</td>
                                <td>5 units</td>
                                <td><span class="badge-status badge-instock">In Stock</span></td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" class="action-icon"  title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-icon" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="action-icon text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="d-flex justify-content-between align-items-center p-3 px-4 border-top">
                    <span class="text-muted" style="font-size:12.5px;">Showing 1–6 of secret products</span>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
@endsection