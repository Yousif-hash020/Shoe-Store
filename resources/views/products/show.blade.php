<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - EliteKicks</title>
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
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
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

    <!-- Breadcrumb -->
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <!-- Product Images -->
                    <div class="product-images">
                        <div class="main-image mb-3">
                            <img src="{{ $product->image_url ?: 'https://via.placeholder.com/600x400?text=No+Image' }}"
                                 class="img-fluid rounded" alt="{{ $product->name }}" id="mainProductImage">
                        </div>

                        @if($product->image_gallery && count($product->image_gallery) > 0)
                        <div class="image-gallery">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ $product->image_url }}"
                                         class="img-fluid rounded gallery-thumb active"
                                         alt="{{ $product->name }}"
                                         onclick="changeMainImage(this.src)">
                                </div>
                                @foreach($product->image_gallery as $image)
                                <div class="col-3">
                                    <img src="{{ $image }}"
                                         class="img-fluid rounded gallery-thumb"
                                         alt="{{ $product->name }}"
                                         onclick="changeMainImage(this.src)">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Product Info -->
                    <div class="product-info">
                        <div class="product-category mb-2">{{ ucfirst($product->category) }}</div>
                        <h1 class="product-title mb-3">{{ $product->name }}</h1>

                        @if($product->rating > 0)
                        <div class="product-rating mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->rating))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $product->rating)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="ms-2">({{ $product->reviews_count }} reviews)</span>
                        </div>
                        @endif

                        <!-- Price -->
                        <div class="product-price mb-4">
                            @if($product->is_on_sale)
                                <span class="original-price text-muted text-decoration-line-through me-3">${{ number_format($product->price, 2) }}</span>
                                <span class="sale-price text-danger h3">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="badge bg-danger ms-2">Save ${{ number_format($product->price - $product->sale_price, 2) }}</span>
                            @else
                                <span class="current-price h3">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="product-description mb-4">
                            <p>{{ $product->short_description ?: $product->description }}</p>
                        </div>

                        <!-- Product Options -->
                        @if($product->colors && count($product->colors) > 0)
                        <div class="product-options mb-4">
                            <label class="form-label">Colors:</label>
                            <div class="color-options">
                                @foreach($product->colors as $color)
                                <input type="radio" class="btn-check" name="color" id="color_{{ $loop->index }}" value="{{ $color }}">
                                <label class="btn color-option" for="color_{{ $loop->index }}" style="background-color: {{ $color }};"></label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($product->size)
                        <div class="product-options mb-4">
                            <label class="form-label">Size:</label>
                            <div class="size-options">
                                @foreach(explode(',', $product->size) as $size)
                                <input type="radio" class="btn-check" name="size" id="size_{{ $loop->index }}" value="{{ trim($size) }}">
                                <label class="btn btn-outline-secondary" for="size_{{ $loop->index }}">{{ trim($size) }}</label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Stock Status -->
                        <div class="stock-status mb-4">
                            @if($product->stock_quantity > 0)
                                @if($product->stock_quantity <= 10)
                                    <span class="badge bg-warning">Only {{ $product->stock_quantity }} left in stock!</span>
                                @else
                                    <span class="badge bg-success">In Stock</span>
                                @endif
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </div>

                        <!-- Add to Cart -->
                        <div class="product-actions mb-4">
                            @if($product->stock_quantity > 0)
                                <div class="d-flex align-items-center mb-3">
                                    <label class="form-label me-3">Quantity:</label>
                                    <div class="quantity-selector">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decreaseQuantity()">-</button>
                                        <input type="number" class="form-control form-control-sm mx-2" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" style="width: 80px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>
                                <button class="btn btn-custom btn-lg add-to-cart-btn w-100 mb-2">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                            @else
                                <button class="btn btn-secondary btn-lg w-100 mb-2" disabled>
                                    <i class="fas fa-times me-2"></i>Out of Stock
                                </button>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="product-details">
                            <div class="accordion" id="productAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#description">
                                            Description
                                        </button>
                                    </h2>
                                    <div id="description" class="accordion-collapse collapse show" data-bs-parent="#productAccordion">
                                        <div class="accordion-body">
                                            {{ $product->description }}
                                        </div>
                                    </div>
                                </div>

                                @if($product->warranty_period)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#warranty">
                                            Warranty
                                        </button>
                                    </h2>
                                    <div id="warranty" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                                        <div class="accordion-body">
                                            This product comes with {{ $product->warranty_period }} warranty.
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="mb-4">Related Products</h3>
            <div class="row">
                @foreach($relatedProducts as $related)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card featured-shoe h-100">
                        <img src="{{ $related->image_url ?: 'https://via.placeholder.com/300x200?text=No+Image' }}"
                             class="card-img-top" alt="{{ $related->name }}">
                        <div class="card-body d-flex flex-column">
                            <div class="product-category">{{ ucfirst($related->category) }}</div>
                            <h6 class="card-title">{{ $related->name }}</h6>
                            <div class="mt-auto">
                                <p class="card-text mb-2">${{ number_format($related->price, 2) }}</p>
                                <a href="{{ route('product.show', $related->slug) }}" class="btn btn-custom btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>

    <script>
        function changeMainImage(src) {
            document.getElementById('mainProductImage').src = src;

            // Update active thumbnail
            document.querySelectorAll('.gallery-thumb').forEach(thumb => {
                thumb.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }
    </script>
</body>
</html>
