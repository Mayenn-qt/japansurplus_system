@extends('layouts.app')

@section('title', 'Admin Dashboard - Ohaiyo Japan Surplus')

@section('content')
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    
    <!--Sidebar-->
    @include('dashboard.sidebar')

    <!-- Top NavBar -->

    <div class="content-wrapper">

        <!-- Main Content -->
        <div class="page-section active-page" id="page-products"> 
            
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-0">Product Management</h5>
                    <p class="text-muted mb-0" style="font-size:13px;">Manage products across branches</p>
                </div>
                
                <!-- Add Product Button -->
                <button type="button" class="btn btn-danger btn-sm px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addProductModal" style="border-radius: 8px;">
                    <i class="fa-solid fa-plus me-2"></i> Add Product
                </button>
            </div>

            
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content" style="border-radius: 12px;">
                        <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="modal-title fw-bold" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="{{ route('owner.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">Product Name</label>
                                        <input type="text" name="name" class="form-control" required style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">SKU</label>
                                        <input type="text" name="sku" class="form-control" required style="border-radius: 8px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">Category</label>
                                        <select name="category_id" class="form-select" required style="border-radius: 8px;">
                                            <option value="">Select Category</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">Price (₱)</label>
                                        <input type="number" step="0.01" name="price" class="form-control" required style="border-radius: 8px;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">Stock (Main)</label>
                                        <input type="number" name="stock_main" class="form-control" value="0" min="0" required style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">Stock (Juban)</label>
                                        <input type="number" name="stock_juban" class="form-control" value="0" min="0" required style="border-radius: 8px;">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold" style="font-size: 13px;">Stock (Magallanes)</label>
                                        <input type="number" name="stock_magallanes" class="form-control" value="0" min="0" required style="border-radius: 8px;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size: 13px;">Product Image</label>
                                    <input type="file" name="image" class="form-control" style="border-radius: 8px;">
                                </div>
                            </div>
                            
                            <div class="modal-footer border-top-0 pt-0">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                                <button type="submit" class="btn btn-danger px-4" style="border-radius: 8px;">Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            

            <!-- Filter Section -->
            <div class="card mb-3">
                <form method="GET" action="{{ route('owner.product') }}" class="p-3 d-flex gap-2 flex-wrap align-items-center">
                    
                    <div class="search-box flex-grow-1" style="width:auto; min-width:220px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product name or SKU..." style="border:none; background:transparent; outline:none; font-size:13.5px; width:100%;">
                    </div>

                    <select name="category_id" class="form-select" style="width:auto; border-radius:9px; font-size:13px;" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="branch_id" class="form-select" style="width:auto; border-radius:9px; font-size:13px;" onchange="this.form.submit()">
                        <option value="">All Branches</option>
                        @foreach($branches ?? [] as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="form-select" style="width:auto; border-radius:9px; font-size:13px;" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>

                    @if(request()->anyFilled(['search', 'category_id', 'branch_id', 'status']))
                        <a href="{{ route('owner.product') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:9px;">Clear</a>
                    @endif

                </form>
            </div>

            <!-- Table Section -->
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 60px;">Image</th>
                                <th class="ps-4">Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                            <tr>
                             <!-- Column 1: Image pa lang -->
                             <td class="ps-4">
                             <img src="{{ asset('images/products/' . ($product->image ?? 'default.png')) }}" alt="{{ $product->name }}" class="prod-thumb">
                            </td>

                             <!-- Column 2: Product Name at SKU na -->
                            <td>
                            <div class="fw-semibold">{{ $product->name }}</div>
                            <div class="text-muted" style="font-size:11.5px;">{{ $product->sku }}</div>
                            </td>

                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td class="fw-semibold">₱{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->total_stock ?? 0 }} units</td>
                             <td>
                
                             @php $stock = $product->total_stock ?? 0; @endphp
                @if($stock > 5)
                    <span class="badge-status badge-instock">In Stock</span>
                @elseif($stock > 0)
                    <span class="badge-status badge-low">Low Stock</span>
                @else
                    <span class="badge-status badge-out">Out of Stock</span>
                @endif
            </td>
            <td class="pe-4 text-end">
                <div class="d-flex align-items-center justify-content-end gap-1">
                    <button type="button" class="action-icon" title="View"><i class="fa-solid fa-eye"></i></button>
                    <button type="button" class="action-icon" title="Edit"><i class="fa-solid fa-pen"></i></button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-4 text-muted">NO PRODUCT.</td>
        </tr>
    @endforelse
</tbody>
                    </table>
                </div>
                
                <!-- Pagination Footer -->
                <div class="d-flex justify-content-between align-items-center p-3 px-4 border-top flex-wrap gap-2">
                    <span class="text-muted" style="font-size:12.5px;">
                        @if($products->total() > 0)
                            Showing <b>{{ $products->firstItem() }}</b> to <b>{{ $products->lastItem() }}</b> of <b>{{ $products->total() }}</b> entries
                        @else
                            Showing 0 entries
                        @endif
                    </span>
                    <div>
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div> <!-- End of Card -->

        </div> <!-- End of Page Section -->

    </div> <!-- End of Content Wrapper -->

@endsection