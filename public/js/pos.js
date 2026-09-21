let cart = JSON.parse(sessionStorage.getItem('pos_cart')) || [];

// 1. Kapag pinindot ang 'Add' button sa produkto
function addToCart(id, name, price, stock) {
    let existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        if (existingItem.quantity < stock) {
            existingItem.quantity++;
        } else {
            alert('Naabot na ang limitasyon ng stock.');
            return;
        }
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            quantity: 1,
            stock: stock
        });
    }

    updateCartUI();
}

function addFreeItem(id, name, stock) {
    let existingItem = cart.find(item => item.id === id && item.is_free);

    if (existingItem) {
        if (existingItem.quantity < stock) {
            existingItem.quantity++;
        } else {
            alert('Naabot na ang limitasyon ng stock.');
            return;
        }
    } else {
        cart.push({ id: id, name: name, price: 0, quantity: 1, stock: stock, is_free: true });
    }

    updateCartUI();
}

// 2. Pag-update ng UI sa My Order panel sa POS terminal
function updateCartUI() {
    let cartContainer = document.querySelector('.cart-items');
    let subtotalDisplay = document.querySelector('.card .text-muted + .fw-semibold, .card .text-dark span.fw-semibold'); // O hanapin ang subtotal element
    
    // I-save agad sa sessionStorage para laging updated
    sessionStorage.setItem('pos_cart', JSON.stringify(cart));

    if (!cartContainer) return;

    if (cart.length === 0) {
        cartContainer.innerHTML = `
            <div class="py-4 text-center d-flex flex-column justify-content-center align-items-center">
                <div class="text-muted opacity-50 mb-2" style="font-size: 28px;"><i class="fa-solid fa-basket-shopping"></i></div>
                <span class="text-muted small">No items added yet.</span>
            </div>
        `;
        document.querySelectorAll('.fs-4, .text-danger.fs-4').forEach(el => el.innerText = '₱0.00');
        return;
    }

    let html = '';
    let subtotal = 0;

    cart.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        html += `
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <div>
                    <span class="fw-bold text-dark d-block" style="font-size: 13px;">${item.name}</span>
                    <span class="text-danger small fw-semibold">₱${item.price.toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" onclick="decreaseQty(${index})" class="btn btn-sm btn-light border px-2 py-0">-</button>
                    <span class="fw-bold small">${item.quantity}</span>
                    <button type="button" onclick="increaseQty(${index})" class="btn btn-sm btn-light border px-2 py-0">+</button>
                    <button type="button" onclick="removeItem(${index})" class="btn btn-sm text-danger border-0"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
        `;
    });

    cartContainer.innerHTML = html;
    
    // I-update ang Subtotal at Total Amount sa POS screen
    document.querySelectorAll('.text-danger.fs-4, .fs-4').forEach(el => {
        el.innerText = '₱' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2});
    });
}

function increaseQty(index) {
    if (cart[index].quantity < cart[index].stock) {
        cart[index].quantity++;
        updateCartUI();
    } else {
        alert('Naabot na ang maximum stock.');
    }
}

function decreaseQty(index) {
    cart[index].quantity--;
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    updateCartUI();
}

function removeItem(index) {
    cart.splice(index, 1);
    updateCartUI();
}

function clearCart() {
    cart = [];
    sessionStorage.removeItem('pos_cart');
    updateCartUI();
}

// 3. Kapag pinindot ang Proceed to Checkout button
function proceedToCheckout() {
    if (!cart || cart.length === 0) {
        alert('Wala pang nakalagay sa Order mo. Pumili muna ng produkto.');
        return;
    }

    sessionStorage.setItem('pos_cart', JSON.stringify(cart));
    renderCheckoutModal();
    bootstrap.Modal.getOrCreateInstance(document.getElementById('checkoutModal')).show();
}

function renderCheckoutModal() {
    const container = document.getElementById('checkoutModalItems');
    if (!container) return;

    container.innerHTML = cart.map(item => `
        <div class="d-flex justify-content-between border-bottom py-2">
            <span>${item.name} <small class="text-muted">x${item.quantity}</small></span>
            <strong>${item.is_free ? 'FREE' : '₱' + (item.price * item.quantity).toLocaleString('en-US', {minimumFractionDigits: 2})}</strong>
        </div>
    `).join('');
    updateCheckoutTotals();
}

function updateCheckoutTotals() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const discount = Math.min(parseFloat(document.getElementById('manualDiscount')?.value) || 0, subtotal);
    const due = Math.max(0, subtotal - discount);
    const cash = parseFloat(document.getElementById('cashTendered')?.value) || 0;
    const change = cash - due;

    document.getElementById('checkoutTotal').innerText = '₱' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('checkoutDue').innerText = '₱' + due.toLocaleString('en-US', {minimumFractionDigits: 2});
    document.getElementById('checkoutChange').innerText = change >= 0 ? '₱' + change.toLocaleString('en-US', {minimumFractionDigits: 2}) : 'Insufficient Cash';
    document.getElementById('checkoutChange').className = change >= 0 ? 'text-success' : 'text-danger';
}

function prepareCheckoutData() {
    document.getElementById('cartDataInput').value = JSON.stringify(cart);
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const discount = parseFloat(document.getElementById('manualDiscount').value) || 0;
    const cash = parseFloat(document.getElementById('cashTendered').value) || 0;
    if (discount > subtotal || cash < subtotal - discount) {
        alert('Please check the discount and cash tendered amount.');
        return false;
    }
    return cart.length > 0;
}

// Auto-load ang cart pagbukas ng POS page at i-check kung dapat i-clear
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('clear_cart') === 'true') {
        clearCart(); // Buburahin ang cart at sessionStorage
        
        // Linisin ang URL para hindi magtuloy-tuloy ang pag-clear kapag nire-refresh
        window.history.replaceState({}, document.title, window.location.pathname);
    } else {
        updateCartUI();
    }
};