<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ohaiyo Japan - Sales and Stock Management System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="login-bg d-flex align-items-center justify-content-center">

    <div class="container py-5">

        <div class="row align-items-center justify-content-between g-5">

            <!-- LEFT -->
            <div class="col-lg-6 brand-section">

                <div class="d-inline-block mb-3">
                    <span class="badge badge-internal">
                        <i class="fa-solid fa-store me-1"></i>
                    </span>
                </div>

                <h1 class="display-5 fw-bold mb-3 text-white">
                    Ohaiyo Japan Surplus
                </h1>

                <h3 class="h4 fw-normal text-light opacity-85 mb-4">
                    Sales Recording and Stock Management System
                </h3>

                <div class="d-flex gap-4 text-light opacity-75 small">

                    <div>
                        <i class="fa-solid fa-warehouse text-danger me-1"></i>
                        Real-time Inventory
                    </div>

                    <div>
                        <i class="fa-solid fa-shield-halved text-danger me-1"></i>
                        Secure Access Control
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-5 col-md-8 mx-auto">

                <div class="glass-card p-4 p-md-5">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div class="logo-placeholder">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </div>

                        <div>
                            <h2 class="h4 fw-bold text-white mb-0">
                                Welcome Back
                            </h2>

                            <p class="text-light opacity-75 small mb-0">
                                Please sign in to your dashboard
                            </p>

                        </div>

                    </div>

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- LOGIN ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- VALIDATION ERRORS --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- LOGIN FORM -->
                    <form method="POST" action="{{ route('login.submit') }}">

                        @csrf

                        <!-- EMAIL -->

                        <div class="mb-3">

                            <label class="form-label text-light small fw-medium">
                                Email Address
                            </label>

                            <div class="position-relative">

                                <i class="fa-solid fa-user input-group-icon text-dark"></i>

                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email"
                                    required
                                    autofocus>

                            </div>

                        </div>

                        <!-- PASSWORD -->

                        <div class="mb-3">

                            <div class="d-flex justify-content-between">

                                <label class="form-label text-light small fw-medium">
                                    Password
                                </label>

                                <a href="#" class="small text-decoration-none">
                                    Forgot Password?
                                </a>

                            </div>

                            <div class="position-relative">

                                <i class="fa-solid fa-lock input-group-icon text-dark"></i>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required>

                                <button
                                    type="button"
                                    class="password-toggle"
                                    id="togglePassword">

                                    <i class="fa-solid fa-eye text-dark" id="toggleIcon"></i>
                                </button>

                            </div>

                        </div>

                        <!-- REMEMBER -->

                        <div class="mb-4 form-check">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember">

                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>

                        </div>

                        <!-- LOGIN BUTTON -->

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-primary-custom text-white">

                                <i class="fa-solid fa-right-to-bracket me-2"></i>

                                Sign In to Dashboard

                            </button>

                        </div>

                    </form>

                    <!-- FOOTER -->

                    <div class="text-center pt-4 border-top border-light border-opacity-10 mt-4">

                        <small class="text-light opacity-50">

                            © 2026 Ohaiyo Japan Surplus.
                            All Rights Reserved.

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>