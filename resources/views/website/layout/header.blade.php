<!DOCTYPE html>
<html class="wide" lang="en">

<head>
    <title>Jito Rom Zone</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <link rel="icon" href="{{ asset('website/images/BNI_Logo.png') }}" type="image/x-icon"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/assets/images/jrz.png') }}" />

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Barlow%7CBarlow+Condensed:300,400,500,600,700,900">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('website/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">








    <style>
        .material-symbols-rounded {
            font-variation-settings:
                'FILL' 1,
                'wght' 400,
                'GRAD' 0,
                'opsz' 48;
            font-family: 'Material Symbols Rounded';
            font-size: 32px;
            color: #000;
        }

        .navbar-nav .nav-item.active a,
        .navbar-nav .nav-item.active #dropdownToggle span {
            color: #009846 !important;
            font-weight: 600;
        }

        .body {
            font-family: 'Poppins', sans-serif !important;
        }

        #Dropdown {
            list-style: none;
            padding: 10px 0;
            margin: 0;
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: absolute;
            top: 23px;
            left: 0;
            min-width: 200px;
            display: none;
            z-index: 999;
            text-align: left;
        }

        #Dropdown li {
            padding: 8px 15px;
        }

        #Dropdown li a {
            color: #515050 !important;
            text-decoration: none;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            font-size: 16px;
            display: block;
            transition: all 0.3s ease;
        }

        #Dropdown li.active a {
            color: #009846 !important;
            font-weight: 600;
        }

        #Dropdown li:hover a {
            color: #009846;
            background-color: #f8f9fa;
        }

        #appdropdown {
            list-style: none;
            padding: 10px 0;
            margin: 0;
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: absolute;
            top: 23px;
            left: 0;
            min-width: 200px;
            display: none;
            z-index: 999;
            text-align: left;
        }

        #appdropdown li {
            padding: 8px 15px;
        }

        #appdropdown li a {
            color: #515050 !important;
            text-decoration: none;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            font-size: 16px;
            display: block;
            transition: all 0.3s ease;
        }

        #appdropdown li.active a {
            color: #009846 !important;
            font-weight: 600;
        }

        #appdropdown li:hover a {
            color: #009846;
            background-color: #f8f9fa;
        }

        #universitydropdown {
            list-style: none;
            padding: 10px 0;
            margin: 0;
            background: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: absolute;
            top: 23px;
            left: 0;
            min-width: 200px;
            display: none;
            z-index: 999;
            text-align: left;
        }

        #universitydropdown li {
            padding: 8px 15px;
        }

        #universitydropdown li a {
            color: #515050 !important;
            text-decoration: none;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            font-size: 16px;
            display: block;
            transition: all 0.3s ease;
        }

        #universitydropdown li.active a {
            color: #009846 !important;
            font-weight: 600;
        }

        #universitydropdown li:hover a {
            color: #009846;
            background-color: #f8f9fa;
        }

        #donorDropdown li {
            padding: 8px 15px;
        }

        #donorDropdown li:hover a {
            color: #009846;
            background-color: #f8f9fa;
        }

        .navbar-nav .nav-item.active #appdropdownToggle span {
            color: #009846 !important;
            font-weight: 600;
        }

        .navbar-nav .nav-item.active #universitydropdownToggle span {
            color: #009846 !important;
            font-weight: 600;
        }

        .pill.active a {
            color: white;
        }

        .doc-list ol li {
            font-size: 18px;
            font-family: 'Poppins';
        }

        .green-dot {
            /* display: inline-block; */
            padding: 3px 7px;
            border-radius: 50%;
            background: #00a651;
            color: white;
            margin-left: 6px;
            vertical-align: middle
        }

        :root {
            --purple: #403092;
            --accent: #ffca28;
            /* warm yellow */
            --muted: #6c6c6c;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #fff;
            color: #333;
        }

        .page-wrap {
            padding: 40px 20px;
        }

        /* Title */
        .heading-line {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;

        }

        .accent-bar {
            width: 6px;
            height: 40px;
            background: linear-gradient(180deg, var(--accent), #ffd54a);
            border-radius: 4px
        }

        .headline {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 10px
        }

        .headline h1 {
            font-family: 'Playfair Display', serif;
            margin: 0;
            font-size: 34px
        }

        .headline .purple {
            color: var(--purple)
        }

        .headline .yellow {
            color: var(--accent);
            font-weight: 700
        }

        .subtitle {
            color: var(--muted);
            font-size: 18px;
            margin-bottom: 28px
        }

        /* Pill buttons */
        .pills {
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 30px
        }

        .pill {
            padding: 10px 22px;
            border-radius: 40px;
            border: 2px solid var(--purple);
            color: var(--purple);
            display: inline-block;
            font-size: 22px;
        }

        .pill.active {
            background: var(--purple);
            color: #fff;
            border-color: var(--purple)
        }

        /* .pill a:hover {
            color: var(--purple);
        } */

        /* Lists */
        .doc-list {
            font-size: 15px;
            color: #444;
            line-height: 1.7
        }

        .doc-list ol {
            padding-left: 18px;
            margin: 0;
            list-style-type: decimal !important;
            list-style-position: outside !important;
        }

        /* Override global list styles */
        body .doc-list ol {
            list-style-type: decimal !important;
            padding-left: 18px !important;
            margin: 0 !important;
        }

        body .doc-list ol li {
            list-style-type: decimal !important;
            display: list-item !important;
        }

        .doc-list li {
            margin-bottom: 8px
        }

        /* Two column card mimic */
        .lists-wrap {
            display: flex;
            gap: 40px
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .headline h1 {
                font-size: 28px
            }

            .lists-wrap {
                flex-direction: column
            }
        }

        @media (max-width:575px) {
            .page-wrap {
                padding: 20px 12px
            }

            .headline h1 {
                font-size: 24px
            }

            .pills {
                gap: 10px
            }

            .pill {
                padding: 8px 14px;
                font-size: 14px
            }
        }

        /* subtle vertical center to numbers when columns stack */
        .right-col {
            border-left: 0
        }

        /* small circle download icons mimic */
        .green-dot {
            /* display: inline-block; */
            padding: 4px;
            border-radius: 50%;
            background: #00a651;
            color: white;
            margin-left: 6px;
            vertical-align: middle
        }

        @media (max-width: 768px) {
            .jitoMember p {
                padding: 8px 10px;
            }
        }

        @media (max-width: 768px) {
            section {
                padding: 10px 0 40px 0px !important;
            }
        }

        @media (max-width: 375px) {
            .numbering {
                height: 50px !important;
                width: 50px !important;
            }

            .step-circle-container {
                height: 60px !important;
                width: 60px !important;
                max-width: 60px !important;
            }
        }
    </style>
    <!-- Bootstrap JS and Popper.js (Bootstrap 4) -->


    <style>
        .ie-panel {
            display: none;
            background: #212121;
            padding: 10px 0;
            box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
            clear: both;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        html.ie-10 .ie-panel,
        html.lt-ie-10 .ie-panel {
            display: block;
        }

        @media (max-width: 768px) {
            .rd-navbar-nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 0;
            }

            .rd-nav-item {
                margin-left: 0;
                /* Remove left margin */
                margin-bottom: 10px;
                /* Add space between items */
            }

            .button {
                background: #D11C2F;
            }

            .rd-navbar-collapse {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
                background-color: white;
                color: white !important;
                /* Set background color for contrast */
                padding: 15px 0;
                /* Add some padding */
                position: absolute;
                top: 100%;
                /* Position below the navbar */
                left: 0;
                right: 0;
                z-index: 9999;
                /* Ensure it stays on top */
                box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
                /* Optional shadow */
            }

            .rd-navbar-toggle {
                display: block;
                /* Show the toggle button on mobile */
            }

            .rd-navbar-brand {
                margin-bottom: 10px;
                /* Space below the brand logo */
            }
        }

        @media (max-width: 768px) {
            .username-responsive {
                font-size: 18px;
                color: #1f1f1f !important;
                font-weight: bold;
                /* Make the text bold */
                /* Increase font size for better readability on small screens */
            }

            .profile-wrapper {
                gap: 5px;
                /* Adjust spacing between image and text on smaller screens */
            }
        }


        .username-text {
            color: white;
            /* Set the default text color to white */
        }

        /* Change text color to black on screens smaller than 768px (tablets and below) */
        @media (max-width: 768px) {
            .username-text {
                color: black;
                /* Change the text color to black for responsive view */
            }
        }
    </style>

</head>


<body>

    {{-- <div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img
                src="{{ asset('website/images/ie8-panel/warning_bar_0000_us.jpg') }}" height="42" width="820"
                alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
    </div> --}}
    {{-- <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container">
        <div class="cssload-speeding-wheel"></div>
      </div>
      <p>Loading...</p>
    </div>
  </div> --}}


    <div class="page">
        <!-- Section Header Default-->
        <header class="section page-header">
            <!--RD Navbar-->
            <div class="rd-navbar-wrap">

                <nav style="height: 125px" class="rd-navbar rd-navbar-classic" data-sm-layout="rd-navbar-fixed"
                    data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed"
                    data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static"
                    data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static"
                    data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static"
                    data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="76px"
                    data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                    <div class="text-center" style="height: 140px; width: auto; background: #EBEBEB; ">
                        <img src="{{ asset('website/images/ie8-panel/image 1.png') }}" alt="Logo"
                            style=" width: 256.44px;height: 89px; margin-top: 20px; ">

                    </div>

                    <div class="rd-navbar-main-outer "
                        style="background-color: white !important;box-shadow: 1px 5px 8px 2px lightgray;">
                        <div class="rd-navbar-main">
                            <!--RD Navbar Panel-->
                            <div class="rd-navbar-panel">
                                <!--RD Navbar Toggle-->
                                <button class="rd-navbar-toggle"
                                    data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                                <!--RD Navbar Brand-->
                                <div class="rd-navbar-brand">
                                    <!--Brand--><a class="brand" href="{{ route('index') }}">
                                        <img class="brand-logo-dark d-block d-md-none ms-auto"
                                            src="{{ asset('jitojeaplogo.png') }}"
                                            srcset="{{ asset('jitojeaplogo.png') }}" alt="Voelas" />
                                        <img class="brand-logo-light" style="width: 150px;height:87px"
                                            src="{{ asset('jitojeaplogo.png') }}"
                                            srcset="{{ asset('jitojeaplogo.png') }}" alt="Voelas" />
                                    </a>
                                </div>
                            </div>
                            <!-- Rd Navbar Navigation-->

                            <div class="rd-navbar-main-element">
                                <div class="rd-navbar-nav-wrap">
                                    <ul class="rd-navbar-nav d-flex align-items-center justify-content-center"
                                        style="display: flex; align-items: center; justify-content: center; list-style: none; margin: 0; padding: 0; font-family: Arial, sans-serif; font-weight: 400; font-size: 16px; line-height: 1;">
                                        <ul class="navbar-nav flex-md-row flex-column text-center text-md-start">
                                            <ul
                                                class="navbar-nav flex-md-row flex-column align-items-md-center text-center text-md-start nav-link-sm">
                                                <li
                                                    class="nav-item px-md-2 py-1 {{ request()->is('index') ? 'active' : '' }}">
                                                    <a class="nav-link text-black" href="{{ route('index') }}">HOME</a>
                                                </li>
                                                <li class="d-none d-md-inline text-black px-2">|</li>
                                                <li
                                                    class="nav-item px-md-2 py-1 position-relative {{ request()->is('about/*') ? 'active' : '' }}">
                                                    <div id="dropdownToggle"
                                                        class="d-flex text-black align-items-center"
                                                        style="cursor: pointer;">
                                                        <span>ABOUT</span>
                                                        <svg width="14" height="14" style="margin-left: 5px;">
                                                            <path d="M2 4 L7 9 L12 4" stroke="black" stroke-width="2"
                                                                fill="none" />
                                                        </svg>
                                                    </div>


                                                    <ul id="Dropdown"
                                                        style="
                                                                list-style: none;
                                                                padding: 10px 0;
                                                                margin: 0;
                                                                background: #ffffff;
                                                                border: 1px solid #ccc;
                                                                border-radius: 8px;
                                                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                                                                position: absolute;
                                                                top: 23px;
                                                                left: 0;
                                                                min-width: 200px;
                                                                display: none;
                                                                z-index: 999;
                                                                text-align: left;
                                                            ">

                                                        <li class="{{ request()->routeIs('jito') ? 'active' : '' }}">
                                                            <a href="{{ route('jito') }}">Jito</a>
                                                        </li>

                                                        <li class="{{ request()->routeIs('jeap') ? 'active' : '' }}">
                                                            <a href="{{ route('jeap') }}">Jeap</a>
                                                        </li>

                                                        <li
                                                            class="{{ request()->routeIs('boardOfDirectors') ? 'active' : '' }}">
                                                            <a href="{{ route('boardOfDirectors') }}">Board of
                                                                Directors</a>
                                                        </li>

                                                        <li
                                                            class="{{ request()->routeIs('zoneChairmen') ? 'active' : '' }}">
                                                            <a href="{{ route('zoneChairmen') }}">Zone Chairmen</a>
                                                        </li>

                                                        <li
                                                            class="{{ request()->routeIs('testimonial&Success') ? 'active' : '' }}">
                                                            <a href="{{ route('testimonial&Success') }}">Our
                                                                Testimonials / Success Story</a>
                                                        </li>

                                                    </ul>

                                                </li>
                                                <li class="d-none d-md-inline text-black px-2">|</li>
                                                <li
                                                    class="nav-item px-md-2 py-1 position-relative {{ request()->is('application/*') ? 'active' : '' }}">
                                                    <div id="appdropdownToggle"
                                                        class="d-flex text-black align-items-center"
                                                        style="cursor: pointer;">
                                                        <span>APPLICATION</span>
                                                        <svg width="14" height="14" style="margin-left: 5px;">
                                                            <path d="M2 4 L7 9 L12 4" stroke="black" stroke-width="2"
                                                                fill="none" />
                                                        </svg>
                                                    </div>


                                                    <ul id="appdropdown"
                                                        style="
                                                                list-style: none;
                                                                padding: 10px 0;
                                                                margin: 0;
                                                                background: #ffffff;
                                                                border: 1px solid #ccc;
                                                                border-radius: 8px;
                                                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                                                                position: absolute;
                                                                top: 23px;
                                                                left: 0;
                                                                min-width: 200px;
                                                                display: none;
                                                                z-index: 999;
                                                                text-align: left;
                                                            ">

                                                        <li class="">
                                                            <a href="{{ route('documentchecklist1') }}">DOCUMENTS</a>
                                                        </li>
                                                        <li
                                                            class="{{ request()->routeIs('howtoapply') ? 'active' : '' }}">
                                                            <a href="{{ route('howtoapply') }}">How to apply</a>
                                                        </li>
                                                        <li class="{{ request()->routeIs('faqs') ? 'active' : '' }}">
                                                            <a href="{{ route('faqs') }}">FAQ’s</a>
                                                        </li>



                                                    </ul>

                                                </li>
                                                <li class="d-none d-md-inline text-black px-2">|</li>
                                                <li
                                                    class="nav-item px-md-2 py-1 position-relative {{ request()->is('donors/*') ? 'active' : '' }}">
                                                    <div id="donorDropdownToggle"
                                                        class="d-flex text-black align-items-center"
                                                        style="cursor: pointer;">
                                                        <span>DONOR</span>
                                                        <svg width="14" height="14" style="margin-left: 5px;">
                                                            <path d="M2 4 L7 9 L12 4" stroke="black" stroke-width="2"
                                                                fill="none" />
                                                        </svg>
                                                    </div>

                                                    <ul id="donorDropdown"
                                                        style="
                                                                list-style: none;
                                                                padding: 10px 0;
                                                                margin:0;
                                                                background:#ffffff;
                                                                border:1px solid #ccc;
                                                                border-radius: 8px;
                                                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                                                                position:absolute;
                                                                top:23px;
                                                                left:0;
                                                                min-width:200px;
                                                                display:none;
                                                                z-index:999;
                                                                text-align: left;
                                                            ">
                                                        <li
                                                            class="{{ request()->routeIs('beDonor') ? 'active' : '' }}">
                                                            <a href="{{ route('beDonor') }}"
                                                                style="color: #515050 !important; text-decoration: none; font-family: 'Poppins', sans-serif !important; font-weight: 500; font-size: 16px; display: block; transition: all 0.3s ease;">BE
                                                                A DONOR</a>
                                                        </li>
                                                        <li
                                                            class="{{ request()->routeIs('ourDonors') ? 'active' : '' }}">
                                                            <a href="{{ route('ourDonors') }}"
                                                                style="color: #515050 !important; text-decoration: none; font-family: 'Poppins', sans-serif !important; font-weight: 500; font-size: 16px; display: block; transition: all 0.3s ease;">Our
                                                                Donors</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="d-none d-md-inline text-black px-2">|</li>

                                                <li
                                                    class="nav-item px-md-2 py-1 position-relative {{ request()->is('university/*') ? 'active' : '' }}">
                                                    <div id="universitydropdownToggle"
                                                        class="d-flex text-black align-items-center"
                                                        style="cursor: pointer;">
                                                        <span>UNIVERSITY</span>
                                                        <svg width="14" height="14" style="margin-left: 5px;">
                                                            <path d="M2 4 L7 9 L12 4" stroke="black" stroke-width="2"
                                                                fill="none" />
                                                        </svg>
                                                    </div>


                                                    <ul id="universitydropdown"
                                                        style="
                                                                list-style: none;
                                                                padding: 10px 0;
                                                                margin: 0;
                                                                background: #ffffff;
                                                                border: 1px solid #ccc;
                                                                border-radius: 8px;
                                                                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                                                                position: absolute;
                                                                top: 23px;
                                                                left: 0;
                                                                min-width: 200px;
                                                                display: none;
                                                                z-index: 999;
                                                                text-align: left;
                                                            ">


                                                        <li
                                                            class="{{ request()->routeIs('Domestic') ? 'active' : '' }}">
                                                            <a href="{{ route('domestic') }}">Domestic</a>
                                                        </li>
                                                        <li
                                                            class="{{ request()->routeIs('foreign') ? 'active' : '' }}">
                                                            <a href="{{ route('foreign') }}">Foreign</a>
                                                        </li>



                                                    </ul>

                                                </li>
                                                <li class="d-none d-md-inline text-black px-2">|</li>

                                                <li class="nav-item px-md-2 py-1">
                                                    <a class="nav-link text-black"
                                                        href="{{ route('gallery') }}">GALLERY</a>
                                                </li>
                                                <li class="d-none d-md-inline text-black px-2">|</li>

                                                <li class="nav-item px-md-2 py-1">
                                                    <a class="nav-link text-black"
                                                        href="{{ route('contact') }}">CONTACT</a>
                                                </li>
                                                <!-- Visible only on small devices -->
                                                <div class="d-block d-md-none">
                                                    @if (!Auth::check())
                                                        <div class="d-flex flex-column align-items-start px-3 py-2"
                                                            style="gap: 10px;">
                                                            {{-- <a class="btn btn-outline-secondary btn-sm"
                                                                href="{{ route('login') }}"
                                                                style="padding: 6px 14px; border-radius: 6px; font-weight: 500; width: 100%;">Login</a> --}}
                                                            <a class="btn btn-success btn-sm"
                                                                href=""
                                                                style="padding: 6px 14px; border-radius: 6px; font-weight: 500; width: 100%;">Login</a>
                                                        </div>
                                                    @else
                                                        <div class="px-3 py-2">
                                                            <a class="d-flex align-items-center text-decoration-none mb-2"
                                                                href="">
                                                                <img src="{{ Auth::user()->image ? asset('roaster/' . Auth::user()->image) : asset('website/images/defaultuser.png') }}"
                                                                    alt="user" class="rounded-circle me-2"
                                                                    style="width: 30px; height: 30px;">
                                                                <span
                                                                    class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                                                            </a>
                                                            <a class="dropdown-item" href="">
                                                                <i class="mdi mdi-account me-1 ms-1"></i> View Profile
                                                            </a>
                                                            <a class="dropdown-item" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#changePasswordModal">
                                                                <i class="mdi mdi-key me-1 ms-1"></i> Change Password
                                                            </a>
                                                            <a class="dropdown-item" href=""
                                                                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                                                <i class="fa fa-power-off me-1 ms-1"></i> Logout
                                                            </a>
                                                            <form id="logout-form-mobile"
                                                                action="" method="POST"
                                                                class="d-none">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </ul>
                                </div>
                            </div>




                            <!-- RD Navbar Collapse -->
                            <div class="rd-navbar-collapse">
                                @if (!Auth::check())
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        {{-- <a class="btn btn-outline-secondary btn-lg px-4 py-2"
                                            href="{{ route('login') }}"
                                            style="padding: 6px 14px; border-radius: 6px ; border-color: gray; font-weight: 500; width: 140px; height: 40px;">Login</a> --}}
                                        <a class="btn btn-success" href=""
                                            style="padding: 6px 14px; border-radius: 6px; font-weight: 500;width: 140px; height: 40px;margin-right:20px;">Login</a>
                                    </div>
                                @else
                                    <div class="">
                                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                            href="" id="navbarDropdown" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">

                                            <img src="{{ Auth::user()->image ? asset('roaster/' . Auth::user()->image) : asset('website/images/defaultuser.png') }}"
                                                alt="user" class="rounded-circle"
                                                style="width: 30px; height:30px;" />
                                            <span style="color: #000;"
                                                class="username-text ">{{ Auth::user()->name }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                            aria-labelledby="navbarDropdown">
                                            <!-- View Profile -->
                                            <li><a class="dropdown-item" href=""><i
                                                        class="mdi mdi-account me-1 ms-1"></i> View
                                                    Profile</a>
                                            </li>
                                            <!-- Change Password -->
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#changePasswordModal">
                                                    <i class="mdi mdi-key me-1 ms-1"></i> Change
                                                    Password
                                                </a>
                                            </li>
                                            <!-- Logout -->
                                            <li><a class="dropdown-item" href=""
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-power-off me-1 ms-1"></i>
                                                    Logout</a></li>
                                            <form id="logout-form" action="" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </ul>
                                    </div>
                                    <!-- Change Password Modal -->
                                    <div class="modal fade" id="changePasswordModal" tabindex="-1"
                                        aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="changePasswordModalLabel">
                                                        Change Password</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action=""
                                                        method="POST" id="changePasswordForm">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="newPassword" class="form-label">New
                                                                Password</label>
                                                            <input type="password" name="password"
                                                                class="form-control" id="newPassword" required>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>

                                        </div>
                                @endif

                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var dropdownPairs = [{
                                            toggle: 'dropdownToggle',
                                            dropdown: 'Dropdown'
                                        },
                                        {
                                            toggle: 'appdropdownToggle',
                                            dropdown: 'appdropdown'
                                        },
                                        {
                                            toggle: 'donorDropdownToggle',
                                            dropdown: 'donorDropdown'
                                        },
                                        {
                                            toggle: 'universitydropdownToggle',
                                            dropdown: 'universitydropdown'
                                        }
                                    ];

                                    dropdownPairs.forEach(function(pair) {
                                        var toggle = document.getElementById(pair.toggle);
                                        var dropdown = document.getElementById(pair.dropdown);

                                        toggle.addEventListener('click', function(event) {
                                            event.stopPropagation();
                                            // Hide all dropdowns
                                            dropdownPairs.forEach(function(p) {
                                                document.getElementById(p.dropdown).style.display = 'none';
                                            });
                                            // Then toggle current
                                            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                                        });
                                    });

                                    // Close all on outside click
                                    document.addEventListener('click', function() {
                                        dropdownPairs.forEach(function(p) {
                                            document.getElementById(p.dropdown).style.display = 'none';
                                        });
                                    });
                                });
                            </script>
                        </div>
                        {{-- </div>
                                @endif
                            </div> --}}
                    </div>
            </div>
            </nav>
    </div>
    </header>
    </div>
