<!-- Stock In Modal -->
    <div class="modal fade" id="modalStockIn" tabindex="-1" aria-labelledby="modalStockInLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold" id="modalStockInLabel" style="color: var(--ink);">Stock In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <form action="{{ route('owner.stock.in') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Branch</label>
                            <select name="branch_id" class="form-select bg-light border-0 py-2" style="border-radius: 8px; font-size: 13.5px;" required>
                                <option selected disabled>Select branch...</option>
                                @foreach($branches ?? [] as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Quantity to Add</label>
                            <input type="number" name="quantity" class="form-control bg-light border-0 py-2" placeholder="e.g. 20" style="border-radius: 8px; font-size: 13.5px;" required min="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Supplier / Source</label>
                            <input type="text" name="supplier" class="form-control bg-light border-0 py-2" placeholder="e.g. Japan Surplus Consolidator Co." style="border-radius: 8px; font-size: 13.5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Remarks</label>
                            <textarea name="remarks" class="form-control bg-light border-0" rows="3" placeholder="Add remarks here..." style="border-radius: 8px; font-size: 13.5px;"></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-size: 13.5px; font-weight: 500; background-color: #0f172a; border-color: #0f172a;">Confirm Stock In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>