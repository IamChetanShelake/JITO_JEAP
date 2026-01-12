<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JITO JEAP Student Registration</title>

    {{-- <link rel="icon" href="{{ asset('jitojeaplogo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('jitojeaplogo.png') }}" type="image/png"> --}}
    <link rel="icon" href="{{ asset('jitojeaplogo.png') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
            color: #4C4C4C !important;
        }

        ::placeholder,
        select option,
        textarea::placeholder {
            color: #494C4E;
            font-weight: 300;
            font-size: 14px;
        }


        --webkit-scrollbar-thumb {
            border-radius: 9px;
        }

        .navbar {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
            /* height: 135px; */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 5px 20px;
        }

        /*
        .sidebar {
            background-color: #1e1b4b;
            color: white;
            min-height: 80vh;
            overflow-y: auto;
        }

        .sidebar-title {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: bold;
        } */


        .sidebar {
            background-color: #2E2A85 !important;
            color: white;
            position: fixed;
            top: 155px;
            left: 0;
            height: calc(100vh - 155px);
            overflow-y: scroll;
            padding: 25px 20px 25px 55px;
            border-radius: 8px;
            width: 22%;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
            background: #2E2A85;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #fed766;
            border-radius: 4px;
            min-height: 50px;
        }

        .main-content {
            margin-left: 22%;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 25px;
            font-family: 'Poppins', sans-serif;
        }

        /* Vertical Line */
        .stepper {
            list-style: none;
            padding-left: 0;
            margin: 0;
            position: relative;
        }

        .stepper::before {
            content: "";
            position: absolute;
            top: 10px;
            bottom: 0;
            left: 26px;
            width: 2.5px;
            background-color: #D9D9D9;
        }

        /* Step row */
        .stepper li {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 28px;
        }

        /* Outer Circle */
        .step-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            background-color: #2E2A85;
            z-index: 2;
        }

        /* Active Step */
        .stepper li.active .step-icon {
            background-color: #FFC727;
            border-color: #FFC727;
            color: #FFFF;
        }

        .stepper li.active .step-number {
            /* background-color: #FFC727;
            border-color: #FFC727; */
            color: #FFC727;
            font-weight: 400;
            font-family: 'Poppins', sans-serif;
        }

        /* Completed Step */
        .completed-step {
            background-color: green !important;
            border-color: green !important;
        }

        /* Resubmit Step */
        .resubmit-step {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .active-step {
            background-color: #FFC727 !important;
            border-color: #FFC727 !important;
        }

        /* Step text */
        .step-content {
            margin-left: 18px;
            line-height: 18px;
        }

        /* Ensure <a> tags in stepper don't interfere with layout */
        .stepper a {
            display: contents;
            text-decoration: none;
            color: inherit;
        }

        .step-number {
            font-size: 13px;
            opacity: 0.9;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            color: #FFFF;
        }

        .step-title {
            font-size: 15px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            color: #FFFF;
        }




        .stepper .active .step-icon {
            background-color: #fed766;
            /* Yellow for active */
            color: #1e1b4b;
        }

        .stepper .active .step-title {

            color: white;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }





        .form-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            padding: 15px;
            border: none;
        }

        @media (min-width: 992px) {
            .col-lg-9 {
                flex: 0 0 auto;
                width: 78%;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 250px;
                height: calc(100vh - 110px);
                /* Fixed width for off-canvas */
                z-index: 1050;
                padding: 20px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding-top: 110px;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .overlay.show {
                display: block;
            }
        }


        .step-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 0px 10px 20px;
        }

        .card-icon {
            width: 65px;
            height: 65px;
            background: #393185;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .card-title {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            color: #393185;
        }

        .card-subtitle {
            margin: 0;
            margin-top: 3px;
            color: #9b9b9b;
            font-size: 16px;
        }

        .form-control {
            height: 50px;
        }


        /* select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='%237A7A7A'%3E%3Cpath d='M7 10c-.4 0-.6.5-.3.8l5 5c.2.2.6.2.8 0l5-5c.3-.3.1-.8-.3-.8H7z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 25px 25px;

            padding-right: 35px;
            color: #4C4C4C;
        } */

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='%237A7A7A'%3E%3Cpath d='M7 10c-.4 0-.6.5-.3.8l5 5c.2.2.6.2.8 0l5-5c.3-.3.1-.8-.3-.8H7z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 22px;
            padding-right: 45px;
            color: #4C4C4C;
            border-radius: 7px;
            border: 1px solid #D7D7D7;
        }




        .photo-upload-box {
            width: 100%;
            height: 50px;
            border: 1px solid #d9d9d9;
            border-radius: 7px;
            padding: 3px 18px;
            /* display: flex;
            justify-content: space-between;
            align-items: center; */
            font-family: 'Poppins', sans-serif;
            color: #4C4C4C;
            background: white;
        }

        .photo-label {
            font-size: 15px;
        }

        .upload-btn {
            background: #f3f3f3;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #4C4C4C;
        }

        .upload-btn:hover {
            background: #e9e9e9;
        }

        .upload-icon {
            font-size: 18px;
        }

        /* Remove default focus border */
        #uploadInput:focus {
            outline: none;
        }

        .remove-upload {
            color: #F43333;
            border: 1px solid #F43333;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 91%;
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid mt-2 mb-2">
            <a class="navbar-brand d-flex flex-column align-items-start " href="#">
                <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" width="130px" height="auto">
                <span class="text-wrap text-start mt-1" style="color:#4C4C4C;font-size:18px;">Supporting Jain Students
                    Educational
                    Journey &nbsp;&nbsp;<b>
                        @if ($type == 'above')
                            <i class="bi bi-record-fill" style="font-size:10px; color:#3E3E3E;"></i>
                            Above ₹1.00 Lacs
                        @else
                            <i class="bi bi-record-fill" style="font-size:10px; color:#3E3E3E;"></i>
                            Below ₹1.00 Lacs
                        @endif
                    </b></span>
            </a>
            <div class="ms-auto d-flex align-items-center">
                {{-- <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 1 of
                    7</button> --}}
                @yield('step')
                <button class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><svg
                        width="20" height="20" viewBox="0 0 21 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.3877 6.68848C16.6416 6.68425 16.8592 6.80205 17.0352 6.99219L20.374 10.6035L20.375 10.6045C20.6223 10.8733 20.75 11.194 20.75 11.5557C20.75 11.9178 20.6215 12.239 20.373 12.5078L17.0352 16.1182C16.8692 16.2976 16.6604 16.401 16.418 16.4102C16.1907 16.4186 15.9919 16.3309 15.8262 16.1787L15.7549 16.1074C15.5836 15.9163 15.4876 15.6927 15.4912 15.4434C15.4948 15.1968 15.5927 14.9778 15.7646 14.793L17.8877 12.4961H7.77051C7.52029 12.4961 7.30152 12.4023 7.13184 12.2188C6.9633 12.0364 6.88294 11.8096 6.88184 11.5566C6.88074 11.3025 6.9616 11.0745 7.13184 10.8916C7.30212 10.7088 7.52048 10.6143 7.77051 10.6143H17.8877L15.7578 8.31055V8.30957C15.5965 8.13582 15.5103 7.9241 15.5 7.68555V7.58984C15.5122 7.37158 15.6023 7.17425 15.7549 7.00391L15.8203 6.93652C15.9784 6.78524 16.1683 6.69223 16.3877 6.68848ZM2.02734 20.3789C2.02734 20.5193 2.07959 20.6563 2.20703 20.7949C2.3344 20.9333 2.45094 20.98 2.56152 20.9795H10.1045C10.3549 20.9796 10.5734 21.0733 10.7432 21.2568C10.912 21.4395 10.9931 21.6667 10.9932 21.9199C10.9932 22.1732 10.912 22.4003 10.7432 22.583C10.5734 22.7666 10.3549 22.8612 10.1045 22.8613H2.56445C1.9077 22.8613 1.34969 22.62 0.908203 22.1426C0.467769 21.6661 0.250926 21.0714 0.25 20.3779V2.7334C0.25 2.04045 0.466813 1.44624 0.908203 0.969727C1.35027 0.492592 1.90765 0.25109 2.56348 0.25H10.1045C10.355 0.250114 10.5733 0.34459 10.7432 0.52832C10.912 0.710995 10.9932 0.938106 10.9932 1.19141C10.9931 1.44453 10.9119 1.67192 10.7432 1.85449C10.5734 2.03791 10.3548 2.13172 10.1045 2.13184H2.56445C2.45264 2.13184 2.33459 2.17911 2.20605 2.31738C2.07887 2.45428 2.02678 2.59051 2.02734 2.73242V20.3789Z"
                            fill="white" stroke="white" stroke-width="0.5" />
                    </svg>
                    &nbsp;Logout</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <button class="btn btn-dark d-md-none ms-2" onclick="toggleSidebar()">☰</button>
            </div>
        </div>
    </nav>


    <div class="container-fluid" style="margin-top:155px;">
        <div class="row">

            <div class="sidebar" id="sidebar">
                <h6 class="sidebar-title">&nbsp;&nbsp;Application Progress</h6>

                <ul class="stepper">

                    {{-- <li class="{{ request()->routeIs('user.step1') ? 'active' : '' }}">
                        <a href="{{ route('user.step1') }}">
                            <div class="step-icon @if (auth()->check() && auth()->user()->submit_status === 'submited') completed-step @endif">
                                @if (auth()->check() && auth()->user()->submit_status === 'submited')
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @else
                                    <i class="bi bi-person"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 1</div>
                                <div class="step-title">Personal Details</div>
                            </div>
                        </a>
                    </li> --}}
                    <li class="{{ request()->routeIs('user.step1') ? 'active' : '' }}">
                        <a href="{{ route('user.step1') }}">
                            <div
                                class="step-icon
                                @if (auth()->check() && in_array(auth()->user()->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
                                @if (auth()->check() && auth()->user()->submit_status === 'resubmit') resubmit-step @endif
                                @if (request()->routeIs('user.step1')) active-step @endif">

                                @if (auth()->check() && in_array(auth()->user()->submit_status, ['submited', 'submitted', 'approved']))
                                    {{-- Tick SVG --}}
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif (auth()->check() && auth()->user()->submit_status === 'resubmit')
                                    {{-- Cross Icon --}}
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ auth()->user()->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    {{-- Default Icon --}}
                                    <i class="bi bi-person"></i>
                                @endif

                            </div>

                            <div class="step-content">
                                <div class="step-number">Step 1</div>
                                <div class="step-title">Personal Details</div>
                            </div>
                        </a>
                    </li>


                    @php
                        $educationDetail = \App\Models\EducationDetail::where('user_id', auth()->id())->first();
                        $family = \App\Models\FamilyDetail::where('user_id', auth()->id())->first();
                        $fundingDetail = \App\Models\FundingDetail::where('user_id', auth()->id())->first();
                        $guarantorDetail = \App\Models\GuarantorDetail::where('user_id', auth()->id())->first();
                        $document = \App\Models\Document::where('user_id', auth()->id())->first();
                        $reviewSubmit = \App\Models\ReviewSubmit::where('user_id', auth()->id())->first();
                    @endphp
                    {{--
                    <li class="{{ request()->routeIs('user.step2') ? 'active' : '' }}">
                        <a href="{{ route('user.step2') }}">

                            <div class="step-icon @if ($family && $family->submit_status === 'submited') completed-step @endif">

                                @if ($family && $family->submit_status === 'submited')
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @else
                                    <i class="bi bi-people"></i>
                                @endif

                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 2</div>
                                <div class="step-title">Family Details</div>
                            </div>
                        </a>
                    </li> --}}

                    {{-- <li class="{{ request()->routeIs('user.step2') ? 'active' : '' }}">
                        <a href="{{ route('user.step2') }}">
                            <div class="step-icon
                                @if ($family && $family->submit_status === 'submited') completed-step @endif">

                                @if ($family && $family->submit_status === 'submited')
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @else
                                    <i class="bi bi-people"></i>
                                @endif
                            </div>

                            <div class="step-content">
                                <div class="step-number">Step 2</div>
                                <div class="step-title">Family Details</div>
                            </div>

                        </a>
                    </li> --}}

                    <li class="{{ request()->routeIs('user.step2') ? 'active' : '' }}">
                        <a href="{{ route('user.step2') }}">

                            <div
                                class="step-icon
                                    @if ($educationDetail && in_array($educationDetail->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
                                    @if ($educationDetail && $educationDetail->submit_status === 'resubmit') resubmit-step @endif
                                    @if (request()->routeIs('user.step2')) active-step @endif">

                                @if ($educationDetail && in_array($educationDetail->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif ($educationDetail && $educationDetail->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ $educationDetail->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    <i class="bi bi-people"></i>
                                @endif

                            </div>

                            <div class="step-content">
                                <div class="step-number">Step 2</div>
                                <div class="step-title">Education Details </div>
                            </div>

                        </a>
                    </li>





                    <li class="{{ request()->routeIs('user.step3') ? 'active' : '' }}">
                        <a href="{{ route('user.step3') }}">
                            <div
                                class="step-icon
@if ($family && in_array($family->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
@if ($family && $family->submit_status === 'resubmit') resubmit-step @endif
@if (request()->routeIs('user.step3')) active-step @endif">

                                @if ($family && in_array($family->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif ($family && $family->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ $family->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    <i class="bi bi-mortarboard"></i>
                                @endif

                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 3</div>
                                <div class="step-title">Family Details</div>
                            </div>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('user.step4') ? 'active' : '' }}">
                        <a href="{{ route('user.step4') }}">
                            <div
                                class="step-icon  @if ($fundingDetail && in_array($fundingDetail->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
                               @if ($fundingDetail && $fundingDetail->submit_status === 'resubmit') resubmit-step @endif
                               @if (request()->routeIs('user.step4')) active-step @endif">

                                @if ($fundingDetail && in_array($fundingDetail->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif ($fundingDetail && $fundingDetail->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ $fundingDetail->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    <i class="bi bi-currency-rupee"></i>
                                @endif

                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 4</div>
                                <div class="step-title">Funding Details</div>
                            </div>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('user.step5') ? 'active' : '' }}">
                        <a href="{{ route('user.step5') }}">
                            <div
                                class="step-icon
@if ($guarantorDetail && in_array($guarantorDetail->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
@if ($guarantorDetail && $guarantorDetail->submit_status === 'resubmit') resubmit-step @endif
@if (request()->routeIs('user.step5')) active-step @endif">

                                @if ($guarantorDetail && in_array($guarantorDetail->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif ($guarantorDetail && $guarantorDetail->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ $guarantorDetail->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    <i class="bi bi-check2-square"></i>
                                @endif

                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 5</div>
                                <div class="step-title">Guarantor Details</div>
                            </div>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('user.step6') ? 'active' : '' }}">
                        <a href="{{ route('user.step6') }}">
                            <div
                                class="step-icon
@if ($document && in_array($document->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
@if ($document && $document->submit_status === 'resubmit') resubmit-step @endif
@if (request()->routeIs('user.step6')) active-step @endif">

                                @if ($document && in_array($document->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif ($document && $document->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ $document->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    <i class="bi bi-journal-text"></i>
                                @endif

                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 6</div>
                                <div class="step-title">Documents Upload</div>
                            </div>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('user.step7') ? 'active' : '' }}">
                        <a href="{{ route('user.step7') }}">
                            <div
                                class="step-icon
@if ($reviewSubmit && in_array($reviewSubmit->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif
@if ($reviewSubmit && $reviewSubmit->submit_status === 'resubmit') resubmit-step @endif
@if (request()->routeIs('user.step7')) active-step @endif">

                                @if ($reviewSubmit && in_array($reviewSubmit->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z"
                                            fill="white" />
                                    </svg>
                                @elseif ($reviewSubmit && $reviewSubmit->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"
                                        title="{{ $reviewSubmit->admin_remark ?? 'On Hold' }}"></i>
                                @else
                                    <i class="bi bi-eye"></i>
                                @endif

                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 7</div>
                                <div class="step-title">Review & Submit</div>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>


            @yield('content')
            <!-- Main Content -->


            <!-- Overlay for Mobile -->
            <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Custom JS for Sidebar Toggle -->
            <script>
                function toggleSidebar() {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('overlay');
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('show');
                }
            </script>

            <!-- File Upload Functionality Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Function to handle file upload
                    function handleFileUpload(fileInput) {
                        console.log('File upload triggered for input:', fileInput.name);
                        const photoUploadBox = fileInput.closest('.photo-upload-box');
                        const uploadStatus = photoUploadBox.querySelector('.upload-status');
                        const uploadButton = photoUploadBox.querySelector('.upload-btn');
                        const uploadedButton = photoUploadBox.querySelector('.uploaded-btn');
                        console.log('Upload status element:', uploadStatus);
                        const uploadSummary = photoUploadBox.querySelector('.upload-summary');
                        const removeBtn = photoUploadBox.querySelector('.remove-upload');

                        if (fileInput.files.length > 0) {
                            const file = fileInput.files[0];
                            console.log('Selected file:', file);
                            const fileSizeKB = Math.round(file.size / 1024);
                            const fileSizeText = fileSizeKB > 1024 ? (fileSizeKB / 1024).toFixed(2) + ' MB' : fileSizeKB +
                                ' KB';

                            uploadSummary.innerHTML = `
                                <div class="text-success mb-1">✔ Document uploaded successfully</div>
                                <small class="text-muted">
                                    <strong>Name:</strong> ${file.name}<br>
                                    <strong>Size:</strong> ${fileSizeText}
                                </small>
                            `;

                            photoUploadBox.style.height = '143px';
                            uploadButton.style.display = 'none';
                            uploadedButton.style.display = 'block';
                            uploadedButton.style.color = '#009846';
                            uploadedButton.style.border = '1px solid #009846';
                            uploadedButton.style.display = 'flex';
                            uploadedButton.style.justifyContent = 'center';
                            uploadedButton.style.alignItems = 'center';
                            uploadedButton.style.fontSize = '91%';
                            uploadedButton.style.borderRadius = '10px';
                            uploadStatus.style.display = 'block';
                            removeBtn.style.display = 'inline-block';
                        } else {
                            photoUploadBox.style.height = '50px';
                            uploadStatus.style.display = 'none';
                            removeBtn.style.display = 'none';
                            uploadSummary.innerHTML = '';
                        }
                    }

                    // Function to remove upload
                    function removeUpload(fileInput) {
                        const photoUploadBox = fileInput.closest('.photo-upload-box');
                        const uploadStatus = photoUploadBox.querySelector('.upload-status');
                        const uploadSummary = photoUploadBox.querySelector('.upload-summary');
                        const uploadButton = photoUploadBox.querySelector('.upload-btn');
                        const uploadedButton = photoUploadBox.querySelector('.uploaded-btn');
                        const removeBtn = photoUploadBox.querySelector('.remove-upload');

                        fileInput.value = '';
                        photoUploadBox.style.height = '50px';
                        uploadStatus.style.display = 'none';
                        removeBtn.style.display = 'none';
                        uploadSummary.innerHTML = '';
                        uploadButton.style.display = 'block';
                        uploadedButton.style.display = 'none';
                    }

                    // Add event listeners to all file inputs
                    const fileInputs = document.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(function(input) {
                        input.addEventListener('change', function() {
                            // console.log(input);
                            handleFileUpload(this);
                        });

                        // Add remove button functionality
                        const photoUploadBox = input.closest('.photo-upload-box');
                        if (photoUploadBox) {
                            const removeBtn = photoUploadBox.querySelector('.remove-upload');
                            if (removeBtn) {
                                removeBtn.addEventListener('click', function() {
                                    removeUpload(input);
                                });
                            }
                        }
                    });
                });
            </script>
        </div>
</body>

</html>
