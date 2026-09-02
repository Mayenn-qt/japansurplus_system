@extends('layouts.app')

@section('title', 'Cash Checkout - Ohaiyo Japan Surplus')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    @include('staff.partials.sidebar')
    @include('staff.partials.navbar')

    <!-- Japanese Warm Neutral Minimalist Background -->
    <div style="background-color: #ffffff ; min-height: calc(100vh - 70px); padding: 20px; font-family: 'Inter', sans-serif;">
        
        <div class="mb-4">
            <a href="{{ route('staff.pos') }}" class="text-decoration-none small fw-semibold" style="color: #8c857b;">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to POS Terminal
            </a>
            <h4 class="fw-bold mt-2 mb-0" style="color: #2c2925;">Cash Payment Checkout</h4>
        </div>

        <form action="{{ route('staff.sales.store') }}" method="POST" class="row g-4" onsubmit="return prepareCheckoutData()">
            @csrf
            
            <!-- Hidden input para maipasa ang cart items papuntang Laravel Controller -->
            <input type="hidden" name="cart_data" id="cartDataInput">

            <!-- KALIWA: Order Summary Items List -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 bg-white h-100" style="border-radius: 24px !important; border: 1px solid #f0ece1 !important;">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color: #2c2925; border-color: #f0ece1 !important;">
                        <i class="fa-solid fa-basket-shopping me-2" style="color: #e2062c;"></i> Order Summary
                    </h6>
                    
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="font-size: 13.5px;">
                            <thead class="text-muted" style="font-size: 11px; text-transform: uppercase; background-color: #f7f5f0; color: #8c857b !important;">
                                <tr>
                                    <th class="py-2 ps-3 rounded-start">Item</th>
                                    <th class="py-2 text-center">Qty</th>
                                    <th class="py-2 text-end">Price</th>
                                    <th class="py-2 text-end pe-3 rounded-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="checkoutTableBody">
                                <!-- Dito na ngayon kusang papasok ang pinili mo sa POS -->
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4" style="color: #8c857b;">Loading cart items...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- KANAN: Payment, Suki Discount, at Sukli Computation -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4 bg-white h-100 d-flex flex-column" style="border-radius: 24px !important; border: 1px solid #f0ece1 !important;">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom" style="color: #2c2925; border-color: #f0ece1 !important;">
                        <i class="fa-solid fa-money-bill-wave me-2" style="color: #e2062c;"></i> Payment Details
                    </h6>
                    
                    <div class="mb-2 d-flex justify-content-between" style="font-size: 13.5px; color: #8c857b;">
                        <span>Subtotal:</span>
                        <span class="fw-semibold text-dark" id="subtotalDisplay">₱0.00</span>
                    </div>

                    <!-- Suki Customer Discount Checkbox -->
                    <div class="mb-3 p-3 rounded-3 border" style="background-color: #f7f5f0; border-color: #f0ece1 !important;">
                        <div class="form-check m-0">
                            <input class="form-check-input shadow-none" type="checkbox" id="sukiDiscountCheck" name="is_suki" value="1" onchange="calculateTotal()" style="cursor: pointer; accent-color: #e2062c;">
                            <label class="form-check-label fw-semibold small ms-1" for="sukiDiscountCheck" style="cursor: pointer; color: #2c2925;">
                                <i class="fa-solid fa-star me-1" style="color: #d97706;"></i> Suki Customer (10% Off)
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between" style="font-size: 13.5px; color: #8c857b;">
                        <span>Discount Deducted:</span>
                        <span class="fw-semibold" id="discountDisplay" style="color: #e2062c;">-₱0.00</span>
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center pb-3 border-bottom" style="border-color: #f0ece1 !important;">
                        <span class="fw-bold" style="font-size: 15px; color: #2c2925;">Total Amount:</span>
                        <span class="fw-bold fs-3" id="finalTotalDisplay" style="color: #e2062c;">₱0.00</span>
                    </div>

                    <!-- Payment Method Fixed to Cash Only -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #8c857b;">Payment Method</label>
                        <div class="d-flex p-1 rounded-3" style="gap: 4px; background-color: #f7f5f0;">
                            <div class="flex-fill text-center py-2 bg-white fw-bold shadow-sm rounded-2 border" style="font-size: 12.5px; color: #2c2925; border-color: #f0ece1 !important;">
                                <i class="fa-solid fa-money-bill-wave me-1" style="color: #10b981;"></i> Cash Only
                            </div>
                        </div>
                    </div>

                    <!-- Money Received Input -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #8c857b;">Money Received</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0" style="background-color: #f7f5f0; border-color: #f0ece1; border-radius: 12px 0 0 12px; color: #8c857b;">₱</span>
                            <input type="number" step="0.01" name="money_received" id="moneyReceived" class="form-control border-start-0 shadow-none fw-bold text-dark" placeholder="0.00" style="font-size: 14px; background-color: #f7f5f0; border-color: #f0ece1; border-radius: 0 12px 12px 0;" required onkeyup="calculateChange()">
                        </div>
                        <div class="d-flex justify-content-between mt-1 px-1">
                            <span class="small" style="color: #8c857b;">Change:</span>
                            <span class="fw-bold small" id="changeDisplay" style="color: #10b981;">₱0.00</span>
                        </div>
                    </div>

                    <!-- Record Sale / Submit Button -->
                    <div class="mt-auto">
                        <button type="submit" class="btn w-100 py-3 fw-bold text-white shadow-sm d-flex align-items-center justify-content-center gap-2 border-0" style="border-radius: 16px; font-size: 14px; background-color: #e2062c;">
                            <i class="fa-solid fa-cash-register" style="font-size: 15px;"></i> Record Sale & Checkout
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>

    <!-- JavaScript para basahin ang SessionStorage at i-compute ang mga presyo -->
    <script>
        let cart = JSON.parse(sessionStorage.getItem('pos_cart')) || [];
        let subtotal = 0;

        function loadCheckoutCart() {
            let tbody = document.getElementById('checkoutTableBody');
            
            if (cart.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4" style="color: #8c857b;">Wala pang nakalagay sa cart mo. <a href="{{ route('staff.pos') }}" style="color: #e2062c;">Bumalik sa POS</a></td></tr>`;
                subtotal = 0;
                calculateTotal();
                return;
            }

            let html = '';
            subtotal = 0;

            cart.forEach(item => {
                let itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                html += `
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold d-block" style="color: #2c2925;">${item.name}</span>
                            <span class="small" style="color: #8c857b;">ID: ${item.id}</span>
                        </td>
                        <td class="text-center" style="color: #2c2925;">${item.quantity}</td>
                        <td class="text-end" style="color: #2c2925;">₱${item.price.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                        <td class="text-end fw-semibold pe-3" style="color: #2c2925;">₱${itemTotal.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
            document.getElementById('subtotalDisplay').innerText = '₱' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2});
            calculateTotal();
        }

        function calculateTotal() {
            let isSuki = document.getElementById('sukiDiscountCheck').checked;
            let discount = isSuki ? subtotal * 0.10 : 0;
            let total = subtotal - discount;

            document.getElementById('discountDisplay').innerText = '-₱' + discount.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('finalTotalDisplay').innerText = '₱' + total.toLocaleString('en-US', {minimumFractionDigits: 2});
            calculateChange();
        }

        function calculateChange() {
            let isSuki = document.getElementById('sukiDiscountCheck').checked;
            let total = subtotal - (isSuki ? subtotal * 0.10 : 0);
            let moneyReceived = parseFloat(document.getElementById('moneyReceived').value) || 0;
            let change = moneyReceived - total;

            let changeElement = document.getElementById('changeDisplay');
            if (moneyReceived === 0) {
                changeElement.innerText = '₱0.00';
                changeElement.style.color = '#10b981';
            } else if (change >= 0) {
                changeElement.innerText = '₱' + change.toLocaleString('en-US', {minimumFractionDigits: 2});
                changeElement.style.color = '#10b981';
            } else {
                changeElement.innerText = 'Insufficient Cash';
                changeElement.style.color = '#e2062c';
            }
        }

        function prepareCheckoutData() {
            if (cart.length === 0) {
                alert('Walang produkto sa cart.');
                return false;
            }
            document.getElementById('cartDataInput').value = JSON.stringify(cart);
            return true;
        }

        window.onload = function() {
            loadCheckoutCart();
        };
    </script>
@endsection