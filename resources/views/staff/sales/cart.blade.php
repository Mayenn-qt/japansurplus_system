<!-- Cart Items Table -->
<div class="table-responsive">
    <table class="table table-borderless align-middle mb-0" style="font-size: 12.5px;">
        <thead class="text-muted bg-light" style="font-size: 10.5px;">
            <tr>
                <th class="py-2">Product</th>
                <th class="py-2 text-center">Qty</th>
                <th class="py-2 text-end">Price</th>
                <th class="py-2 text-end">Total</th>
                <th class="py-2 text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample Cart Item 1 -->
            <tr class="border-bottom border-light">
                <td class="py-2">
                    <span class="fw-bold text-dark d-block">Ceramic Bowl</span>
                    <span class="text-muted" style="font-size: 11px;">SKU-CER-01</span>
                </td>
                <td class="py-2 text-center">
                    <div class="input-group input-group-sm justify-content-center" style="width: 80px; margin: 0 auto;">
                        <button class="btn btn-outline-secondary px-1 py-0 border-0 bg-light text-dark" type="button" title="Decrease Qty">
                            <i class="fa-solid fa-minus" style="font-size: 9px;"></i>
                        </button>
                        <input type="text" class="form-control text-center p-0 border-0 bg-light fw-bold" value="3" readonly style="font-size: 12px;">
                        <button class="btn btn-outline-secondary px-1 py-0 border-0 bg-light text-dark" type="button" title="Increase Qty">
                            <i class="fa-solid fa-plus" style="font-size: 9px;"></i>
                        </button>
                    </div>
                </td>
                <td class="py-2 text-end text-muted">₱350.00</td>
                <td class="py-2 text-end fw-semibold text-dark">₱1,050.00</td>
                <td class="py-2 text-end">
                    <button class="btn btn-link text-danger p-0 shadow-none" title="Remove Item">
                        <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                    </button>
                </td>
            </tr>

            <!-- Sample Cart Item 2 -->
            <tr class="border-bottom border-light">
                <td class="py-2">
                    <span class="fw-bold text-dark d-block">Vintage Lamp</span>
                    <span class="text-muted" style="font-size: 11px;">SKU-LMP-02</span>
                </td>
                <td class="py-2 text-center">
                    <div class="input-group input-group-sm justify-content-center" style="width: 80px; margin: 0 auto;">
                        <button class="btn btn-outline-secondary px-1 py-0 border-0 bg-light text-dark" type="button" title="Decrease Qty">
                            <i class="fa-solid fa-minus" style="font-size: 9px;"></i>
                        </button>
                        <input type="text" class="form-control text-center p-0 border-0 bg-light fw-bold" value="1" readonly style="font-size: 12px;">
                        <button class="btn btn-outline-secondary px-1 py-0 border-0 bg-light text-dark" type="button" title="Increase Qty">
                            <i class="fa-solid fa-plus" style="font-size: 9px;"></i>
                        </button>
                    </div>
                </td>
                <td class="py-2 text-end text-muted">₱1,200.00</td>
                <td class="py-2 text-end fw-semibold text-dark">₱1,200.00</td>
                <td class="py-2 text-end">
                    <button class="btn btn-link text-danger p-0 shadow-none" title="Remove Item">
                        <i class="fa-solid fa-trash-can" style="font-size: 12px;"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Cart Summary -->
<div class="mt-3 pt-2 border-top border-light">
    <div class="d-flex justify-content-between mb-1 text-muted small">
        <span>Subtotal</span>
        <span class="fw-semibold text-dark">₱2,250.00</span>
    </div>
    <div class="d-flex justify-content-between mb-2 text-muted small">
        <span>Tax (12% Optional)</span>
        <span>₱0.00</span>
    </div>
    <div class="d-flex justify-content-between mb-3 text-dark fw-bold fs-5 border-top pt-2">
        <span>Grand Total</span>
        <span class="text-danger">₱2,250.00</span>
    </div>
</div>