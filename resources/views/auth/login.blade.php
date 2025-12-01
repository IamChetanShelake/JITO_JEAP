{{--  @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
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
    </style>
    <div class="container-fluid"
        style="min-height:100vh; display:flex; align-items:center; justify-content:center; background-color:#fff;">
        <div class="row w-100 justify-content-center align-items-center mt-4">
            <!-- Left Section -->
            <div class="col-md-5 offset-md-1   mb-5 mb-md-0 text-start">
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

                        <h4 class="fw-semibold mb-1 text-start " style="font-size:28px; font-weight:500;color:#4C4C4C;">
                            Welcome back</h4>
                        <p class="text-muted text-start mb-4" style="font-size:19px;; ">Log in to continue your application
                        </p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            {{--  <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold"
                                    style="font-size:18px;color:#4C4C4C; ">Email
                                    Address</label>
                                <div class="input-group" style="height:40px !important;">
                                    <span class="input-group-text bg-light"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" fill="currentColor" class="bi bi-envelope"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                        </svg></span>
                                    <input id="email" type="email"
                                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="your.email@example.com"
                                        required autocomplete="email" style="font-size:18px !important;background:#F6F6F6;">

                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold"
                                    style="font-size:18px;color:#4C4C4C; ">Password</label>
                                <div class="input-group" style="height:40px !important;">
                                    <span class="input-group-text bg-light"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="20" height="20" fill="currentColor" class="bi bi-lock"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                        </svg></span>
                                    <input id="password" type="password"
                                        class="form-control form-control-sm @error('password') is-invalid @enderror"
                                        name="password" placeholder="Enter your password" required
                                        autocomplete="current-password"
                                        style="font-size:18px !important;background:#F6F6F6;">
                                    <button type="button" id="togglePassword" class="input-group-text bg-light"
                                        title="Show or hide password" aria-label="Toggle password visibility"
                                        style="border:none; cursor:pointer;">
                                        <!-- Eye (show) icon by default -->
                                        <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z" />
                                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>  --}}


                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="font-size:18px; color:#4C4C4C;">
                                    Email Address
                                </label>

                                <div class="input-box">
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="#6E6E6E" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0
                                                    0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13
                                                    2.383-4.708 2.825L15 11.105zm-.034
                                                    6.876-5.64-3.471L8 9.583l-1.326-.795-5.64
                                                    3.47A1 1 0 0 0 2 13h12a1 1 0 0 0
                                                    .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                    </svg>

                                    <input id="email" type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="your.email@example.com" required autocomplete="off">
                                </div>

                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>



                            {{--  <div class="mb-3">
                                <label class="form-label fw-semibold" style="font-size:18px; color:#4C4C4C;">
                                    Password
                                </label>

                                <div class="input-box">
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="#6E6E6E" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0
                                            1 2 2.45v5a2.5 2.5 0 0 1-2.5
                                            2.5h-7A2.5 2.5 0 0 1 2
                                            13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4
                                            4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3
                                            8.5v5A1.5 1.5 0 0 0 4.5
                                            15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5
                                            1.5 0 0 0 11.5 7zM8 1a3 3 0 0
                                            0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                    </svg>

                                    <input id="password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" required autocomplete="off">
                                </div>

                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>  --}}


                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="font-size:18px; color:#4C4C4C;">
                                    Password
                                </label>

                                <div class="input-box">
                                    <!-- Lock Icon -->
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        fill="#6E6E6E" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0
                            1 2 2.45v5a2.5 2.5 0 0 1-2.5
                            2.5h-7A2.5 2.5 0 0 1 2
                            13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4
                            4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3
                            8.5v5A1.5 1.5 0 0 0 4.5
                            15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5
                            1.5 0 0 0 11.5 7zM8 1a3 3 0 0
                            0-3 3v2h6V4a3 3 0 0 0-3-3" />
                                    </svg>

                                    <!-- Password Input -->
                                    <input id="password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" required autocomplete="off">

                                    <!-- 👁 Eye Toggle Button -->
                                    <span id="togglePassword"
                                        style="
            position:absolute;
            top:50%;
            right:15px;
            transform:translateY(-50%);
            cursor:pointer;
            color:#6E6E6E;">
                                        <!-- default eye icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8
                                5.5S16 8 16 8zM1.173 8a13.133
                                13.133 0 0 1 1.66-2.043C4.12
                                4.668 5.88 3.5 8 3.5c2.12 0
                                3.879 1.168 5.168 2.457A13.133
                                13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133
                                13.133 0 0 1-1.66 2.043C11.879
                                11.332 10.12 12.5 8
                                12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133
                                13.133 0 0 1 1.172 8z" />
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
                                    style="font-size:18px;">&nbsp;&nbsp;Remember
                                    me</label>
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
                                Don’t have an account? <a href="{{ route('register') }}"
                                    class="text-decoration-none fw-semibold" style="color:#3E2B87;">Create Account</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>
    </div>
    {{--  <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('togglePassword');
            var password = document.getElementById('password');
            if (!toggle || !password) return;

            var eyeIcon = {
                open: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">\n                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>\n                                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>\n                                        </svg>',
                closed: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">\n                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>\n                                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>\n                                        </svg>'
            };

            toggle.addEventListener('click', function() {
                var type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // swap icon: show eye-slash when visible (text), eye when hidden (password)
                this.innerHTML = (type === 'text') ? eyeIcon.closed : eyeIcon.open;
            });
        });
    </script>  --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('togglePassword');
            var password = document.getElementById('password');
            if (!toggle || !password) return;

            var eyeIcon = {
                open: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 
                5.5 8 5.5S16 8 16 8zM1.173 
                8a13.133 13.133 0 0 1 1.66-2.043C4.12 
                4.668 5.88 3.5 8 3.5c2.12 
                0 3.879 1.168 5.168 2.457A13.133 
                13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 
                13.133 0 0 1-1.66 2.043C11.879 
                11.332 10.12 12.5 8 
                12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 
                13.133 0 0 1 1.172 8z"/>
                <path d="M8 5a3 3 0 1 0 0 
                6 3 3 0 0 0 0-6z"/></svg>`,

                closed: `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 
                5.5 8 5.5S16 8 16 8zM1.173 
                8a13.133 13.133 0 0 1 1.66-2.043C4.12 
                4.668 5.88 3.5 8 3.5c2.12 
                0 3.879 1.168 5.168 2.457A13.133 
                13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.29a13.133 
                13.133 0 0 1-1.66 2.043C11.879 
                11.332 10.12 12.5 8 
                12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 
                13.133 0 0 1 1.172 8z"/>
                <path d="M8 5a3 3 0 1 0 0 
                6 3 3 0 0 0 0-6z"/></svg>`
            };

            toggle.addEventListener('click', function() {
                var type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = (type === 'text') ? eyeIcon.closed : eyeIcon.open;
            });
        });
    </script>
@endsection
