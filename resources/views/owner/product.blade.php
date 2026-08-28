@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    
    <!--Sidebar-->
    @include('dashboard.sidebar')

    <div class="content-wrapper">
        <div class="page-section active-page" id="page-products"> 
            
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Product Management</h4>
                    <p class="text-muted mb-0" style="font-size:13.5px;">Seamlessly manage inventory, pricing, and stock across all branches.</p>
                </div>
                
                <button type="button" class="btn btn-danger btn-sm px-3 py-2 fw-semibold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addProductModal" style="border-radius: 10px; transition: all 0.2s;">
                    <i class="fa-solid fa-plus"></i> Add Product
                </button>
            </div>

            <!-- ADD PRODUCT MODAL -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                        <div class="modal-header bg-light px-4 py-3 border-bottom">
                            <h5 class="modal-title fw-bold text-dark" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="{{ route('owner.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Product Name</label>
                                        <input type="text" name="name" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">SKU</label>
                                        <input type="text" name="sku" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Category</label>
                                        <select name="category_id" class="form-select bg-light border-0 py-2" required style="border-radius: 10px;">
                                            <option value="">Select Category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Price (₱)</label>
                                        <input type="number" step="0.01" name="price" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Stock (Main)</label>
                                        <input type="number" name="stock_main" class="form-control bg-light border-0 py-2" value="0" min="0" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Stock (Juban)</label>
                                        <input type="number" name="stock_juban" class="form-control bg-light border-0 py-2" value="0" min="0" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Stock (Magallanes)</label>
                                        <input type="number" name="stock_magallanes" class="form-control bg-light border-0 py-2" value="0" min="0" required style="border-radius: 10px;">
                                    </div>
                                </div>
                            
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Product Image</label>
                                    <input type="file" name="image" class="form-control bg-light border-0 py-2" id="image" accept="image/*" style="border-radius: 10px;">
                                </div>
                            </div>
                            
                            <div class="modal-footer bg-light px-4 py-3 border-top">
                                <button type="button" class="btn btn-light px-4 py-2 border fw-semibold text-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                                <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold shadow-sm" style="border-radius: 10px;">Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
                <form method="GET" action="{{ route('owner.product') }}" class="p-3 d-flex gap-2 flex-wrap align-items-center">
                    <div class="search-box flex-grow-1 bg-light px-3 py-2 d-flex align-items-center gap-2" style="border-radius: 10px; min-width:240px;">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product name or SKU..." style="border:none; background:transparent; outline:none; font-size:13.5px; width:100%;">
                    </div>

                    <select name="category_id" class="form-select form-select-sm bg-light border-0 py-2 px-3" style="width:auto; border-radius:10px; font-size:13px;" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="branch_id" class="form-select form-select-sm bg-light border-0 py-2 px-3" style="width:auto; border-radius:10px; font-size:13px;" onchange="this.form.submit()">
                        <option value="">All Branches</option>
                        @foreach($branches ?? [] as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="form-select form-select-sm bg-light border-0 py-2 px-3" style="width:auto; border-radius:10px; font-size:13px;" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>

                    @if(request()->anyFilled(['search', 'category_id', 'branch_id', 'status']))
                        <a href="{{ route('owner.product') }}" class="btn btn-sm btn-light border px-3 py-2 text-secondary fw-semibold" style="border-radius:10px;">Clear Filter</a>
                    @endif
                </form>
            </div>

            <!-- PRODUCT DISPLAY -->
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 14px;">
                
                <!-- DESKTOP VIEW -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                            <tr>
                                <th class="ps-4 py-3" style="width: 70px;">Image</th>
                                <th class="py-3">Product Info</th>
                                <th class="py-3">Category</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Stock</th>
                                <th class="py-3">Status</th>
                                <th class="pe-4 text-end py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="bg-light rounded-3 overflow-hidden d-flex align-items-center justify-content-center border" style="width: 48px; height: 48px;">
                                        <img src="{{ asset('images/products/' . ($product->image ?? 'default.png')) }}" 
                                            alt="{{ $product->name }}" 
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <div class="text-muted font-monospace" style="font-size:11.5px;">SKU: {{ $product->sku }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 fw-normal" style="border-radius: 6px;">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="fw-bold text-danger">₱{{ number_format($product->price, 2) }}</td>
                                <td class="fw-semibold text-secondary">{{ $product->total_stock ?? 0 }} <span class="fw-normal text-muted" style="font-size: 12px;">units</span></td>
                                <td>
                                    @php $stock = $product->total_stock ?? 0; @endphp
                                    @if($stock > 5)
                                        <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 fw-semibold" style="font-size: 11px; border-radius: 6px;">In Stock</span>
                                    @elseif($stock > 0)
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1.5 fw-semibold" style="font-size: 11px; border-radius: 6px;">Low Stock</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 fw-semibold" style="font-size: 11px; border-radius: 6px;">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <button type="button" class="btn btn-sm btn-light border shadow-xs px-2.5 py-1.5 text-secondary" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}" title="View Info" style="border-radius: 8px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open fa-2x mb-2 text-black-50"></i>
                                    <p class="mb-0">No products found matching your filter.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE VIEW (Food-App Style Modern Grid) -->
                <div class="d-block d-md-none p-3 bg-light">
                    <div class="row g-2">
                        @forelse($products ?? [] as $product)
                        <div class="col-6">
                            <div class="card border-0 shadow-xs rounded-3 p-2.5 bg-white h-100 position-relative d-flex flex-column" style="border-radius: 12px;">
                                
                                @php $stock = $product->total_stock ?? 0; @endphp
                                <div class="position-absolute top-0 end-0 m-2 z-2">
                                    @if($stock > 5)
                                        <span class="badge bg-white text-success border border-success border-opacity-25 shadow-xs" style="font-size: 9px; border-radius: 6px;">{{ $stock }} left</span>
                                    @elseif($stock > 0)
                                        <span class="badge bg-white text-warning border border-warning border-opacity-25 shadow-xs" style="font-size: 9px; border-radius: 6px;">Low: {{ $stock }}</span>
                                    @else
                                        <span class="badge bg-white text-danger border border-danger border-opacity-25 shadow-xs" style="font-size: 9px; border-radius: 6px;">Out</span>
                                    @endif
                                </div>

                                <!-- Image Container -->
                                <div class="bg-light rounded-3 overflow-hidden mb-2 d-flex align-items-center justify-content-center" style="height: 120px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}">
                                    <img src="{{ asset('images/products/' . ($product->image ?? 'default.png')) }}" 
                                         alt="{{ $product->name }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 12.5px;">{{ $product->name }}</h6>
                                <span class="text-muted d-block mb-2" style="font-size: 10.5px;">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="fw-bold text-danger" style="font-size: 13px;">₱{{ number_format($product->price, 2) }}</span>
                                    <button class="btn btn-sm btn-dark px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}" style="font-size: 10px; border-radius: 6px;"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5 text-muted bg-white rounded-3">
                            <i class="fa-solid fa-box-open fa-2x mb-2 text-black-50"></i>
                            <p class="mb-0">No products found.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- VIEW PRODUCT MODAL LOOP -->
                @foreach($products ?? [] as $product)
                <div class="modal fade" id="viewProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold text-dark">Product Details</h5>
                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                        <img src="{{ asset('images/products/' . ($product->image ?? 'default.png')) }}" alt="{{ $product->name }}" class="img-fluid rounded-3 border shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="fw-bold text-dark mb-1">{{ $product->name }}</h3>
                                        <p class="text-muted mb-2 font-monospace" style="font-size: 13px;"><b>SKU:</b> {{ $product->sku }}</p>
                                        <p class="mb-2"><b>Category:</b> <span class="badge bg-light text-dark border px-2 py-1">{{ $product->category->name ?? 'Uncategorized' }}</span></p>
                                        <p class="mb-3"><b>Price:</b> <span class="text-danger fw-bold fs-5">₱{{ number_format($product->price, 2) }}</span></p>
                                        
                                        <div class="bg-light p-3 rounded-3 border">
                                            <h6 class="fw-bold mb-2 text-dark" style="font-size: 13px;"><i class="fa-solid fa-store me-1 text-danger"></i> Stock per Branch:</h6>
                                            <div class="row text-secondary" style="font-size: 12.5px;">
                                                @foreach($product->inventories ?? [] as $inv)
                                                    <div class="col-6 mb-1">
                                                        {{ $inv->branch->branch_name ?? 'Branch' }}: <b class="text-dark">{{ $inv->current_stock }} units</b>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                                <button type="button" class="btn btn-secondary px-4 py-2 btn-sm fw-semibold" data-bs-dismiss="modal" style="border-radius: 10px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Pagination Footer -->
                <div class="d-flex justify-content-between align-items-center p-3 px-4 border-top bg-white flex-wrap gap-2">
                    <span class="text-muted" style="font-size:12.5px;">
                        @if(isset($products) && $products->total() > 0)
                            Showing <b>{{ $products->firstItem() }}</b> to <b>{{ $products->lastItem() }}</b> of <b>{{ $products->total() }}</b> entries
                        @else
                            Showing 0 entries
                        @endif
                    </span>
                    <div>
                        @if(isset($products))
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        @endif
                    </div>
                </div>

            </div> <!-- End of Card Wrapper -->

        </div> <!-- End of Page Section -->
    </div> <!-- End of Content Wrapper -->

@endsection