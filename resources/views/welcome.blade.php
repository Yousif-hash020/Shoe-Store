<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliteKicks - Premium Footwear</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}">
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
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>

                <!-- User Actions -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- Authenticated User Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Guest User Actions -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Sign Up
                            </a>
                        </li>
                    @endauth

                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" onclick="openCartSidebar()">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7em;">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!-- Cart Sidebar -->
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

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-carousel carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Shoe 1">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Shoe 2">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Shoe 3">
                </div>
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 hero-content">
                    <h1 class="display-3 fw-bold mb-4">Step Into Style</h1>
                    <p class="lead mb-4">Discover the perfect pair that matches your personality and lifestyle. Premium quality, unmatched comfort.</p>
                    <a href="#products" class="btn btn-custom">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Message -->
    @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Featured Products -->
    <section class="py-5" id="products">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>s
                <p>Discover our latest collection of premium footwear</p>
            </div>
            <div class="row">
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
                        <img src="Green_Grey_White_2_65890aeb-2672-4728-b8bb-633c3e3de84a.webp" class="card-img-top" alt="Shoe 4">
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
    </section>

    <!-- Special Offers Section -->
    <section class="py-5" id="offers">
        <div class="container">
            <div class="section-title">
                <h2>Special Offers</h2>
                <p>Don't miss out on these exclusive deals</p>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="offer-card">
                        <div class="offer-badge">Limited Time</div>
                        <div class="offer-image">
                            <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Summer Sale">
                        </div>
                        <div class="offer-content">
                            <h3>Summer Sale</h3>
                            <p class="offer-description">Up to 50% off</p>
                            <div class="offer-timer">
                                <span class="timer-number">05</span>
                                <span class="timer-label">Days Left</span>
                            </div>
                            <a href="#" class="btn btn-custom">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="offer-card">
                        <div class="offer-badge">New Arrival</div>
                        <div class="offer-image">
                            <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Back to School">
                        </div>
                        <div class="offer-content">
                            <h3>Back to School</h3>
                            <p class="offer-description">30% off</p>
                            <div class="offer-features">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Free Shipping</span>
                            </div>
                            <a href="#" class="btn btn-custom">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="offer-card">
                        <div class="offer-badge">Members Only</div>
                        <div class="offer-image">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="VIP Exclusive">
                        </div>
                        <div class="offer-content">
                            <h3>VIP Exclusive</h3>
                            <p class="offer-description">25% off</p>
                            <div class="offer-percentage">
                                <span class="percentage">25%</span>
                            </div>
                            <a href="#" class="btn btn-custom">Join Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="offer-card">
                        <div class="offer-badge">Flash Sale</div>
                        <div class="offer-image">
                            <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Weekend Special">
                        </div>
                        <div class="offer-content">
                            <h3>Weekend Special</h3>
                            <p class="offer-description">Limited Time</p>
                            <div class="offer-countdown">
                                <span class="countdown-number">24</span>
                                <span class="countdown-label">Hours Left</span>
                            </div>
                            <a href="#" class="btn btn-custom">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="about">
        <div class="container">
            <div class="section-title">
                <h2>New Arrivals</h2>
                <p>Be the first to get your hands on our latest collection</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card featured-shoe">
                        <span class="product-badge">Just In</span>
                        <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="New Arrival 1">
                        <div class="card-body">
                            <div class="product-category">Running</div>
                            <h5 class="card-title">Air Max Pro 2024</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(128 reviews)</span>
                            </div>
                            <p class="product-description">Next-gen running technology with enhanced cushioning</p>
                            <div class="product-colors">
                                <span class="color-option active" style="background-color: #000;"></span>
                                <span class="color-option" style="background-color: #fff; border: 1px solid #ddd;"></span>
                                <span class="color-option" style="background-color: #e74c3c;"></span>
                            </div>
                            <p class="card-text">$149.99</p>
                            <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card featured-shoe">
                        <span class="product-badge">Limited</span>
                        <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="New Arrival 2">
                        <div class="card-body">
                            <div class="product-category">Lifestyle</div>
                            <h5 class="card-title">Urban Classic X</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(95 reviews)</span>
                            </div>
                            <p class="product-description">Street-inspired design meets premium comfort</p>
                            <div class="product-colors">
                                <span class="color-option active" style="background-color: #2c3e50;"></span>
                                <span class="color-option" style="background-color: #95a5a6;"></span>
                                <span class="color-option" style="background-color: #f39c12;"></span>
                            </div>
                            <p class="card-text">$129.99</p>
                            <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card featured-shoe">
                        <span class="product-badge">Exclusive</span>
                        <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="New Arrival 3">
                        <div class="card-body">
                            <div class="product-category">Athletic</div>
                            <h5 class="card-title">Performance Elite</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(256 reviews)</span>
                            </div>
                            <p class="product-description">Professional-grade athletic footwear</p>
                            <div class="product-colors">
                                <span class="color-option active" style="background-color: #34495e;"></span>
                                <span class="color-option" style="background-color: #e74c3c;"></span>
                                <span class="color-option" style="background-color: #f1c40f;"></span>
                            </div>
                            <p class="card-text">$169.99</p>
                            <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card featured-shoe">
                        <span class="product-badge">New Season</span>
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="New Arrival 4">
                        <div class="card-body">
                            <div class="product-category">Training</div>
                            <h5 class="card-title">Flex Trainer Pro</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(182 reviews)</span>
                            </div>
                            <p class="product-description">Versatile training shoe with responsive cushioning</p>
                            <div class="product-colors">
                                <span class="color-option active" style="background-color: #3498db;"></span>
                                <span class="color-option" style="background-color: #2ecc71;"></span>
                                <span class="color-option" style="background-color: #9b59b6;"></span>
                            </div>
                            <p class="card-text">$139.99</p>
                            <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card featured-shoe">
                        <span class="product-badge">Premium</span>
                        <img src="https://images.unsplash.com/photo-1539185441755-769473a23570?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="New Arrival 5">
                        <div class="card-body">
                            <div class="product-category">Lifestyle</div>
                            <h5 class="card-title">Cloud Walker Plus</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(147 reviews)</span>
                            </div>
                            <p class="product-description">Premium comfort for all-day wear and style</p>
                            <div class="product-colors">
                                <span class="color-option active" style="background-color: #7f8c8d;"></span>
                                <span class="color-option" style="background-color: #c0392b;"></span>
                                <span class="color-option" style="background-color: #2980b9;"></span>
                            </div>
                            <p class="card-text">$159.99</p>
                            <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card featured-shoe">
                        <span class="product-badge">Trending</span>
                        <img src="https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="New Arrival 6">
                        <div class="card-body">
                            <div class="product-category">Sport</div>
                            <h5 class="card-title">Speed Runner X</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(203 reviews)</span>
                            </div>
                            <p class="product-description">Lightweight racing shoe with carbon fiber plate</p>
                            <div class="product-colors">
                                <span class="color-option active" style="background-color: #e74c3c;"></span>
                                <span class="color-option" style="background-color: #3498db;"></span>
                                <span class="color-option" style="background-color: #2ecc71;"></span>
                            </div>
                            <p class="card-text">$179.99</p>
                            <a href="#" class="btn btn-custom add-to-cart-btn">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-custom btn-lg show-more">Show More New Arrivals <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5" id="categories">
        <div class="container">
            <div class="section-title">
                <h2>Shop by Category</h2>
                <p>Explore our wide range of footwear categories</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Running Shoes">
                            <div class="category-overlay">
                                <h3>Running</h3>
                                <p>Performance footwear for athletes</p>
                                <a href="#" class="btn btn-custom">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <img src="https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Casual Shoes">
                            <div class="category-overlay">
                                <h3>Casual</h3>
                                <p>Everyday comfort and style</p>
                                <a href="#" class="btn btn-custom">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Sports Shoes">
                            <div class="category-overlay">
                                <h3>Sports</h3>
                                <p>Specialized athletic footwear</p>
                                <a href="#" class="btn btn-custom">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Formal Shoes">
                            <div class="category-overlay">
                                <h3>Formal</h3>
                                <p>Elegant and sophisticated</p>
                                <a href="#" class="btn btn-custom">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Sneakers">
                            <div class="category-overlay">
                                <h3>Sneakers</h3>
                                <p>Urban and trendy styles</p>
                                <a href="#" class="btn btn-custom">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Sandals">
                            <div class="category-overlay">
                                <h3>Sandals</h3>
                                <p>Comfortable summer footwear</p>
                                <a href="#" class="btn btn-custom">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Get in Touch</h2>
                <p>Have questions or feedback? We'd love to hear from you!</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom">Send Message</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <h4>Contact Information</h4>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Shoe Street, Fashion City</p>
                        <p><i class="fas fa-phone"></i> +1 234 567 890</p>
                        <p><i class="fas fa-envelope"></i> info@elitekicks.com</p>
                        <p><i class="fas fa-clock"></i> Mon - Fri: 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
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
                        <li><a href="#home" class="text-white">Home</a></li>
                        <li><a href="#products" class="text-white">Products</a></li>
                        <li><a href="#about" class="text-white">New Arrivals</a></li>
                        <li><a href="#categories" class="text-white">Categories</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
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
                <p>&copy; 2024 EliteKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>

</body>
</html>
