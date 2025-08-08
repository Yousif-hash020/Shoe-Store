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
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #f39c12;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            padding: 1rem 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-1px);
        }

        .dashboard-container {
            padding: 6rem 0 4rem;
        }

        .welcome-hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            color: white;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>');
            background-size: 100px 100px;
            opacity: 0.1;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .dashboard-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            padding: 1.5rem 2rem;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.orders {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #c0392b 100%);
        }

        .stat-icon.wishlist {
            background: linear-gradient(135deg, var(--accent-color) 0%, #d68910 100%);
        }

        .stat-icon.member {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a252f 100%);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3);
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
            border-radius: 2px;
        }

        .quick-action-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .quick-action-card:hover {
            border-color: var(--secondary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(231, 76, 60, 0.15);
            color: inherit;
            text-decoration: none;
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.3rem;
            color: white;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(231, 76, 60, 0.05);
        }

        .badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        .member-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--accent-color) 0%, #f1c40f 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 5rem 0 2rem;
            }

            .welcome-hero {
                padding: 2rem;
                margin-bottom: 2rem;
            }

            .card-body-custom {
                padding: 1.5rem;
            }
        }
    </style>
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
                </ul>
                <ul class="navbar-nav ms-auto">
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
                </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Welcome Hero Section -->
            <div class="welcome-hero">
                <div class="welcome-content">
                    <h1 class="mb-3">Welcome back, {{ $user->name }}! 👋</h1>
                    <p class="lead mb-4">Ready to step into style? Explore our latest collection of premium sneakers and discover your perfect pair.</p>
                    <div class="member-badge">
                        <i class="fas fa-crown me-2"></i>Elite Member
                    </div>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                        <a href="{{ route('products') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Shop Collection
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orders">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-number">{{ count($recentOrders) }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon wishlist">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-number">{{ $wishlistCount }}</div>
                        <div class="stat-label">Wishlist Items</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon member">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="stat-number">{{ $user->created_at->diffInDays(now()) }}</div>
                        <div class="stat-label">Days with us</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card mb-4">
                <div class="card-header-custom">
                    <h4 class="section-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h4>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('products') }}" class="quick-action-card">
                                <div class="action-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <h5 class="mb-2">Browse Products</h5>
                                <p class="text-muted mb-0">Discover new arrivals</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('checkout') }}" class="quick-action-card">
                                <div class="action-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <h5 class="mb-2">Quick Checkout</h5>
                                <p class="text-muted mb-0">Complete your purchase</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('profile') }}" class="quick-action-card">
                                <div class="action-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <h5 class="mb-2">Account Settings</h5>
                                <p class="text-muted mb-0">Manage your profile</p>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="quick-action-card">
                                <div class="action-icon">
                                    <i class="fas fa-history"></i>
                                </div>
                                <h5 class="mb-2">Order History</h5>
                                <p class="text-muted mb-0">View past orders</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="dashboard-card">
                        <div class="card-header-custom">
                            <h4 class="section-title mb-0">
                                <i class="fas fa-clock me-2"></i>Recent Orders
                            </h4>
                        </div>
                        <div class="card-body-custom">
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
                                                    <td><strong>#{{ $order->id }}</strong></td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td><span class="badge bg-success">{{ $order->status }}</span></td>
                                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-shopping-cart"></i>
                                    <h5 class="mt-3 mb-2">No orders yet</h5>
                                    <p class="mb-3">Start shopping to see your orders here!</p>
                                    <a href="{{ route('products') }}" class="btn btn-custom">
                                        <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="dashboard-card">
                        <div class="card-header-custom">
                            <h4 class="section-title mb-0">
                                <i class="fas fa-user me-2"></i>Account Info
                            </h4>
                        </div>
                        <div class="card-body-custom">
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
                            <div class="mb-4">
                                <strong>Member since:</strong><br>
                                <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <a href="{{ route('profile') }}" class="btn btn-outline-custom w-100">
                                <i class="fas fa-edit me-2"></i>Update Profile
                            </a>
                        </div>
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
