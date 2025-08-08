<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliteKicks - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-link {
            color: white !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #f8f9fa !important;
            transform: translateY(-1px);
        }
        .dashboard-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .stat-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            transform: translateY(-2px);
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        .action-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .action-card:hover {
            border-color: #667eea;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.15);
            color: inherit;
            text-decoration: none;
        }
        .action-card i {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-running me-2"></i>EliteKicks
            </a>
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
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1 class="mb-3">Welcome back, {{ $user->name }}! 👋</h1>
                <p class="lead mb-4">Ready to step into style? Explore our latest collection of premium sneakers.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('products') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <a href="{{ route('profile') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Statistics -->
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart mb-3" style="font-size: 2rem;"></i>
                        <h3>{{ count($recentOrders) }}</h3>
                        <p class="mb-0">Total Orders</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-heart mb-3" style="font-size: 2rem;"></i>
                        <h3>{{ $wishlistCount }}</h3>
                        <p class="mb-0">Wishlist Items</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <i class="fas fa-star mb-3" style="font-size: 2rem;"></i>
                        <h3>VIP</h3>
                        <p class="mb-0">Member Status</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card">
                <h3 class="mb-4">
                    <i class="fas fa-bolt text-primary me-2"></i>Quick Actions
                </h3>
                <div class="quick-actions">
                    <a href="{{ route('products') }}" class="action-card">
                        <i class="fas fa-shopping-bag"></i>
                        <h5>Browse Products</h5>
                        <p class="text-muted mb-0">Discover new arrivals</p>
                    </a>
                    <a href="{{ route('checkout') }}" class="action-card">
                        <i class="fas fa-credit-card"></i>
                        <h5>Quick Checkout</h5>
                        <p class="text-muted mb-0">Complete your purchase</p>
                    </a>
                    <a href="{{ route('profile') }}" class="action-card">
                        <i class="fas fa-user-cog"></i>
                        <h5>Account Settings</h5>
                        <p class="text-muted mb-0">Manage your profile</p>
                    </a>
                    <a href="#" class="action-card">
                        <i class="fas fa-history"></i>
                        <h5>Order History</h5>
                        <p class="text-muted mb-0">View past orders</p>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <h4 class="mb-4">
                            <i class="fas fa-clock text-primary me-2"></i>Recent Orders
                        </h4>
                        @if(count($recentOrders) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentOrders as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td><span class="badge bg-success">{{ $order->status }}</span></td>
                                                <td>${{ number_format($order->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No orders yet</h5>
                                <p class="text-muted">Start shopping to see your orders here!</p>
                                <a href="{{ route('products') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="dashboard-card">
                        <h4 class="mb-4">
                            <i class="fas fa-user text-primary me-2"></i>Account Info
                        </h4>
                        <div class="mb-3">
                            <strong>Email:</strong><br>
                            <span class="text-muted">{{ $user->email }}</span>
                        </div>
                        @if($user->phone)
                            <div class="mb-3">
                                <strong>Phone:</strong><br>
                                <span class="text-muted">{{ $user->phone }}</span>
                            </div>
                        @endif
                        <div class="mb-3">
                            <strong>Member since:</strong><br>
                            <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ route('profile') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-edit me-2"></i>Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>
</body>
</html>
