<div class="mb-3">
    <label class="form-label fw-semibold">Full Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $customer?->name) }}" required>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Mobile Number</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer?->phone) }}" placeholder="09XX XXX XXXX" required>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Email <span class="text-muted fw-normal">(optional)</span></label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $customer?->email) }}">
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
<div>
    <label class="form-label fw-semibold">Notes <span class="text-muted fw-normal">(optional)</span></label>
    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $customer?->notes) }}</textarea>
</div>
