<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JITO JEAP Student Registration</title>

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

        ::placeholder, select option, textarea::placeholder {
            color: #494C4E;
            font-weight: 300;
            font-size: 14px;
        }

        ::-webkit-scrollbar-thumb { border-radius: 9px; }

        .navbar {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 5px 20px;
        }

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

        .sidebar::-webkit-scrollbar { width: 6px; background: #2E2A85; }
        .sidebar::-webkit-scrollbar-thumb { background: #fed766; border-radius: 4px; min-height: 50px; }

        .main-content { margin-left: 22%; }

        .sidebar-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 25px;
            font-family: 'Poppins', sans-serif;
        }

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

        .stepper li {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 28px;
        }

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

        .completed-step { background-color: green !important; border-color: green !important; }
        .resubmit-step { background-color: #dc3545 !important; border-color: #dc3545 !important; }
        .active-step { background-color: #FFC727 !important; border-color: #FFC727 !important; }

        .stepper li.active .step-icon { background-color: #FFC727; border-color: #FFC727; color: #FFFF; }
        .stepper li.active .step-number { color: #FFC727; font-weight: 400; font-family: 'Poppins', sans-serif; }

        .step-content { margin-left: 18px; line-height: 18px; }
        .stepper a { display: contents; text-decoration: none; color: inherit; }

        .step-number { font-size: 13px; opacity: 0.9; font-family: 'Poppins', sans-serif; font-weight: 400; color: #FFFF; }
        .step-title { font-size: 15px; font-weight: 500; font-family: 'Poppins', sans-serif; color: #FFFF; }

        .form-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            padding: 15px;
            border: none;
        }

        @media (min-width: 992px) {
            .col-lg-9 { flex: 0 0 auto; width: 78%; }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed; top: 0px; transform: translateX(-100%); transition: transform 0.3s ease;
                width: 250px; height: calc(100vh - 110px); z-index: 1050; padding: 20px;
            }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding-top: 110px; }
            .overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1040; }
            .overlay.show { display: block; }
        }

        .form-control { height: 50px; }

        select.form-control {
            appearance: none; -webkit-appearance: none; -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='22' height='22' viewBox='0 0 24 24' fill='%237A7A7A'%3E%3Cpath d='M7 10c-.4 0-.6.5-.3.8l5 5c.2.2.6.2.8 0l5-5c.3-.3.1-.8-.3-.8H7z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 15px center; background-size: 22px;
            padding-right: 45px; color: #4C4C4C; border-radius: 7px; border: 1px solid #D7D7D7;
        }
        
        .custom-close { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); padding: 0; }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid mt-2 mb-2">
            <a class="navbar-brand d-flex flex-column align-items-start " href="#">
                <img src="{{ asset('jitojeaplogo.png') }}" alt="JITO Logo" width="130px" height="auto">
            </a>
            
            @php
                // Fetch all details correctly mapped to steps
                $personal = \App\Models\DonorPersonalDetail::where('donor_id', auth()->guard()->id())->first();
                $family = \App\Models\DonorFamilyDetail::where('donor_id', auth()->guard()->id())->first();
                $nominee = \App\Models\DonorNomineeDetail::where('donor_id', auth()->guard()->id())->first();
                
                // MAPPING:
                $professionalDetail = \App\Models\DonorProfessionalDetail::where('donor_id', auth()->guard()->id())->first(); // Step 4
                $document = \App\Models\DonorDocument::where('donor_id', auth()->guard()->id())->first(); // Step 5
                $membership = \App\Models\DonorMembershipDetail::where('donor_id', auth()->guard()->id())->first(); // Step 6
                $bankDetail = \App\Models\DonorPaymentDetail::where('donor_id', auth()->guard()->id())->first(); // Step 7
                
                $reviewSubmit = \App\Models\Donor::find(auth()->guard()->id());
            @endphp
            
            <div class="ms-auto d-flex align-items-center">
                @yield('step')
                <button class="btn btn-danger" href="{{ route('donor.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg width="20" height="20" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.3877 6.68848C16.6416 6.68425 16.8592 6.80205 17.0352 6.99219L20.374 10.6035L20.375 10.6045C20.6223 10.8733 20.75 11.194 20.75 11.5557C20.75 11.9178 20.6215 12.239 20.373 12.5078L17.0352 16.1182C16.8692 16.2976 16.6604 16.401 16.418 16.4102C16.1907 16.4186 15.9919 16.3309 15.8262 16.1787L15.7549 16.1074C15.5836 15.9163 15.4876 15.6927 15.4912 15.4434C15.4948 15.1968 15.5927 14.9778 15.7646 14.793L17.8877 12.4961H7.77051C7.52029 12.4961 7.30152 12.4023 7.13184 12.2188C6.9633 12.0364 6.88294 11.8096 6.88184 11.5566C6.88074 11.3025 6.9616 11.0745 7.13184 10.8916C7.30212 10.7088 7.52048 10.6143 7.77051 10.6143H17.8877L15.7578 8.31055H15.7568C15.5955 8.13692 15.5094 7.92514 15.5 7.68652V7.59082C15.5122 7.37256 15.6023 7.17523 15.7549 7.00488L15.8203 6.9375C15.9784 6.78622 16.1683 6.69321 16.3877 6.68945C16.6416 6.68523 16.8592 6.80302 17.0352 6.99316L20.374 10.6045L20.375 10.6055C20.6223 10.8743 20.75 11.195 20.75 11.5566C20.75 11.9187 20.6215 12.2399 20.373 12.5088L17.0352 16.1191C16.8692 16.2986 16.6604 16.4019 16.418 16.4111C16.1907 16.4196 15.9919 16.3318 15.8262 16.1797L15.7549 16.1084C15.5836 15.9173 15.4876 15.6937 15.4912 15.4443C15.4948 15.1978 15.5927 14.9787 15.7646 14.7939L17.8877 12.4971H7.77051C7.52029 12.4971 7.30152 12.4033 7.13184 12.2197C6.9633 12.0374 6.88294 11.8106 6.88184 11.5576C6.88074 11.3035 6.9616 11.0755 7.13184 10.8926C7.30212 10.7097 7.52048 10.6152 7.77051 10.6152H17.8877L15.7578 8.31152C15.5965 8.13787 15.5103 7.9261 15.5 7.6875V7.5918C15.5122 7.37354 15.6023 7.17621 15.7549 7.00586L15.8203 6.93848C15.9784 6.7872 16.1683 6.69418 16.3877 6.69043ZM2.02734 20.3809C2.02734 20.5212 2.07959 20.6583 2.20703 20.7969C2.3344 20.9353 2.45094 20.9819 2.56152 20.9814H10.1045C10.3549 20.9816 10.5734 21.0753 10.7432 21.2588C10.912 21.4415 10.9931 21.6687 10.9932 21.9219C10.9932 22.1751 10.912 22.4023 10.7432 22.585C10.5734 22.7685 10.3549 22.8631 10.1045 22.8633H2.56445C1.9077 22.8633 1.34969 22.622 0.908203 22.1445C0.467769 21.668 0.250926 21.0733 0.25 20.3799V2.73438C0.25 2.04142 0.466813 1.44721 0.908203 0.970703C1.35027 0.493567 1.90765 0.252065 2.56348 0.250977H10.1045C10.355 0.251091 10.5733 0.345566 10.7432 0.529297C10.912 0.711972 10.9932 0.939083 10.9932 1.19238C10.9931 1.44551 10.9119 1.6729 10.7432 1.85547C10.5734 2.03889 10.3548 2.13269 10.1045 2.13281H2.56445C2.45264 2.13281 2.33459 2.18009 2.20605 2.31836C2.07887 2.45526 2.02678 2.59148 2.02734 2.7334V20.3809Z" fill="white" stroke="white" stroke-width="0.5" />
                    </svg>
                    &nbsp;Logout
                </button>
                <form id="logout-form" action="{{ route('donor.logout') }}" method="POST" class="d-none">
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

                    <!-- Step 1: Personal -->
                    <li class="{{ request()->routeIs('donor.step1') ? 'active' : '' }}">
                        <a href="{{ route('donor.step1') }}">
                            <div class="step-icon @if ($personal && in_array($personal->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($personal && $personal->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step1')) active-step @endif">
                                @if ($personal && in_array($personal->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($personal && $personal->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-person"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 1</div>
                                <div class="step-title">Personal Details</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 2: Family -->
                    <li class="{{ request()->routeIs('donor.step2') ? 'active' : '' }}">
                        <a href="{{ route('donor.step2') }}">
                            <div class="step-icon @if ($family && in_array($family->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($family && $family->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step2')) active-step @endif">
                                @if ($family && in_array($family->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($family && $family->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-people"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 2</div>
                                <div class="step-title">Family Details</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 3: Nomination -->
                    <li class="{{ request()->routeIs('donor.step3') ? 'active' : '' }}">
                        <a href="{{ route('donor.step3') }}">
                            <div class="step-icon @if ($nominee && in_array($nominee->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($nominee && $nominee->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step3')) active-step @endif">
                                @if ($nominee && in_array($nominee->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($nominee && $nominee->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-mortarboard"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 3</div>
                                <div class="step-title">Nomination Details</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 4: Company Detail -->
                    <li class="{{ request()->routeIs('donor.step4') ? 'active' : '' }}">
                        <a href="{{ route('donor.step4') }}">
                            <div class="step-icon @if ($professionalDetail && in_array($professionalDetail->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($professionalDetail && $professionalDetail->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step4')) active-step @endif">
                                @if ($professionalDetail && in_array($professionalDetail->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($professionalDetail && $professionalDetail->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-building"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 4</div>
                                <div class="step-title">Company Detail</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 5: Documents Upload -->
                    <li class="{{ request()->routeIs('donor.step5') ? 'active' : '' }}">
                        <a href="{{ route('donor.step5') }}">
                            <div class="step-icon @if ($document && in_array($document->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($document && $document->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step5')) active-step @endif">
                                @if ($document && in_array($document->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($document && $document->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-file-earmark-text"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 5</div>
                                <div class="step-title">Documents Upload</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 6: Membership Fees -->
                    <li class="{{ request()->routeIs('donor.step6') ? 'active' : '' }}">
                        <a href="{{ route('donor.step6') }}">
                            <div class="step-icon @if ($membership && in_array($membership->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($membership && $membership->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step6')) active-step @endif">
                                @if ($membership && in_array($membership->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($membership && $membership->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-currency-rupee"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 6</div>
                                <div class="step-title">Membership Fees</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 7: Bank Details -->
                    <li class="{{ request()->routeIs('donor.step7') ? 'active' : '' }}">
                        <a href="{{ route('donor.step7') }}">
                            <div class="step-icon @if ($bankDetail && in_array($bankDetail->submit_status, ['submited', 'submitted', 'approved'])) completed-step @endif @if ($bankDetail && $bankDetail->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step7')) active-step @endif">
                                @if ($bankDetail && in_array($bankDetail->submit_status, ['submited', 'submitted', 'approved']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($bankDetail && $bankDetail->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color: white; font-size: 24px;"></i>
                                @else
                                    <i class="bi bi-bank"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 7</div>
                                <div class="step-title">Bank Details</div>
                            </div>
                        </a>
                    </li>

                    <!-- Step 8: Review -->
                    <li class="{{ request()->routeIs('donor.step8') ? 'active' : '' }}">
                        <a href="{{ route('donor.step8') }}">
                            <div class="step-icon @if ($reviewSubmit && in_array($reviewSubmit->submit_status, ['submited','submitted','approved','completed'])) completed-step @endif @if ($reviewSubmit && $reviewSubmit->submit_status === 'resubmit') resubmit-step @endif @if (request()->routeIs('donor.step8')) active-step @endif">
                                @if ($reviewSubmit && in_array($reviewSubmit->submit_status, ['submited','submitted','approved','completed']))
                                    <svg width="34" height="23" viewBox="0 0 34 23" fill="none"><path d="M0 11.5L4.25 7.66667L12.75 15.3333L29.75 0L34 3.83333L12.75 23L0 11.5Z" fill="white" /></svg>
                                @elseif ($reviewSubmit && $reviewSubmit->submit_status === 'resubmit')
                                    <i class="bi bi-x-lg" style="color:white;font-size:24px;"></i>
                                @else
                                    <i class="bi bi-clipboard-check"></i>
                                @endif
                            </div>
                            <div class="step-content">
                                <div class="step-number">Step 8</div>
                                <div class="step-title">Review & Submit</div>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>

            @yield('content')

            <!-- Overlay for Mobile -->
            <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function toggleSidebar() {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('overlay');
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('show');
                }
            </script>
            
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                setTimeout(function() {
                    $('#successAlert').alert('close');
                }, 4000);
            </script>
        </div>
</body>

</html>