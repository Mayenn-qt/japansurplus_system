let cart = (JSON.parse(sessionStorage.getItem('pos_cart')) || []).map(item => {
    const stock = Math.max(1, parseInt(item.stock, 10) || 1);
    return {
        ...item,
        quantity: Math.min(stock, Math.max(1, parseInt(item.quantity, 10) || 1)),
        stock,
        is_free: Boolean(item.is_free)
    };
});

function addCartItem(id, name, price, stock, isFree) {
    stock = Number(stock) || 0;
    if (stock <= 0) return;

    const productQuantity = cart
        .filter(item => Number(item.id) === Number(id))
        .reduce((quantity, item) => quantity + item.quantity, 0);
    if (productQuantity >= stock) {
        alert(`Only ${stock} unit${stock === 1 ? '' : 's'} in stock.`);
        return;
    }

    const existingItem = cart.find(item => Number(item.id) === Number(id) && Boolean(item.is_free) === isFree);
    if (existingItem) {
        existingItem.quantity += 1;
        existingItem.stock = stock;
    } else {
        cart.push({
            id: id,
            name: name,
            price: isFree ? 0 : price,
            quantity: 1,
            stock: stock,
            is_free: isFree
        });
    }

    updateCartUI();
}

function addToCart(id, name, price, stock) {
    addCartItem(id, name, price, stock, false);
}

function addFreeItem(id, name, stock) {
    addCartItem(id, name, 0, stock, true);
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
        document.getElementById('posSubtotal')?.replaceChildren('₱0.00');
        document.getElementById('posGrandTotal')?.replaceChildren('₱0.00');
        document.getElementById('posCartCount')?.replaceChildren('0 items');
        document.querySelectorAll('.fs-4, .text-danger.fs-4').forEach(el => el.innerText = '₱0.00');
        return;
    }

    let html = '';
    let subtotal = 0;

    cart.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        html += `
            <div class="pos-line-item">
                <div>
                    <span class="pos-line-item-name">${item.name}</span>
                    <span class="pos-line-item-price">${item.is_free ? 'FREE ITEM' : '₱' + item.price.toLocaleString('en-US', {minimumFractionDigits: 2})}</span>
                </div>
                <div class="pos-line-controls">
                    <button type="button" onclick="changeItemQuantity(${index}, -1)" aria-label="Decrease ${item.name} quantity"><i class="fa-solid fa-minus" aria-hidden="true"></i></button>
                    <span class="pos-line-quantity">${item.quantity}</span>
                    <button type="button" onclick="changeItemQuantity(${index}, 1)" aria-label="Increase ${item.name} quantity"><i class="fa-solid fa-plus" aria-hidden="true"></i></button>
                    <button type="button" onclick="removeItem(${index})" class="pos-line-remove" aria-label="Remove ${item.name}"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
                </div>
            </div>
        `;
    });

    cartContainer.innerHTML = html;

    const itemCount = cart.reduce((count, item) => count + item.quantity, 0);
    document.getElementById('posSubtotal')?.replaceChildren('₱' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2}));
    document.getElementById('posGrandTotal')?.replaceChildren('₱' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2}));
    document.getElementById('posCartCount')?.replaceChildren(`${itemCount} ${itemCount === 1 ? 'item' : 'items'}`);

    document.querySelectorAll('.text-danger.fs-4, .fs-4').forEach(el => {
        el.innerText = '₱' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2});
    });
}

function removeItem(index) {
    cart.splice(index, 1);
    updateCartUI();
}

function changeItemQuantity(index, change) {
    if (!cart[index]) return;

    if (change > 0) {
        const productQuantity = cart
            .filter(item => Number(item.id) === Number(cart[index].id))
            .reduce((quantity, item) => quantity + item.quantity, 0);
        if (productQuantity >= cart[index].stock) {
            alert(`Only ${cart[index].stock} unit${cart[index].stock === 1 ? '' : 's'} in stock.`);
            return;
        }
    }

    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
        removeItem(index);
        return;
    }
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