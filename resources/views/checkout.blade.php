<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliteKicks - Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/checkout.css') }}">

<body>


    <section class="py-5" style="margin-top: 60px;">
        <div class="container">
            <div class="section-title">
                <h2>Checkout</h2>
                <p>Review your cart and complete your purchase</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="checkout-summary">
                        <h4 class="mb-4">Order Summary</h4>
                        <div id="checkoutCartItems"></div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <strong>Total:</strong>
                            <span id="checkoutCartTotal" class="checkout-total">$0.00</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="checkout-summary">
                        <h4 class="mb-4">Shipping & Payment Details</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                            </div>
                            <div class="row">
                                <div class="col-8 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label for="zip" class="form-label">ZIP</label>
                                    <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}" required>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="card" class="form-label">Card Number</label>
                                <input type="text" class="form-control" id="card" name="card" maxlength="19" placeholder="1234 5678 9012 3456" value="{{ old('card') }}" required>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="expiry" class="form-label">Expiry</label>
                                    <input type="text" class="form-control" id="expiry" name="expiry" maxlength="5" placeholder="MM/YY" value="{{ old('expiry') }}" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="4" value="{{ old('cvv') }}" required>
                                </div>
                            </div>
                            <button class="btn btn-success w-100 btn-lg shadow mb-2 rounded-pill" type="submit" id="proceedCheckoutBtn" style="font-size:1.2rem;letter-spacing:1px;">Proceed to Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <li><a href="index.html#products" class="text-white">Products</a></li>
                        <li><a href="index.html#about" class="text-white">New Arrivals</a></li>
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
                <p>&copy; 2024 EliteKicks. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <script src="{{ asset('frontend/js/checkout.js') }}"></script>
</body>
</html>
