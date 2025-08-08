// Navbar scroll effect and transitions
document.addEventListener('DOMContentLoaded', function() {
    // --- Cart Sidebar Logic ---
    let cartSidebar = document.getElementById('cartSidebar');
    let cartSidebarOverlay = document.getElementById('cartSidebarOverlay');
    let cartSidebarItems = document.getElementById('cartSidebarItems');
    let cartSidebarTotal = document.getElementById('cartSidebarTotal');
    let cart = [];
    let cartCountSpan = null;

    function updateCartCount() {
        if (!cartCountSpan) {
            const icon = document.querySelector('.cart-icon .cart-count');
            if (icon) cartCountSpan = icon;
        }
        if (cartCountSpan) {
            let count = cart.reduce((sum, item) => sum + item.qty, 0);
            cartCountSpan.textContent = count;
        }
    }

    function openCartSidebar() {
        cartSidebar.classList.add('open');
        cartSidebarOverlay.classList.add('open');
    }
    window.openCartSidebar = openCartSidebar;

    function closeCartSidebar() {
        cartSidebar.classList.remove('open');
        cartSidebarOverlay.classList.remove('open');
    }
    window.closeCartSidebar = closeCartSidebar;

    function updateCartSidebar() {
        cartSidebarItems.innerHTML = '';
        if (cart.length === 0) {
            cartSidebarItems.innerHTML = '<p class="cart-empty">Your cart is empty.</p>';
            cartSidebarTotal.textContent = '0.00';
            updateCartCount();
            return;
        }
        let total = 0;
        cart.forEach((item, idx) => {
            total += item.price * item.qty;
            const div = document.createElement('div');
            div.className = 'cart-sidebar-item card shadow-sm mb-3 p-2 d-flex align-items-center';
            div.style.borderRadius = '12px';
            div.innerHTML = `
                <img src="${item.img}" class="me-2" alt="${item.title}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                <div class="flex-grow-1">
                    <div class="fw-semibold">${item.title}</div>
                    <div class="text-success">$${item.price.toFixed(2)}</div>
                    <div class="small">Qty: ${item.qty}</div>
                </div>
                <span class="cart-sidebar-item-remove" data-idx="${idx}" title="Remove">&times;</span>
            `;
            cartSidebarItems.appendChild(div);
        });
        cartSidebarTotal.textContent = total.toFixed(2);
        updateCartCount();

        // Remove any existing Checkout button to prevent duplicates
        let oldBtn = document.getElementById('sidebarCheckoutBtn');
        if (oldBtn) oldBtn.remove();
        // Add Checkout button below cart items if cart is not empty
        let checkoutBtn = document.createElement('a');
        checkoutBtn.href = 'checkout.html';
        checkoutBtn.className = 'btn btn-success w-100 btn-lg rounded-pill shadow-sm mb-2';
        checkoutBtn.textContent = 'Checkout';
        checkoutBtn.id = 'sidebarCheckoutBtn';
        // Save cart to localStorage on click
        checkoutBtn.addEventListener('click', function() {
            localStorage.setItem('cart', JSON.stringify(cart));
        });
        cartSidebarItems.parentElement.appendChild(checkoutBtn);
    }

    // Delegate Add to Cart buttons and cart item removal
    document.body.addEventListener('click', function(e) {
        // Add to Cart logic
        if (e.target.classList.contains('add-to-cart-btn')) {
            e.preventDefault();
            let card = e.target.closest('.card');
            if (!card) return;
            let titleElem = card.querySelector('.card-title');
            let priceElem = card.querySelector('.card-text');
            let imgElem = card.querySelector('img');
            if (!titleElem || !priceElem || !imgElem) return;
            let title = titleElem.innerText.trim();
            let price = parseFloat(priceElem.innerText.replace('$',''));
            let img = imgElem.src;
            // Check if item already in cart
            let existing = cart.find(item => item.title === title);
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({ title, price, img, qty: 1 });
            }
            updateCartSidebar();
            showCartAddedMessage();
        }
        // Remove item from cart logic
        if (e.target.classList.contains('cart-sidebar-item-remove')) {
            let idx = parseInt(e.target.getAttribute('data-idx'));
            if (!isNaN(idx)) {
                cart.splice(idx, 1);
                updateCartSidebar();
            }
        }
    });

    // Get the existing cart count element from the HTML template
    cartCountSpan = document.getElementById('cartBadge');
    updateCartSidebar();

    // The cart icon click is already handled by the onclick="openCartSidebar()" in the HTML template

    // Show a temporary toast/message when item is added to cart
    function showCartAddedMessage() {
        let toast = document.createElement('div');
        toast.className = 'cart-toast';
        toast.innerText = 'Added to cart!';
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 1500);
    }

    // --- End Cart Sidebar Logic ---

    const navbar = document.querySelector('.navbar');
    const sections = document.querySelectorAll('.section');
    const heroContent = document.querySelector('.hero-content');

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Intersection Observer for section transitions
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    // Observe all sections
    sections.forEach(section => {
        observer.observe(section);
    });

    // Observe hero content
    if (heroContent) {
        observer.observe(heroContent);
    }

    // Observe product cards
    const productCards = document.querySelectorAll('.featured-shoe');
    productCards.forEach(card => {
        observer.observe(card);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
