@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0" style="color: var(--ink);">All Stock Monitoring Records</h5>
            <div class="d-flex align-items-center gap-2">
                <form method="GET" action="{{ route('owner.stock.all') }}" class="d-flex gap-2">
                    <select name="branch_id" class="form-select form-select-sm" onchange="this.form.submit()" aria-label="Filter inventory by branch">
                        <option value="">All Branches</option>
                        @foreach($branches ?? [] as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('owner.stock') }}" class="btn btn-secondary btn-sm px-3" style="border-radius: 6px;">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 ps-4">Product Image</th>
                        <th class="py-3">Info</th>
                        <th class="py-3">Item Location</th>
                        <th class="py-3">Condition</th>
                        <th class="py-3 pe-4">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                        <tr>
                            <td class="ps-4">
                                <div class="bg-light rounded-3 overflow-hidden d-flex align-items-center justify-content-center border" style="width: 56px; height: 56px;">
                                    @if($stock->product?->image)
                                        <img src="{{ asset('images/products/' . basename($stock->product->image)) }}" alt="{{ $stock->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-image text-muted" aria-hidden="true"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-bold text-dark">{{ $stock->product->name ?? 'N/A' }}<span class="text-muted d-block small">{{ $stock->product->category->name ?? 'Uncategorized' }}</span></td>
                            <td class="text-secondary">
                                {{ $stock->product->location ?? 'Not specified' }}
                                <span class="text-muted small d-block">{{ $stock->branch->branch_name ?? 'Unassigned' }}</span>
                            </td>
                            <td class="text-secondary">{{ $stock->product->condition ?? 'Not specified' }}</td>
                            <td class="fw-semibold">{{ $stock->current_stock }} units</td>
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