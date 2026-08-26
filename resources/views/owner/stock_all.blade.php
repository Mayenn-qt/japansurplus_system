@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0" style="color: var(--ink);">All Stock Monitoring Records</h5>
            <a href="{{ route('owner.stock') }}" class="btn btn-secondary btn-sm px-3" style="border-radius: 6px;">
                <i class="fa-solid fa-arrow-left me-1"></i> Back
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 ps-4">Branch</th>
                        <th class="py-3">Product Name</th>
                        <th class="py-3">SKU</th>
                        <th class="py-3">Current Stock</th>
                        <th class="py-3 pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                        <tr>
                            <td class="ps-4 fw-semibold text-secondary">{{ $stock->branch->branch_name ?? 'N/A' }}</td>
                            <td class="fw-bold text-dark">{{ $stock->product->name ?? 'N/A' }}</td>
                            <td><span class="text-muted">{{ $stock->product->sku ?? 'N/A' }}</span></td>
                            <td class="fw-semibold">{{ $stock->current_stock }} units</td>
                            <td>
                                @php
                                    if($stock->current_stock <= 0) {
                                        $badge = 'bg-danger text-danger'; $text = 'Out of Stock';
                                    } elseif($stock->current_stock <= 5) {
                                        $badge = 'bg-warning text-warning'; $text = 'Low Stock';
                                    } else {
                                        $badge = 'bg-success text-success'; $text = 'In Stock';
                                    }
                                @endphp
                                <span class="badge border {{ $badge }} bg-opacity-10 px-2 py-1" style="font-size: 11px;">
                                    {{ $text }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No stock records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="card-footer bg-white py-3">
            {{ $stocks->links() }}
        </div>
    </div>
</div>
@endsection