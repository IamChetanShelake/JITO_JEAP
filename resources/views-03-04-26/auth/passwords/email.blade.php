@extends('layouts.app')

@section('content')
    <style>
        /* Base styles from login page */
        .input-box {
            position: relative;
        }

        .input-box input {
            background: #F6F6F6;
            height: 50px;
            border-radius: 12px;
            border: 1px solid #E5E5E5;
            font-size: 16px;
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
            .input-box input {
                height: 48px;
                font-size: 15px;
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

            .mobile-forgot-container {
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
                font-size: 15px;
                color: #666;
                margin-bottom: 2rem;
                text-align: center;
            }

            .mobile-info-section {
                padding: 1.5rem;
                background: #f8f9fa;
                margin-top: auto;
            }

            .form-label {
                font-size: 15px;
                font-weight: 500;
                color: #4C4C4C;
                margin-bottom: 0.5rem;
            }

            .btn-send {
                background-color: #3E2B87;
                border: none;
                color: white;
                padding: 12px;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 500;
                width: 100%;
                margin-top: 1rem;
            }

            .back-link {
                text-align: center;
                margin-top: 1.5rem;
                font-size: 14px;
                color: #666;
            }

            .back-link a {
                color: #3E2B87;
                text-decoration: none;
                font-weight: 500;
            }
        }

        /* Show mobile elements only on mobile */
        @media (min-width: 992px) {
            .mobile-forgot-container {
                display: none !important;
            }
        }

        .info-icon {
            width: 5%;
        }

        .info-box {
            background: #f8f7ff;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #3E2B87;
            margin-bottom: 20px;
        }
    </style>

    <!-- Desktop View -->
    <div class="desktop-section">
        <div class="container-fluid" style="min-height:100vh; display:flex; align-items:center; justify-content:center; background-color:#fff;">
            <div class="row w-100 justify-content-center align-items-center mt-4">
                <!-- Left Section -->
                <div class="col-md-5 offset-md-1 mb-5 mb-md-0 text-start">
                    <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" class="mb-3" style="width:220px;">
                    <h4 class="fw-bold mb-3" style="font-size:25px;font-weight:500;color:#4C4C4C;">Forgot Your Password?
                    </h4>
                    <p class="text-muted mb-4" style="font-size:19px;font-weight:500; text-align:justify;">
                        No worries! Enter your email address and we'll send you an OTP to reset your password and get you back to your application.
                    </p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2" style="font-size:19px;font-weight:500;">
                            <img src="{{ asset('user/blueicon.png') }}" alt="" class="info-icon">
                            Enter your registered email address
                        </li>
                        <li class="mb-2" style="font-size:19px;font-weight:500;">
                            <img src="{{ asset('user/blueicon.png') }}" alt="" class="info-icon">
                            Check your email for the OTP
                        </li>
                        <li class="mb-2" style="font-size:19px;font-weight:500;">
                            <img src="{{ asset('user/blueicon.png') }}" alt="" class="info-icon">
                            Verify OTP and create new password
                        </li>
                    </ul>
                </div>

                <!-- Right Section (Forgot Password Card) -->
                <div class="col-md-5">
                    <div class="card shadow-md border-0 p-4 rounded-4"
                        style="max-width:90%; margin:auto; background: transparent !important; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        <div class="card-body">
                            <h4 class="fw-semibold mb-1 text-start" style="font-size:28px; font-weight:500;color:#4C4C4C;">
                                Reset Password</h4>
                            <p class="text-muted text-start mb-4" style="font-size:19px;">Enter your email to receive an OTP</p>

                            <!-- Success Message -->
                            @if (session('status'))
                                <div class="alert alert-success mb-4" style="border-radius: 10px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.sendotp') }}">
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
                                            value="{{ old('email') }}" placeholder="your.email@example.com" required autocomplete="off">
                                    </div>

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Info Box -->
                                <div class="info-box">
                                    <p style="font-size: 14px; color: #6C6C6C; margin: 0;">
                                        <strong>Note:</strong> If you don't receive the email within a few minutes, check your spam folder or contact support.
                                    </p>
                                </div>

                                <!-- Submit -->
                                <div class="d-grid mt-2">
                                    <button type="submit" class="btn btn-primary fw-semibold"
                                        style="background-color:#3E2B87; border:none;font-size:17px;">Send OTP</button>
                                </div>
                                <hr class="" style="margin-top:25px;">

                                <!-- Back to Login -->
                                <p class="text-center mt-3 small text-muted" style="font-size:16px;">
                                    Remember your password? <a href="{{ route('login') }}"
                                        class="text-decoration-none fw-semibold" style="color:#3E2B87;">Log In</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="mobile-forgot-container d-lg-none">
        <div class="mobile-header">
            <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" class="mobile-logo">
        </div>

        <div class="mobile-form-container">
            <h3 class="mobile-form-title">Forgot Password</h3>
            <p class="mobile-form-subtitle">Enter your email to receive an OTP</p>

            <!-- Success Message -->
            @if (session('status'))
                <div class="alert alert-success mb-4" style="border-radius: 10px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.sendotp') }}">
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
                            value="{{ old('email') }}" placeholder="your.email@example.com" required autocomplete="off">
                    </div>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <p style="font-size: 13px; color: #6C6C6C; margin: 0;">
                        <strong>Note:</strong> If you don't receive the email within a few minutes, check your spam folder.
                    </p>
                </div>

                <button type="submit" class="btn-send">Send OTP</button>

                <p class="back-link">
                    Remember your password? <a href="{{ route('login') }}">Log In</a>
                </p>
            </form>
        </div>

        <div class="mobile-info-section">
            <h4 class="mobile-info-title" style="font-size:18px;font-weight:600;color:#4C4C4C;margin-bottom:1rem;">Educational Assistance Program</h4>
            <p class="mobile-info-text" style="font-size:15px;color:#666;line-height:1.6;">
                Empowering Jain students to achieve their educational dream through financial support and community guidance
            </p>
        </div>
    </div>
@endsection
