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
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Supplier Price (₱)</label>
                                        <input type="number" step="0.01" min="0" name="supplier_price" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Sale Price (₱)</label>
                                        <input type="number" step="0.01" min="0" name="sale_price" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Stock by Branch</label>
                                    <div class="row">
                                        @foreach($branches as $branch)
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label text-secondary" style="font-size: 12px;">{{ $branch->branch_name }}</label>
                                                <input type="number" name="stock[{{ $branch->id }}]" min="0" step="1" value="0" class="form-control bg-light border-0 py-2" required aria-label="Stock quantity for {{ $branch->branch_name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Product Photos</label>
                                    <input type="file" name="images[]" class="form-control bg-light border-0 py-2" id="images" accept="image/*" multiple style="border-radius: 10px;">
                                    <div class="form-text" style="font-size: 11px;">Choose up to 10 photos. The first photo will be used as the cover.</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Condition</label>
                                        <select name="condition" class="form-select bg-light border-0 py-2" style="border-radius: 10px;">
                                            <option value="">Select condition</option>
                                            <option>Good</option>
                                            <option>Very Good</option>
                                            <option>Fair</option>
                                            <option>With Minor Damage</option>
                                            <option>Needs Cleaning</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Item Location</label>
                                        <input type="text" name="location" class="form-control bg-light border-0 py-2" placeholder="e.g. Cabinet 3 - Shelf 2" style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Remarks</label>
                                        <textarea name="remarks" class="form-control bg-light border-0 py-2" rows="2" placeholder="Minor scratches, slight discoloration, or other details" style="border-radius: 10px;"></textarea>
                                    </div>
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

                    @if(request()->anyFilled(['search', 'category_id', 'branch_id']))
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
                                <th class="ps-4 py-3" style="width: 120px;">Image</th>
                                <th class="py-3">Product Info</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Dates (Added / Sold)</th>
                                <th class="py-3">Remarks & Conditions</th>
                                <th class="pe-4 text-end py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                            @php 
                                $totalStock = $product->inventories->sum('current_stock');
                                $isSoldOut = ($totalStock === 0);
                            @endphp
                            <tr class="{{ $isSoldOut ? 'table-danger bg-opacity-10' : '' }}">
                                
                                <!-- 1. Image -->
                                <td class="ps-4 py-3">
                                    <div class="bg-light rounded-3 overflow-hidden d-flex align-items-center justify-content-center border shadow-xs" style="width: 90px; height: 90px;">
                                        @php
                                            $primaryImage = $product->image ?? collect($product->images)->first()?->image;
                                        @endphp
                                        @if($primaryImage)
                                            <img src="{{ asset('images/products/' . basename($primaryImage)) }}"
                                                 alt="{{ $product->name }}"
                                                    style="width: 100%; height: 100%; object-fit: contain; padding: 4px;">
                                        @else
                                            <i class="fa-solid fa-image fa-xl text-muted" aria-hidden="true"></i>
                                        @endif
                                    </div>
                                </td>

                                <!-- 2. Product Info -->
                                <td>
                                    <div class="fw-bold {{ $isSoldOut ? 'text-danger text-decoration-line-through' : 'text-dark' }}" style="font-size: 13.5px;">{{ $product->name }}</div>
                                    <div class="d-flex align-items-center gap-2 mt-1" style="font-size: 11.5px;">
                                        <span class="badge bg-light text-dark border px-2 py-0.5 fw-normal" style="font-size: 10.5px; border-radius: 6px;">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="text-success fw-semibold">
                                            {{ $totalStock }} units in stock
                                        </span>
                                    </div>
                                </td>

                                <!-- 3. Price -->
                                <td>
                                    <div class="text-muted" style="font-size: 11.5px;">
                                        <span class="text-secondary">Supplier:</span> ₱{{ number_format($product->supplier_price ?? 0, 2) }}
                                    </div>
                                    <div class="fw-bold text-danger" style="font-size: 13.5px;">
                                        <span>Sale:</span> ₱{{ number_format($product->price, 2) }}
                                    </div>
                                </td>

                                <!-- 4. Dates Added, Date Sold -->
                                <td style="font-size: 11px;" class="text-muted">
                                    <div><b>Added:</b> {{ optional($product->created_at)->format('M d, Y') ?? 'N/A' }}</div>
                                    <div><b>Last Sold:</b> {{ $product->last_sold_at ? \Carbon\Carbon::parse($product->last_sold_at)->format('M d, Y') : 'Never' }}</div>
                                </td>

                                <!-- 5. Remarks and Conditions -->
                                <td>
                                    <span class="text-secondary" style="font-size: 12px;">{{ $product->remarks ?? 'N/A' }}</span>
                                </td>

                                <!-- 6. Actions -->
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-sm btn-light border shadow-xs px-2.5 py-1.5 text-secondary" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}" title="View Info" style="border-radius: 8px;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light border shadow-xs px-2.5 py-1.5 text-primary" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}" title="Edit Product" style="border-radius: 8px;">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                                        <div class="modal-header bg-light px-4 py-3 border-bottom">
                                            <h5 class="modal-title fw-bold text-dark" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('owner.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Product Name</label>
                                                        <input type="text" name="name" value="{{ $product->name }}" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">SKU</label>
                                                        <input type="text" name="sku" value="{{ $product->sku }}" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Category</label>
                                                        <select name="category_id" class="form-select bg-light border-0 py-2" required style="border-radius: 10px;">
                                                            @foreach($categories ?? [] as $category)
                                                                <option value="{{ $category->id }}" {{ (string) $product->category_id === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Supplier Price (₱)</label>
                                                        <input type="number" step="0.01" min="0" name="supplier_price" value="{{ $product->supplier_price }}" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Sale Price (₱)</label>
                                                        <input type="number" step="0.01" min="0" name="sale_price" value="{{ $product->sale_price ?? $product->price }}" class="form-control bg-light border-0 py-2" required style="border-radius: 10px;">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Stock by Branch</label>
                                                    <div class="row">
                                                        @foreach($branches as $branch)
                                                            @php $branchInventory = $product->inventories->firstWhere('branch_id', $branch->id); @endphp
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label text-secondary" style="font-size: 12px;">{{ $branch->branch_name }}</label>
                                                                <input type="number" name="stock[{{ $branch->id }}]" min="0" step="1" value="{{ $branchInventory?->current_stock ?? 0 }}" class="form-control bg-light border-0 py-2" required aria-label="Stock quantity for {{ $branch->branch_name }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Add Product Photos</label>
                                                    <input type="file" name="images[]" class="form-control bg-light border-0 py-2" accept="image/*" multiple style="border-radius: 10px;">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Replace Cover Image</label>
                                                        <input type="file" name="image" class="form-control bg-light border-0 py-2" accept="image/*" style="border-radius: 10px;">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Condition</label>
                                                        <select name="condition" class="form-select bg-light border-0 py-2" style="border-radius: 10px;">
                                                            <option value="">Select condition</option>
                                                            @foreach(['Good', 'Very Good', 'Fair', 'With Minor Damage', 'Needs Cleaning'] as $condition)
                                                                <option value="{{ $condition }}" {{ $product->condition === $condition ? 'selected' : '' }}>{{ $condition }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="form-label fw-semibold text-secondary" style="font-size: 13px;">Remarks</label>
                                                    <textarea name="remarks" class="form-control bg-light border-0 py-2" rows="2" style="border-radius: 10px;">{{ $product->remarks }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light px-4 py-3 border-top">
                                                <button type="button" class="btn btn-light px-4 py-2 border fw-semibold text-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                                                <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold shadow-sm" style="border-radius: 10px;">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open fa-2x mb-2 text-black-50"></i>
                                    <p class="mb-0">No products added yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- MOBILE VIEW -->
                <div class="d-block d-md-none p-3 bg-light">
                    <div class="row g-2">
                        @forelse($products ?? [] as $product)
                        <div class="col-6">
                            <div class="card border-0 shadow-xs rounded-3 p-2.5 bg-white h-100 position-relative d-flex flex-column" style="border-radius: 12px;">
                                @php
                                    $totalStock = $product->inventories->sum('current_stock');
                                    $isSoldOut = $totalStock === 0;
                                @endphp
                                
                                <!-- Image Container -->
                                <div class="bg-light rounded-3 overflow-hidden mb-2 d-flex align-items-center justify-content-center" style="height: 140px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}">
                                    @php $mobileImg = $product->image ?? collect($product->images)->first()?->image; @endphp
                                    @if($mobileImg)
                                        <img src="{{ asset('images/products/' . basename($mobileImg)) }}"
                                             alt="{{ $product->name }}"
                                            style="width: 100%; height: 100%; object-fit: contain; padding: 4px;">
                                    @else
                                        <i class="fa-solid fa-image fa-2x text-muted" aria-hidden="true"></i>
                                    @endif
                                </div>

                                <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 12.5px;">{{ $product->name }}</h6>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="text-muted" style="font-size: 10.5px;">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                    <span class="text-muted fw-semibold" style="font-size: 10.5px;">{{ $totalStock }} units</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="fw-bold text-danger" style="font-size: 13px;">₱{{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                                    <button class="btn btn-sm btn-dark px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewProductModal{{ $product->id }}" style="font-size: 10px; border-radius: 6px;"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5 text-muted bg-white rounded-3">
                            <i class="fa-solid fa-box-open fa-2x mb-2 text-black-50"></i>
                            <p class="mb-0">No products added yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div> <!-- End Product Display Card -->

            @if($products instanceof \Illuminate\Contracts\Pagination\Paginator || $products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif

            <!-- VIEW PRODUCT MODAL LOOP WITH PRODUCT IMAGES DATA -->
            @foreach($products ?? [] as $product)
            <div class="modal fade" id="viewProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                        <div class="modal-header bg-light border-bottom px-4 py-3">
                            <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                                <i class="fa-solid fa-box-archive text-danger"></i> Product Details
                            </h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body p-4">
                            <div class="row align-items-start g-4">
                                <!-- Left Column: Image & Thumbnails Gallery -->
                                <div class="col-md-5 text-center">
                                    @php
                                        $galleryImages = collect([$product->image])
                                            ->filter()
                                            ->merge(collect($product->images)->pluck('image'))
                                            ->unique()
                                            ->values();
                                        $viewImg = $galleryImages->first();
                                    @endphp
                                    <div class="bg-light rounded-3 overflow-hidden border shadow-xs mb-2 d-flex align-items-center justify-content-center" style="height: 300px;">
                                        @if($viewImg)
                                            <img src="{{ asset('images/products/' . basename($viewImg)) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid w-100 h-100 main-preview-img-{{ $product->id }}"
                                                 style="object-fit: contain; padding: 8px;">
                                        @else
                                            <i class="fa-solid fa-image fa-3x text-muted" aria-hidden="true"></i>
                                        @endif
                                    </div>

                                    <!-- Thumbnails -->
                                    @if($galleryImages->isNotEmpty())
                                        <div class="d-flex gap-2 justify-content-center flex-wrap mt-2">
                                            @foreach($galleryImages as $image)
                                                <div class="rounded border overflow-hidden shadow-xs bg-white" style="width: 52px; height: 52px; cursor: pointer; transition: all 0.2s;"
                                                     onclick="document.querySelector('.main-preview-img-{{ $product->id }}').src='{{ asset('images/products/' . basename($image)) }}'"
                                                     onmouseover="this.style.borderColor='#dc3545'" onmouseout="this.style.borderColor='#dee2e6'">
                                                    <img src="{{ asset('images/products/' . basename($image)) }}" 
                                                         alt="Angle" 
                                                         style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <span class="text-muted d-block mt-1" style="font-size: 10px;"><i class="fa-solid fa-arrow-pointer me-1"></i>Click thumbnail to switch angle</span>
                                    @endif
                                </div>

                                <!-- Right Column: Product Info -->
                                <div class="col-md-7">
                                    <h4 class="fw-bold text-dark mb-1">{{ $product->name }}</h4>
                                    <p class="text-muted mb-2 font-monospace" style="font-size: 12.5px;"><b>SKU:</b> {{ $product->sku }}</p>
                                    
                                    <div class="mb-3">
                                        <span class="badge bg-light text-dark border px-2 py-1 fw-semibold" style="border-radius: 6px;">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>

                                    <div class="bg-light p-3 rounded-3 border mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-secondary" style="font-size: 12px;">Sale Price:</span>
                                            <span class="text-danger fw-bold fs-5">₱{{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-secondary" style="font-size: 12px;">Supplier Price:</span>
                                            <span class="text-dark fw-semibold" style="font-size: 13px;">₱{{ number_format($product->supplier_price ?? 0, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-3" style="font-size: 12.5px;">
                                        <div class="col-6">
                                            <span class="text-muted d-block">Condition</span>
                                            <span class="fw-semibold text-dark">{{ $product->condition ?? 'Not specified' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted d-block">Total Stock</span>
                                            <span class="fw-semibold text-dark">{{ $totalStock }} units</span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <span class="text-muted d-block">Remarks</span>
                                            <span class="text-dark">{{ $product->remarks ?? 'None' }}</span>
                                        </div>
                                    </div>

                                    <div class="text-muted border-top pt-2 mb-3" style="font-size: 11px;">
                                        <div><b>Added Date:</b> {{ optional($product->created_at)->format('M d, Y') }}</div>
                                        <div><b>Last Sold:</b> {{ isset($product->date_last_sold) && $product->date_last_sold ? \Carbon\Carbon::parse($product->date_last_sold)->format('M d, Y') : 'Not yet sold' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Per Branch Section -->
                            <div class="mt-4 bg-light p-3 rounded-3 border">
                                <h6 class="fw-bold mb-2 text-dark d-flex align-items-center gap-2" style="font-size: 13px;">
                                    <i class="fa-solid fa-store text-danger"></i> Stock per Branch:
                                </h6>
                                <div class="row g-2 text-secondary" style="font-size: 12.5px;">
                                    @forelse($product->inventories ?? [] as $inv)
                                        <div class="col-md-4">
                                            <div class="bg-white p-2 rounded border shadow-xs d-flex justify-content-between align-items-center">
                                                <span>{{ $inv->branch->branch_name ?? 'Branch' }}:</span> 
                                                <b class="badge bg-light text-dark border">{{ $inv->current_stock }} units</b>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-muted italic" style="font-size: 12px;">No branch inventory data recorded.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Image list array generator at JS data injector -->
            @php
                $imagesList = $galleryImages
                    ->map(fn ($image) => asset('images/products/' . basename($image)))
                    ->values()
                    ->all();
            @endphp

            <script>
                window.productImagesData = window.productImagesData || {};
                window.productImagesData[{{ $product->id }}] = @json($imagesList);
            </script>
            @endforeach

        </div>
    </div>

    <!-- Isang beses lang i-load ang hiwalay na JS file dito -->
    <script src="{{ asset('js/product-slider.js') }}"></script>
@endsection