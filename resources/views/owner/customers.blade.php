@extends('layouts.app')

@section('title', 'Customers - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('dashboard.sidebar')
    @include('dashboard.topnavbar')

    <div class="content-wrapper">
        <div class="container-fluid px-4 py-3">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Customer Contacts</h4>
                    <p class="text-muted mb-0" style="font-size: 13px;">Manage customer details for branch updates and SMS notifications.</p>
                </div>
                <button type="button" class="btn btn-danger px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                    <i class="fa-solid fa-plus me-1"></i> Add Customer
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <form method="GET" action="{{ route('owner.customers') }}" class="p-3 row g-2 align-items-center">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0" placeholder="Search name, mobile number, or email...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="branch_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark flex-grow-1" type="submit">Search</button>
                        <a href="{{ route('owner.customers') }}" class="btn btn-light border">Clear</a>
                    </div>
                </form>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted text-uppercase" style="font-size: 11px; letter-spacing: .4px;">
                            <tr>
                                <th class="ps-4 py-3">Customer</th>
                                <th class="py-3">Mobile Number</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Branch</th>
                                <th class="py-3">Notes</th>
                                <th class="pe-4 py-3 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td class="ps-4 fw-semibold text-dark">{{ $customer->name }}</td>
                                    <td class="text-secondary">{{ $customer->phone }}</td>
                                    <td class="text-secondary">{{ $customer->email ?? 'Not provided' }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $customer->branch->branch_name ?? 'All Branches' }}</span></td>
                                    <td class="text-muted small">{{ $customer->notes ?? '-' }}</td>
                                    <td class="pe-4 text-end">
                                        <button type="button" class="btn btn-sm btn-light border text-primary" data-bs-toggle="modal" data-bs-target="#editCustomer{{ $customer->id }}" title="Edit customer">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('owner.customers.destroy', $customer) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this customer contact?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border text-danger" title="Remove customer"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center py-5 text-muted">No customer contacts found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($customers->hasPages())
                    <div class="card-footer bg-white">{{ $customers->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('owner.customers.store') }}" method="POST">
                    @csrf
                    <div class="modal-header"><h5 class="modal-title fw-bold">Add Customer Contact</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        @include('owner.customers-form', ['customer' => null])
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger">Save Contact</button></div>
                </form>
            </div>
        </div>
    </div>

    @foreach($customers as $customer)
        <div class="modal fade" id="editCustomer{{ $customer->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <form action="{{ route('owner.customers.update', $customer) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5 class="modal-title fw-bold">Edit Customer Contact</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            @include('owner.customers-form', ['customer' => $customer])
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button><button class="btn btn-danger">Update Contact</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
