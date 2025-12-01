{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif



                        {{ __('User are logged in!') }}


                       
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}


@extends('layouts.app')

@section('content')
    <style>
        .container {
            max-width: 95%;
            /* background: #FFFFFF; */
        }

        .category-card {
            border-radius: 12px;
            padding: 25px;
            /* background: #FFFFFF; */
            border: 1px solid #E0E0E0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: .3s ease-in-out;
        }

        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .category-title {
            font-size: 20px;
            font-weight: 600;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .feature-item i {
            font-size: 18px;
            margin-right: 8px;
            color: #198754;
        }


        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: #F0F0F0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            border: 1px solid #E0E0E0;
            transition: .3s ease-in-out;
        }

        .icon-wrapper svg path {
            transition: .3s ease-in-out;
        }

        /* Hover Effect */
        .icon-wrapper:hover {
            background: #988DFF1F;
            /* Light Purple Transparent */
        }

        .icon-wrapper:hover svg path {
            stroke: #393185;
            /* Dark Purple stroke color */
        }


        .feature-box {
            background: #F3F3F3;
            border-radius: 18px;
            border: 1px solid #E0E0E0;
            padding: 18px 28px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
            /* width: fit-content; */
        }

        .feature-text {
            display: flex;
            flex-direction: column;
        }

        .feature-title {
            font-size: 16px;
            font-weight: 600;
            color: #4A4A4A;
        }

        .feature-sub {
            font-size: 14px;
            color: #6C6C6C;
        }

        .text-start {
            width: 100%;
            display: block;
        }




        /* Main purple color */
        :root {
            --primary-color: #393185;
            --light-purple-bg: #988DFF1F;
        }

        /* On hover – change card border + shadow */
        .category-card:hover {
            border-color: var(--primary-color) !important;
            box-shadow: 0 4px 18px rgba(57, 49, 133, 0.30);
        }

        /* Icon wrapper hover */
        .category-card:hover .icon-wrapper {
            background: var(--light-purple-bg) !important;
            border-color: var(--primary-color) !important;
        }

        /* SVG color change */
        .category-card:hover .icon-wrapper svg path {
            stroke: #393185;
        }

        /* Title color change */
        .category-card:hover .category-title {
            color: var(--primary-color) !important;
        }

        /* Feature box border + icon color */
        .category-card:hover .feature-box {
            border-color: var(--primary-color) !important;
        }

        /* Feature title color */
        .category-card:hover .feature-box .feature-title {
            color: var(--primary-color) !important;
        }

        /* Feature SVG icon color */
        .category-card:hover .feature-box svg path {
            stroke: #393185;
        }

        /* Button background on hover */
        .category-card:hover a {
            background: var(--primary-color) !important;
            color: #ffffff !important;
            border-color: var(--primary-color) !important;
        }
    </style>

    <div class="container py-4">

        <div class="text-center mb-4">
            <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" class="mb-3" style="width:160px;">
            {{-- <hr style="color:#CDCDCD;border:0.75px;"> --}}
            <hr style="border: 2px solid #CDCDCD;">

            <h3 class="mt-3" style="color:#4C4C4C;font-size:20px;font-family:'Poppins'; font-weight:500;">Choose Your
                Assistance Category</h3>
            <p style="color:#4C4C4C;font-family:'Poppins';">Select the category that matches your total financial assistance
                requirement. This
                helps<br> us streamline your application process and ensure faster processing.</p>
        </div>

        <div class="row g-4">

            <!-- Left Box - Below 1 Lac -->
            <div class="col-md-5 offset-md-1">
                <div class="category-card h-100">


                    <div class="text-center mb-3">
                        <div class="icon-wrapper">
                            <svg width="41" height="51" viewBox="0 0 41 51" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.7144 23.8357C17.9499 21.7858 13.8069 18.2013 1.92871 18.2013V43.8675C13.8069 43.8675 17.9499 47.4521 20.7144 49.502M20.7144 23.8357V49.502M20.7144 23.8357C23.4788 21.7858 27.6218 18.2013 39.5 18.2013V43.8675C27.6218 43.8675 23.4788 47.4521 20.7144 49.502M28.0542 1.70213V10.7172M34.6216 1.50196H9.94485C9.25542 1.50111 8.5795 1.69371 7.99348 2.05798L1.5 6.11328L7.99348 10.1612C8.5795 10.5254 9.25542 10.718 9.94485 10.7172H34.6216C35.2356 10.7347 35.8468 10.6285 36.4192 10.4048C36.9915 10.1812 37.5134 9.84479 37.9538 9.41538C38.3943 8.98597 38.7444 8.47232 38.9834 7.90482C39.2225 7.33733 39.3457 6.7275 39.3457 6.11142C39.3457 5.49534 39.2225 4.88552 38.9834 4.31802C38.7444 3.75053 38.3943 3.23688 37.9538 2.80747C37.5134 2.37806 36.9915 2.0416 36.4192 1.818C35.8468 1.5944 35.2356 1.48448 34.6216 1.50196Z"
                                    stroke="#696969" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>


                    <h4 class="category-title text-center">Below ₹1,00,000</h4>
                    <p class="text-center text-muted">For students requiring assistance up to ₹1,00,000</p>


                    <div class="mt-3">

                        <div class="feature-box">
                            <svg width="35" height="35" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.5 0C15.8152 0 18.9946 1.31696 21.3388 3.66116C23.683 6.00537 25 9.18479 25 12.5C25 15.8152 23.683 18.9946 21.3388 21.3388C18.9946 23.683 15.8152 25 12.5 25C9.18479 25 6.00537 23.683 3.66116 21.3388C1.31696 18.9946 0 15.8152 0 12.5C0 9.18479 1.31696 6.00537 3.66116 3.66116C6.00537 1.31696 9.18479 0 12.5 0ZM12.5 1.31579C9.53376 1.31579 6.68902 2.49412 4.59157 4.59157C2.49412 6.68902 1.31579 9.53376 1.31579 12.5C1.31579 15.4662 2.49412 18.311 4.59157 20.4084C6.68902 22.5059 9.53376 23.6842 12.5 23.6842C13.9687 23.6842 15.4231 23.3949 16.78 22.8329C18.1369 22.2708 19.3699 21.447 20.4084 20.4084C21.447 19.3699 22.2708 18.1369 22.8329 16.78C23.3949 15.4231 23.6842 13.9687 23.6842 12.5C23.6842 9.53376 22.5059 6.68902 20.4084 4.59157C18.311 2.49412 15.4662 1.31579 12.5 1.31579ZM11.8421 5.26316H13.1579V12.3947L19.3421 15.9605L18.6842 17.1053L11.8421 13.1579V5.26316Z"
                                    fill="#6C6C6C" />
                            </svg>

                            <div class="feature-text">
                                <div class="feature-title">Quick Processing</div>
                                <div class="feature-sub">4–5 business days</div>
                            </div>
                        </div>
                        <div class="feature-box">
                            <svg width="35" height="35" viewBox="0 0 23 26" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 2.5H2.5C2.03587 2.5 1.59075 2.68437 1.26256 3.01256C0.934375 3.34075 0.75 3.78587 0.75 4.25V23.5C0.75 23.9641 0.934375 24.4092 1.26256 24.7374C1.59075 25.0656 2.03587 25.25 2.5 25.25H20C20.4641 25.25 20.9092 25.0656 21.2374 24.7374C21.5656 24.4092 21.75 23.9641 21.75 23.5V4.25C21.75 3.78587 21.5656 3.34075 21.2374 3.01256C20.9092 2.68437 20.4641 2.5 20 2.5H16.5"
                                    stroke="#626262" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M9.5 9.5H18.25M9.5 14.75H18.25M9.5 20H18.25M4.25 9.5H6M4.25 14.75H6M4.25 20H6M7.75 0.75H14.75C15.2141 0.75 15.6592 0.934374 15.9874 1.26256C16.3156 1.59075 16.5 2.03587 16.5 2.5C16.5 2.96413 16.3156 3.40925 15.9874 3.73744C15.6592 4.06563 15.2141 4.25 14.75 4.25H7.75C7.28587 4.25 6.84075 4.06563 6.51256 3.73744C6.18437 3.40925 6 2.96413 6 2.5C6 2.03587 6.18437 1.59075 6.51256 1.26256C6.84075 0.934374 7.28587 0.75 7.75 0.75Z"
                                    stroke="#626262" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>


                            <div class="feature-text">
                                <div class="feature-title">Simplified Documentation</div>
                                <div class="feature-sub">Basic documents required</div>
                            </div>
                        </div>

                        <div class="feature-box">
                            <svg width="35" height="35" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.5 25C5.59625 25 0 19.4037 0 12.5C0 5.59625 5.59625 0 12.5 0C19.4037 0 25 5.59625 25 12.5C25 19.4037 19.4037 25 12.5 25ZM12.5 23.5C15.4174 23.5 18.2153 22.3411 20.2782 20.2782C22.3411 18.2153 23.5 15.4174 23.5 12.5C23.5 9.58262 22.3411 6.78473 20.2782 4.72183C18.2153 2.65892 15.4174 1.5 12.5 1.5C9.58262 1.5 6.78473 2.65892 4.72183 4.72183C2.65892 6.78473 1.5 9.58262 1.5 12.5C1.5 15.4174 2.65892 18.2153 4.72183 20.2782C6.78473 22.3411 9.58262 23.5 12.5 23.5ZM11.035 15.6975L18.2962 8.4375L19.3563 9.49875L11.9187 16.9362C11.6843 17.1706 11.3665 17.3022 11.035 17.3022C10.7035 17.3022 10.3857 17.1706 10.1513 16.9362L6.25 13.0325L7.31125 11.9712L11.0363 15.6962L11.035 15.6975Z"
                                    fill="#6C6C6C" />
                            </svg>

                            <div class="feature-text">
                                <div class="feature-title">Standard process</div>
                                <div class="feature-sub">5 step application form</div>
                            </div>
                        </div>


                    </div>

                    <h6 class="mt-3 " style="font-weight:600;">&nbsp;&nbsp;Ideal for:</h6>
                    <ul>
                        <li>School/College tuition</li>
                        <li>Books and study materials</li>
                        <li>Short-term courses</li>
                        <li>Examination fees</li>
                    </ul>

                    <div class="text-center mt-3">
                        <a href="{{ route('user.loanapply', ['type' => 'below']) }}" class="btn  w-100 py-2"
                            style="background: #F0F0F0;border:1px solid #E9E9E9;color:color:#4E4E4E;">
                            Select This Category
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Box - Above 1 Lac -->
            <div class="col-md-5">
                <div class="category-card h-100">

                    <div class="text-center mb-3">
                        <div class="icon-wrapper">
                            <svg width="52" height="42" viewBox="0 0 52 42" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M1.86351 9.98338C1.30631 10.2443 0.8352 10.6576 0.505214 11.1752C0.175229 11.6927 0 12.293 0 12.906C0 13.519 0.175229 14.1194 0.505214 14.6369C0.8352 15.1544 1.30631 15.5678 1.86351 15.8287L6.50758 18.011V30.6844C6.50758 33.0833 7.29026 35.7603 9.57332 37.4091C12.4507 39.4782 17.6923 42 26.0062 42C34.32 42 39.5487 39.4621 42.4391 37.4091C44.7221 35.7667 45.5048 33.1092 45.5048 30.6844V18.011L48.7524 16.4818V30.6747C48.7524 31.1034 48.9235 31.5146 49.228 31.8178C49.5325 32.1209 49.9455 32.2912 50.3762 32.2912C50.8069 32.2912 51.2199 32.1209 51.5244 31.8178C51.8289 31.5146 52 31.1034 52 30.6747V12.8931C52.0001 12.2808 51.8256 11.6811 51.4968 11.1637C51.1679 10.6463 50.6982 10.2325 50.1424 9.97044L31.5661 1.24128C29.8299 0.423935 27.9332 0 26.0127 0C24.0921 0 22.1955 0.423935 20.4593 1.24128L1.883 9.97044L1.86351 9.98338ZM9.75519 30.6747V19.5208L20.4398 24.5643C22.176 25.3817 24.0727 25.8056 25.9932 25.8056C27.9137 25.8056 29.8104 25.3817 31.5466 24.5643L42.2312 19.5208V30.6747C42.2312 32.4723 41.6466 33.9401 40.51 34.7483C38.1587 36.4392 33.5926 38.7573 25.9932 38.7573C18.3938 38.7573 13.8147 36.4554 11.4764 34.7483C10.343 33.9336 9.75519 32.4561 9.75519 30.6747ZM21.8363 4.16393C23.1356 3.5512 24.5554 3.23336 25.9932 3.23336C27.431 3.23336 28.8508 3.5512 30.1501 4.16393L48.7264 12.8931L30.1501 21.6223C28.8508 22.235 27.431 22.5528 25.9932 22.5528C24.5554 22.5528 23.1356 22.235 21.8363 21.6223L3.25998 12.8931L21.8363 4.16393Z"
                                    fill="#696969" />
                            </svg>


                        </div>
                    </div>

                    <h4 class="category-title text-center">Above ₹1,00,000</h4>
                    <p class="text-center text-muted">For students requiring assistance above ₹1,00,000</p>
                    <div class="mt-3">
                        <div class="feature-box">
                            <svg width="35" height="35" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.5 0C15.8152 0 18.9946 1.31696 21.3388 3.66116C23.683 6.00537 25 9.18479 25 12.5C25 15.8152 23.683 18.9946 21.3388 21.3388C18.9946 23.683 15.8152 25 12.5 25C9.18479 25 6.00537 23.683 3.66116 21.3388C1.31696 18.9946 0 15.8152 0 12.5C0 9.18479 1.31696 6.00537 3.66116 3.66116C6.00537 1.31696 9.18479 0 12.5 0ZM12.5 1.31579C9.53376 1.31579 6.68902 2.49412 4.59157 4.59157C2.49412 6.68902 1.31579 9.53376 1.31579 12.5C1.31579 15.4662 2.49412 18.311 4.59157 20.4084C6.68902 22.5059 9.53376 23.6842 12.5 23.6842C13.9687 23.6842 15.4231 23.3949 16.78 22.8329C18.1369 22.2708 19.3699 21.447 20.4084 20.4084C21.447 19.3699 22.2708 18.1369 22.8329 16.78C23.3949 15.4231 23.6842 13.9687 23.6842 12.5C23.6842 9.53376 22.5059 6.68902 20.4084 4.59157C18.311 2.49412 15.4662 1.31579 12.5 1.31579ZM11.8421 5.26316H13.1579V12.3947L19.3421 15.9605L18.6842 17.1053L11.8421 13.1579V5.26316Z"
                                    fill="#6C6C6C" />
                            </svg>
                            <div class="feature-text">
                                <div class="feature-title">Detailed Review</div>
                                <div class="feature-sub">6-7 business days</div>
                            </div>
                        </div>
                        <div class="feature-box">
                            <svg width="35" height="35" viewBox="0 0 23 26" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 2.5H2.5C2.03587 2.5 1.59075 2.68437 1.26256 3.01256C0.934375 3.34075 0.75 3.78587 0.75 4.25V23.5C0.75 23.9641 0.934375 24.4092 1.26256 24.7374C1.59075 25.0656 2.03587 25.25 2.5 25.25H20C20.4641 25.25 20.9092 25.0656 21.2374 24.7374C21.5656 24.4092 21.75 23.9641 21.75 23.5V4.25C21.75 3.78587 21.5656 3.34075 21.2374 3.01256C20.9092 2.68437 20.4641 2.5 20 2.5H16.5"
                                    stroke="#626262" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M9.5 9.5H18.25M9.5 14.75H18.25M9.5 20H18.25M4.25 9.5H6M4.25 14.75H6M4.25 20H6M7.75 0.75H14.75C15.2141 0.75 15.6592 0.934374 15.9874 1.26256C16.3156 1.59075 16.5 2.03587 16.5 2.5C16.5 2.96413 16.3156 3.40925 15.9874 3.73744C15.6592 4.06563 15.2141 4.25 14.75 4.25H7.75C7.28587 4.25 6.84075 4.06563 6.51256 3.73744C6.18437 3.40925 6 2.96413 6 2.5C6 2.03587 6.18437 1.59075 6.51256 1.26256C6.84075 0.934374 7.28587 0.75 7.75 0.75Z"
                                    stroke="#626262" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>

                            <div class="feature-text">
                                <div class="feature-title">Comprehensive Documentation</div>
                                <div class="feature-sub">Basic documents required</div>
                            </div>
                        </div>
                        <div class="feature-box">
                            <svg width="35" height="35" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.5 25C5.59625 25 0 19.4037 0 12.5C0 5.59625 5.59625 0 12.5 0C19.4037 0 25 5.59625 25 12.5C25 19.4037 19.4037 25 12.5 25ZM12.5 23.5C15.4174 23.5 18.2153 22.3411 20.2782 20.2782C22.3411 18.2153 23.5 15.4174 23.5 12.5C23.5 9.58262 22.3411 6.78473 20.2782 4.72183C18.2153 2.65892 15.4174 1.5 12.5 1.5C9.58262 1.5 6.78473 2.65892 4.72183 4.72183C2.65892 6.78473 1.5 9.58262 1.5 12.5C1.5 15.4174 2.65892 18.2153 4.72183 20.2782C6.78473 22.3411 9.58262 23.5 12.5 23.5ZM11.035 15.6975L18.2962 8.4375L19.3563 9.49875L11.9187 16.9362C11.6843 17.1706 11.3665 17.3022 11.035 17.3022C10.7035 17.3022 10.3857 17.1706 10.1513 16.9362L6.25 13.0325L7.31125 11.9712L11.0363 15.6962L11.035 15.6975Z"
                                    fill="#6C6C6C" />
                            </svg>

                            <div class="feature-text">
                                <div class="feature-title">Enhanced Process</div>
                                <div class="feature-sub">7 step application form</div>
                            </div>
                        </div>



                        {{-- <div class="feature-item"><i class="bi bi-check2-circle"></i>Comprehensive Documentation</div> --}}
                        {{-- <div class="feature-item"><i class="bi bi-check2-circle"></i>7 Step Enhanced Process</div> --}}
                    </div>

                    <h6 class="mt-3 " style="font-weight:600;">&nbsp;&nbsp;Ideal for:</h6>
                    <ul>
                        <li>Professional degree programs</li>
                        <li>Higher education</li>
                        <li>Multi-year education plans</li>
                        <li>Specialized training programs</li>
                    </ul>

                    <div class="text-center mt-3">
                        <a href="{{ route('user.loanapply', ['type' => 'above']) }}" class="btn  w-100 py-2"
                            style="background: #F0F0F0;border:1px solid #E9E9E9;color:#4E4E4E;">
                            Select This Category
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
