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

    // Siguraduhing nakasave bago lumipat ng page
    sessionStorage.setItem('pos_cart', JSON.stringify(cart));
    window.location.href = "/staff/sales/checkout";
}

// Auto-load ang cart pagbukas ng POS page
window.onload = function() {
    updateCartUI();
};