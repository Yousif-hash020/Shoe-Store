<!-- Product Listing Page for EliteKicks -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliteKicks - Shop All Shoes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Global + Page Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/product.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">EliteKicks</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#products">Featured</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Sidebar (re‑used) -->
    <div id="cartSidebar" class="cart-sidebar">
        <div class="cart-sidebar-header">
            <h4>Your Cart</h4>
            <button class="close-cart-sidebar" onclick="closeCartSidebar()">&times;</button>
        </div>
        <div id="cartSidebarItems" class="cart-sidebar-items">
            <p class="cart-empty">Your cart is empty.</p>
        </div>
        <div class="cart-sidebar-footer">
            <strong>Total: $<span id="cartSidebarTotal">0.00</span></strong>
            <a href="{{ route('checkout') }}" class="btn btn-success w-100 mt-3">Proceed to Checkout</a>
        </div>
    </div>
    <div id="cartSidebarOverlay" class="cart-sidebar-overlay" onclick="closeCartSidebar()"></div>

    <!-- Products Section -->
    <section class="product-section py-5" id="products" style="margin-top: 80px;">
        <div class="container">
            <div class="section-title">
                <h2>Shop All Shoes</h2>
                <p>Browse our complete collection across every category.</p>
            </div>

            <!-- Filters & Sort  -->
            <div class="d-flex flex-wrap align-items-center mb-4">
                <div class="product-filters flex-grow-1">
                    <button class="btn btn-filter active" data-filter="all">All</button>
                    <button class="btn btn-filter" data-filter="running">Running</button>
                    <button class="btn btn-filter" data-filter="casual">Casual</button>
                    <button class="btn btn-filter" data-filter="basketball">Basketball</button>
                    <button class="btn btn-filter" data-filter="training">Training</button>
                </div>
                <div class="sort-options">
                    <select id="sortSelect" class="form-select">
                        <option value="default">Sort By</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="rating-desc">Rating: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- Product Grid -->
                <div class="row" id="productGrid">
                    <!-- Card 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">New</span>
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 1">
                            <div class="card-body">
                                <div class="product-category">Running</div>
                                <h5 class="card-title">Air Max Pro</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(128 reviews)</span>
                                </div>
                                <p class="product-description">Lightweight running shoes with maximum cushioning and support for long-distance runners.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #000;"></span>
                                    <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                </div>
                                <p class="card-text">$129.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">Sale</span>
                            <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 2">
                            <div class="card-body">
                                <div class="product-category">Casual</div>
                                <h5 class="card-title">Classic Runner</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span>(95 reviews)</span>
                                </div>
                                <p class="product-description">Timeless design meets modern comfort in these versatile everyday sneakers.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #2c3e50;"></span>
                                    <span class="color-option" style="background-color: #95a5a6;"></span>
                                    <span class="color-option" style="background-color: #f39c12;"></span>
                                </div>
                                <p class="card-text">$99.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">Popular</span>
                            <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 3">
                            <div class="card-body">
                                <div class="product-category">Urban</div>
                                <h5 class="card-title">Urban Sneaker</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>(256 reviews)</span>
                                </div>
                                <p class="product-description">Street-style sneakers with premium materials and urban-inspired design.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #34495e;"></span>
                                    <span class="color-option" style="background-color: #e74c3c;"></span>
                                    <span class="color-option" style="background-color: #f1c40f;"></span>
                                </div>
                                <p class="card-text">$149.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-4 mb-4">
                        <div class="card featured-shoe">
                            <span class="product-badge">Limited</span>
                            <img src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 4">
                            <div class="card-body">
                                <div class="product-category">Lifestyle</div>
                                <h5 class="card-title">Retro Classic</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>(178 reviews)</span>
                                </div>
                                <p class="product-description">Vintage-inspired design with modern comfort technology for everyday wear.</p>
                                <div class="product-colors">
                                    <span class="color-option active" style="background-color: #1abc9c;"></span>
                                    <span class="color-option" style="background-color: #3498db;"></span>
                                    <span class="color-option" style="background-color: #9b59b6;"></span>
                                </div>
                                <p class="card-text">$119.99</p>
                                <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                            </div>
                        </div>
                    </div>

                            <!-- Card 5 -->
                   <div class="col-md-4 mb-4">
                                <div class="card featured-shoe">
                                    <span class="product-badge">Trending</span>
                                    <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 5">
                                    <div class="card-body">
                                        <div class="product-category">Athletic</div>
                                        <h5 class="card-title">Performance Pro</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <span>(203 reviews)</span>
                                        </div>
                                        <p class="product-description">High-performance athletic shoes designed for serious athletes and fitness enthusiasts.</p>
                                        <div class="product-colors">
                                            <span class="color-option active" style="background-color: #e67e22;"></span>
                                            <span class="color-option" style="background-color: #2ecc71;"></span>
                                            <span class="color-option" style="background-color: #3498db;"></span>
                                        </div>
                                        <p class="card-text">$159.99</p>
                                        <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 6 -->
                            <div class="col-md-4 mb-4">
                                <div class="card featured-shoe">
                                    <span class="product-badge">Best Seller</span>
                                    <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="Shoe 6">
                                    <div class="card-body">
                                        <div class="product-category">Fashion</div>
                                        <h5 class="card-title">Street Style</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <span>(312 reviews)</span>
                                        </div>
                                        <p class="product-description">Fashion-forward sneakers that combine style and comfort for the modern urbanite.</p>
                                        <div class="product-colors">
                                            <span class="color-option active" style="background-color: #2c3e50;"></span>
                                            <span class="color-option" style="background-color: #e74c3c;"></span>
                                            <span class="color-option" style="background-color: #f1c40f;"></span>
                                        </div>
                                        <p class="card-text">$139.99</p>
                                        <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                                    </div>
                                </div>
                            </div>

                </div>
            </div>

            <!-- Bootstrap Pagination -->
            <nav aria-label="Product pagination" class="my-4">
              <ul class="pagination justify-content-center" id="paginationBar">
                <!-- Pagination will be injected here by JavaScript -->
              </ul>
            </nav>

        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>EliteKicks</h5>
                    <p>Your destination for premium footwear. We offer the latest trends in athletic, casual, and lifestyle shoes.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.html#home" class="text-white">Home</a></li>
                        <li><a href="index.html#products" class="text-white">Featured</a></li>
                        <li><a href="#products" class="text-white">All Products</a></li>
                        <li><a href="index.html#categories" class="text-white">Categories</a></li>
                        <li><a href="index.html#contact" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Shoe Street, Fashion City</li>
                        <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                        <li><i class="fas fa-envelope me-2"></i> info@elitekicks.com</li>
                        <li><i class="fas fa-clock me-2"></i> Mon - Fri: 9:00 AM - 6:00 PM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 EliteKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <script src="{{ asset('frontend/js/product.js') }}"></script>
</body>
</html>
