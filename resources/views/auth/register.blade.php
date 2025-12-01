{{--  @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection  --}}



@extends('layouts.app')

@section('content')
    <style>
        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            width: 90%;
            border-radius: 20px;
            padding: 35px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* -------- SMALL DEVICE FIX -------- */
        @media (max-width: 767px) {
            .register-card {
                width: 100% !important;
                /* Full width */
                padding: 25px;

            }

            .register-card input {
                text-align: left;
                /* Inputs left aligned (looks better) */
            }

            .register-card .input-icon {
                left: 15px !important;
            }
        }

        .form-control {
            height: 46px;
            border-radius: 10px;
            background: #f8f8f8;
            border: none;
            font-size: 16px;
        }

        .form-control:focus {
            background: #fff;
            border: 1px solid #b5aef5;
            box-shadow: none;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.6;
        }

        .input-box {
            position: relative;
        }

        .btn-primary {
            background: #3c2ba8;
            border: none;
            height: 48px;
            font-size: 16px;
            border-radius: 10px;
        }

        .info-box {
            border: 1px solid #b9a7f5;
            border-radius: 12px;
            padding: 20px;
        }

        .poppins {
            font-family: 'Poppins', sans-serif;

        }
    </style>

    <div class="container register-wrapper">
        <div class="row w-100">

            <!-- LEFT SIDE -->
            <div class="col-md-6 d-flex flex-column justify-content-center">

                <!-- Logo -->
                <div class="mb-2">
                    <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO JEAP Logo" class="mb-3" style="width:220px;">

                </div>

                <h3 class="mb-2 poppins" style="font-size:25px;font-weight:500;color:#4C4C4C;">Join Our
                    Community</h3>
                <p class="text-muted " style="font-size:18px;">
                    Create your account to start your educational assistance application journey.
                    We're here to support your educational aspirations.
                </p>

                <div class="info-box mt-3" style="border-color:#393185;background:#988DFF1F;">
                    <h6 class=" " style="font-size:19px;font-weight:400;color:#393185;">What happens after
                        creating an
                        account?</h6>
                    <ol class="mt-2 text-muted">
                        <li style="font-size:16px;color:#6C6C6C;padding:2px 0;">Complete the 7 step application form</li>
                        <li style="font-size:16px;color:#6C6C6C;padding:2px 0;">Upload required documents</li>
                        <li style="font-size:16px;color:#6C6C6C;padding:2px 0;">Submit for review</li>
                        <li style="font-size:16px;color:#6C6C6C;padding:2px 0;">Get response within 4–5 business days</li>
                    </ol>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="mt-4 mb-4 col-md-6 d-flex justify-content-end">
                <div class="register-card">

                    <h4 class=" mb-1" style="color:#4C4C4C;font-size:24px;font-weight:500;">Create Account</h4>
                    <p class="text-muted mb-4" style="font-size:18px;">Start your application process today</p>

                    <form method="POST" action="{{ route('register') }}" autocomplete="off">
                        @csrf

                        <!-- NAME -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#4C4C4C;">Name</label>
                            <div class="input-box">
                                {{--  <i class="fas fa-person input-icon"></i>  --}}
                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                </svg>
                                <input id="name" type="text"
                                    class="form-control ps-5 @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#4C4C4C;">Email Address</label>
                            <div class="input-box">
                                {{--  <i class="bi bi-envelope input-icon"></i>  --}}
                                <svg class=" input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                                <input id="email" type="email"
                                    class="form-control ps-5 @error('email') is-invalid @enderror" name="email"
                                    value="" placeholder="your.email@example.com" autocomplete="off" required>
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- PHONE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#4C4C4C;">Phone Number</label>
                            <div class="input-box">
                                {{--  <i class="bi bi-telephone input-icon"></i>  --}}
                                <svg class=" input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                </svg>
                                <input type="text" class="form-control ps-5" name="phone"
                                    placeholder="Enter your phone number" required>
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#4C4C4C;">Password</label>
                            <div class="input-box">
                                {{--  <i class="bi bi-lock input-icon"></i>  --}}
                                <svg class=" input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                </svg>
                                <input id="password" type="password"
                                    class="form-control ps-5 @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password" placeholder="Enter your password" required>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#4C4C4C;">Confirm Password</label>
                            <div class="input-box">
                                {{--  <i class="bi bi-lock input-icon"></i>  --}}
                                <svg class=" input-icon" xmlns="http://www.w3.org/2000/svg" width="20"
                                    height="20" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                </svg>
                                <input id="password-confirm" type="password" class="form-control ps-5"
                                    placeholder="Enter your password" name="password_confirmation" required>
                            </div>
                        </div>

                        <!-- TERMS -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" style="width: 1.5em;height: 1.5em;" required>
                            <label class="form-check-label" style="font-size:16px;">
                                &nbsp;&nbsp;I agree to the <a href="#" style="color:#393185;">Terms & Condition</a>
                                and
                                <a href="#" style="color:#393185;">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" style="font-size:16px;">Create
                            account</button>

                        <p class="text-center mt-3" style="font-size:16px;margin-bottom:0px;">
                            Already have an account?
                            <a href="{{ route('login') }}" style="color:#393185;">Log In</a>
                        </p>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
