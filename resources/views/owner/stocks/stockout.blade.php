<div class="modal fade" id="modalStockOut" tabindex="-1" aria-labelledby="modalStockOutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold text-danger" id="modalStockOutLabel" style="color: var(--ink);">Stock Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <form action="{{ route('owner.stock.out') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Product</label>
                            <select name="product_id" class="form-select bg-light border-0 py-2" style="border-radius: 8px; font-size: 13.5px;" required>
                                <option selected disabled>Select product...</option>
                                @foreach($products ?? [] as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (SKU: {{ $product->sku }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Quantity to Deduct</label>
                            <input type="number" name="quantity" class="form-control bg-light border-0 py-2" placeholder="e.g. 5" style="border-radius: 8px; font-size: 13.5px;" required min="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Reason / Destination</label>
                            <input type="text" name="reason" class="form-control bg-light border-0 py-2" placeholder="e.g. Damaged, Branch Transfer, Sold" style="border-radius: 8px; font-size: 13.5px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Remarks</label>
                            <textarea name="remarks" class="form-control bg-light border-0" rows="3" placeholder="Add remarks here..." style="border-radius: 8px; font-size: 13.5px;"></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4 py-2" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Confirm Stock Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>