<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - EliteKicks</title>
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
                        <a class="nav-link active" href="{{ route('products') }}">Products</a>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">Our Products</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="filters-sidebar">
                        <h5 class="mb-3">Filter Products</h5>

                        <!-- Search -->
                        <div class="filter-group mb-4">
                            <label class="form-label">Search</label>
                            <form method="GET" action="{{ route('products') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search products...">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                @foreach(request()->except(['search', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>

                        <!-- Categories -->
                        @if($categories->count() > 0)
                        <div class="filter-group mb-4">
                            <label class="form-label">Categories</label>
                            <div class="filter-options">
                                @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="{{ $category }}"
                                           id="cat_{{ $loop->index }}" {{ request('category') == $category ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="cat_{{ $loop->index }}">
                                        {{ ucfirst($category) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Brands -->
                        @if($brands->count() > 0)
                        <div class="filter-group mb-4">
                            <label class="form-label">Brands</label>
                            <div class="filter-options">
                                @foreach($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="brand" value="{{ $brand }}"
                                           id="brand_{{ $loop->index }}" {{ request('brand') == $brand ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="brand_{{ $loop->index }}">
                                        {{ ucfirst($brand) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Clear Filters -->
                        @if(request()->hasAny(['search', 'category', 'brand', 'price_min', 'price_max', 'featured', 'in_stock']))
                        <div class="filter-group">
                            <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-2"></i>Clear Filters
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Sort Options -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                        <form method="GET" action="{{ route('products') }}" class="d-flex align-items-center">
                            @foreach(request()->except(['sort', 'order']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            </select>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card featured-shoe h-100">
                                @if($product->is_featured)
                                    <span class="product-badge">Featured</span>
                                @endif
                                @if($product->is_on_sale)
                                    <span class="product-badge sale-badge">Sale</span>
                                @endif

                                <img src="{{ $product->image_url ?: 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                     class="card-img-top" alt="{{ $product->name }}">

                                <div class="card-body d-flex flex-column">
                                    <div class="product-category">{{ ucfirst($product->category) }}</div>
                                    <h5 class="card-title">{{ $product->name }}</h5>

                                    @if($product->rating > 0)
                                    <div class="product-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $product->rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span>({{ $product->reviews_count }} reviews)</span>
                                    </div>
                                    @endif

                                    <p class="product-description">{{ $product->short_description ?: \Illuminate\Support\Str::limit($product->description, 100) }}</p>

                                    @if($product->colors)
                                    <div class="product-colors">
                                        @foreach($product->colors as $color)
                                        <span class="color-option" style="background-color: {{ $color }};"></span>
                                        @endforeach
                                    </div>
                                    @endif

                                    <div class="mt-auto">
                                        <div class="price-section mb-3">
                                            @if($product->is_on_sale)
                                                <span class="text-muted text-decoration-line-through me-2">${{ number_format($product->price, 2) }}</span>
                                                <span class="text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                                            @else
                                                <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>

                                        @if($product->stock_quantity > 0)
                                            <button class="btn btn-custom add-to-cart-btn w-100">
                                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        @else
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="fas fa-times me-2"></i>Out of Stock
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">No products found</h4>
                        <p class="text-muted">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('products') }}" class="btn btn-custom">View All Products</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>
</body>
</html>
