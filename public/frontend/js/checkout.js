// checkout.js - Handles displaying cart items on the checkout page and proceeding to payment

// Utility: Get cart from localStorage or fallback to empty
function getCart() {
    try {
        return JSON.parse(localStorage.getItem('cart')) || [];
    } catch {
        return [];
    }
}

// Utility: Save cart to localStorage
function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Render cart items in checkout page
function renderCheckoutCart() {
    const cart = getCart();
    const cartItemsDiv = document.getElementById('checkoutCartItems');
    const cartTotalSpan = document.getElementById('checkoutCartTotal');
    if (!cartItemsDiv || !cartTotalSpan) return;
    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<div class="checkout-empty">Your cart is empty.</div>';
        cartTotalSpan.textContent = '$0.00';
        return;
    }
    let subtotal = 0;
    let table = `<table class="table checkout-table table-striped align-middle">
        <thead><tr><th>Product</th><th></th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead><tbody>`;
    cart.forEach((item, idx) => {
        let itemSubtotal = item.price * item.qty;
        subtotal += itemSubtotal;
        table += `<tr>
            <td style="width:70px"><img src="${item.img}" alt="${item.title}" style="width:60px;border-radius:12px;"></td>
            <td>${item.title}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td>
                <button class="btn btn-sm btn-outline-secondary me-1" onclick="updateQty(${idx},-1)" aria-label="Decrease quantity">&minus;</button>
                <span class="mx-1">${item.qty}</span>
                <button class="btn btn-sm btn-outline-secondary ms-1" onclick="updateQty(${idx},1)" aria-label="Increase quantity">&plus;</button>
            </td>
            <td>$${itemSubtotal.toFixed(2)}</td>
            <td><button class="btn btn-sm btn-danger" onclick="removeItem(${idx})">Remove</button></td>
        </tr>`;
    });
    table += '</tbody>';
    // Calculate tax and delivery
    let tax = subtotal * 0.08;
    let delivery = subtotal > 0 ? 10 : 0;
    let grandTotal = subtotal + tax + delivery;
    // Summary rows
    table += `<tfoot>
        <tr><td colspan="4"></td><td class="text-end"><strong>Subtotal:</strong></td><td>$${subtotal.toFixed(2)}</td></tr>
        <tr><td colspan="4"></td><td class="text-end">Tax (8%):</td><td>$${tax.toFixed(2)}</td></tr>
        <tr><td colspan="4"></td><td class="text-end">Delivery Fee:</td><td>$${delivery.toFixed(2)}</td></tr>
        <tr><td colspan="4"></td><td class="text-end"><strong>Grand Total:</strong></td><td><strong>$${grandTotal.toFixed(2)}</strong></td></tr>
    </tfoot>`;
    table += '</table>';
    cartItemsDiv.innerHTML = table;
    cartTotalSpan.textContent = `$${grandTotal.toFixed(2)}`;
}

// Quantity update
window.updateQty = function(idx, delta) {
    let cart = getCart();
    if (!cart[idx]) return;
    cart[idx].qty += delta;
    if (cart[idx].qty < 1) cart[idx].qty = 1;
    setCart(cart);
    renderCheckoutCart();
}

// Remove item
window.removeItem = function(idx) {
    let cart = getCart();
    cart.splice(idx, 1);
    setCart(cart);
    renderCheckoutCart();
}

// Handle checkout form submission
function handleCheckoutForm() {
    const form = document.getElementById('checkoutForm');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }
        // In real app, send data to server here
        alert('Thank you for your purchase!\nYour order has been placed.');
        setCart([]);
        renderCheckoutCart();
        form.reset();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    renderCheckoutCart();
    handleCheckoutForm();
});
