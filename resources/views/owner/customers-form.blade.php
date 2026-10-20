<div class="mb-3">
    <label class="form-label fw-semibold">Customer Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $customer?->name) }}" required>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Number</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer?->phone) }}" placeholder="09XX XXX XXXX" required>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Branch</label>
    <select name="branch_id" class="form-select">
        <option value="">All Branches</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ old('branch_id', $customer?->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->branch_name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Exact Location</label>
    <input type="text" name="exact_location" class="form-control" value="{{ old('exact_location', $customer?->exact_location) }}" placeholder="House no., street, barangay, city" required>
</div>
