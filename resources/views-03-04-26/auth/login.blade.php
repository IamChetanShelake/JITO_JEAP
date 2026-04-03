@extends('layouts.app')

@section('content')
    <style>
        /* Base styles from your original code */
        .input-box {
            position: relative;
        }

        .input-box input {
            background: #F6F6F6;
            height: 50px;
            border-radius: 12px;
            border: 1px solid #E5E5E5;
            font-size: 18px;
            padding-left: 48px;
        }

        .input-box .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #6E6E6E;
        }

        /* Mobile responsive styles */
        @media (max-width: 991.98px) {
            /* Override desktop styles for mobile */
            .input-box input {
                height: 48px;
                font-size: 16px;
            }

            .container-fluid {
                padding: 0 !important;
            }

            .row.w-100 {
                margin: 0 !important;
            }

            .col-md-5 {
                padding: 0 !important;
                max-width: 100% !important;
            }

            .col-md-1 {
                display: none;
            }

            .card {
                border-radius: 0 !important;
                box-shadow: none !important;
                max-width: 100% !important;
                margin: 0 !important;
                border: none !important;
            }

            /* Mobile specific structure */
            .mobile-login-container {
                min-height: 100vh;
                background: white;
                display: flex;
                flex-direction: column;
            }

            .mobile-header {
                padding: 1.5rem;
                text-align: center;
                border-bottom: 1px solid #eee;
            }

            .mobile-logo {
                width: 180px;
            }

            .mobile-form-container {
                padding: 2rem;
                flex: 1;
            }

            .mobile-form-title {
                font-size: 24px;
                font-weight: 600;
                color: #4C4C4C;
                margin-bottom: 0.5rem;
                text-align: center;
            }

            .mobile-form-subtitle {
                font-size: 16px;
                color: #666;
                margin-bottom: 2rem;
                text-align: center;
            }

            .mobile-info-section {
                padding: 1.5rem;
                background: #f8f9fa;
                margin-top: auto;
            }

            .mobile-info-title {
                font-size: 18px;
                font-weight: 600;
                color: #4C4C4C;
                margin-bottom: 1rem;
            }

            .mobile-info-text {
                font-size: 15px;
                color: #666;
                line-height: 1.6;
            }

            .mobile-info-list {
                margin-top: 1rem;
            }

            .mobile-info-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 0.75rem;
                font-size: 15px;
                color: #666;
            }

            .mobile-info-icon {
                width: 16px;
                height: 16px;
                margin-right: 0.75rem;
                margin-top: 0.25rem;
                flex-shrink: 0;
            }

            .form-label {
                font-size: 16px;
                font-weight: 500;
                color: #4C4C4C;
                margin-bottom: 0.5rem;
            }

            .btn-login {
                background-color: #3E2B87;
                border: none;
                color: white;
                padding: 12px;
                border-radius: 12px;
                font-size: 16px;
                font-weight: 500;
                width: 100%;
                margin-top: 1rem;
            }

            .form-check {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
            }

            .form-check-input {
                width: 1.2em;
                height: 1.2em;
                margin-right: 0.75rem;
            }

            .forgot-password {
                color: #393185;
                text-decoration: none;
                font-size: 15px;
                margin-left: auto;
            }

            .register-link {
                text-align: center;
                margin-top: 1.5rem;
                font-size: 15px;
                color: #666;
            }

            .register-link a {
                color: #3E2B87;
                text-decoration: none;
                font-weight: 500;
            }

            /* Hide desktop elements on mobile */
            .desktop-section {
                display: none !important;
            }
        }

        /* Show mobile elements only on mobile */
        @media (min-width: 992px) {
            .mobile-login-container {
                display: none !important;
            }
        }

        /* Password toggle styles */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6E6E6E;
        }
    </style>

    <!-- Desktop View (Original Code) -->
    <div class="desktop-section">
        <div class="container-fluid"
            style="min-height:100vh; display:flex; align-items:center; justify-content:center; background-color:#fff;">
            <div class="row w-100 justify-content-center align-items-center mt-4">
                <!-- Left Section -->
                <div class="col-md-5 offset-md-1 mb-5 mb-md-0 text-start">
                    <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" class="mb-3" style="width:220px;">
                    <h4 class="fw-bold mb-3" style="font-size:25px;font-weight:500;color:#4C4C4C;">Educational Assistance Program
                    </h4>
                    <p class="text-muted mb-4" style="font-size:19px;font-weight:500; text-align:justify;">
                        Empowering Jain students to achieve their educational dream through financial support and community
                        guidance
                    </p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2" style="font-size:19px;font-weight:500;">
                            <img src="{{ asset('user/blueicon.png') }}" alt="" style="width:5%;">
                            Simple application process with just 7 steps
                        </li>
                        <li class="mb-2" style="font-size:19px;font-weight:500;">
                            <img src="{{ asset('user/blueicon.png') }}" alt="" style="width:5%;">
                            Quick review process within 7–10 business days
                        </li>
                        <li class="mb-2" style="font-size:19px;font-weight:500;">
                            <img src="{{ asset('user/blueicon.png') }}" alt="" style="width:5%;">
                            Supporting Jain students across all educational levels
                        </li>
                    </ul>
                </div>

                <!-- Right Section (Login Card) -->
                <div class="col-md-5">
                    <div class="card shadow-md border-0 p-4 rounded-4"
                        style="max-width:90%; margin:auto; background: transparent !important; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        <div class="card-body">
                            <h4 class="fw-semibold mb-1 text-start" style="font-size:28px; font-weight:500;color:#4C4C4C;">
                                Welcome back</h4>
                            <p class="text-muted text-start mb-4" style="font-size:19px;">Log in to continue your application</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:18px; color:#4C4C4C;">
                                        Email Address
                                    </label>

                                    <div class="input-box">
                                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="#6E6E6E" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                        </svg>

                                        <input id="email" type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="your.email@example.com" required autocomplete="off">
                                    </div>

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="font-size:18px; color:#4C4C4C;">
                                        Password
                                    </label>

                                    <div class="input-box">
                                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="#6E6E6E" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                        </svg>

                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password" required autocomplete="off">

                                        <span class="toggle-password" id="togglePassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z" />
                                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
                                            </svg>
                                        </span>
                                    </div>

                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" style="width: 1.5em;height: 1.5em;"
                                        name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="remember"
                                        style="font-size:18px;">&nbsp;&nbsp;Remember me</label>
                                    @if (Route::has('password.request'))
                                        <a class="float-end small text-decoration-none" href="{{ route('password.request') }}"
                                            style="font-size:18px; color:#393185;">Forgot password?</a>
                                    @endif
                                </div>

                                <!-- Submit -->
                                <div class="d-grid mt-2">
                                    <button type="submit" class="btn btn-primary fw-semibold"
                                        style="background-color:#3E2B87; border:none;font-size:17px;">Log In</button>
                                </div>
                                <hr class="" style="margin-top:30px;">

                                <!-- Register -->
                                <p class="text-center mt-3 small text-muted" style="font-size:19px;">
                                    Don't have an account? <a href="{{ route('register') }}"
                                        class="text-decoration-none fw-semibold" style="color:#3E2B87;">Create Account</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>

    <!-- Mobile View (New Structure) -->
    <div class="mobile-login-container d-lg-none">
        <div class="mobile-header">
            <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" class="mobile-logo">
        </div>

        <div class="mobile-form-container">
            <h3 class="mobile-form-title">Welcome back</h3>
            <p class="mobile-form-subtitle">Log in to continue your application</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>

                    <div class="input-box">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="#6E6E6E" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                        </svg>
                        <input id="email-mobile" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="your.email@example.com" required autocomplete="off">
                    </div>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>

                    <div class="input-box">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="#6E6E6E" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                        </svg>
                        <input id="password-mobile" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password" required autocomplete="off">
                        <span class="toggle-password" id="togglePasswordMobile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                            </svg>
                        </span>
                    </div>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember-mobile" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember-mobile">Remember me</label>
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">Log In</button>

                <p class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Create Account</a>
                </p>
            </form>
        </div>

        <div class="mobile-info-section">
            <h4 class="mobile-info-title">Educational Assistance Program</h4>
            <p class="mobile-info-text">
                Empowering Jain students to achieve their educational dream through financial support and community guidance
            </p>

            <div class="mobile-info-list">
                <div class="mobile-info-item">
                    <img src="{{ asset('user/blueicon.png') }}" alt="" class="mobile-info-icon">
                    <span>Simple application process with just 7 steps</span>
                </div>
                <div class="mobile-info-item">
                    <img src="{{ asset('user/blueicon.png') }}" alt="" class="mobile-info-icon">
                    <span>Quick review process within 7–10 business days</span>
                </div>
                <div class="mobile-info-item">
                    <img src="{{ asset('user/blueicon.png') }}" alt="" class="mobile-info-icon">
                    <span>Supporting Jain students across all educational levels</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Desktop password toggle
            const toggleDesktop = document.getElementById('togglePassword');
            const passwordDesktop = document.getElementById('password');

            if (toggleDesktop && passwordDesktop) {
                toggleDesktop.addEventListener('click', function() {
                    const type = passwordDesktop.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordDesktop.setAttribute('type', type);
                    this.innerHTML = type === 'text' ?
                        `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                            <path d="M3.35 5.47c-.18.165-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                        </svg>` :
                        `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                        </svg>`;
                });
            }

            // Mobile password toggle
            const toggleMobile = document.getElementById('togglePasswordMobile');
            const passwordMobile = document.getElementById('password-mobile');

            if (toggleMobile && passwordMobile) {
                toggleMobile.addEventListener('click', function() {
                    const type = passwordMobile.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordMobile.setAttribute('type', type);
                    this.innerHTML = type === 'text' ?
                        `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                            <path d="M3.35 5.47c-.18.165-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                        </svg>` :
                        `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                        </svg>`;
                });
            }
        });
    </script>
@endsection
