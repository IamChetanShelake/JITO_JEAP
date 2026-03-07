@extends('website.layout.main')
@section('content')
    <section>
        <div class="desktop-margin" style="position: relative; background-color: #393186; padding: 80px 0;">
            
            <style>
                /* Marquee Animation for Note */
                .marquee-container {
                    overflow: hidden;
                    background-color: white;
                    white-space: nowrap;
                    position: relative;
                }
                
                .marquee-content {
                    display: inline-block;
                    animation: marquee 20s linear infinite; /* Adjust speed here */
                    padding-left: 100%; /* Start off-screen */
                }
                
                .marquee-content:hover {
                    animation-play-state: paused; /* Optional: Pause on hover */
                }

                @keyframes marquee {
                    0%   { transform: translate(0, 0); }
                    100% { transform: translate(-100%, 0); }
                }

                /* Large Devices (Laptop / Desktop) */
                @media (min-width: 992px) {
                    .note-margin {
                        margin-top: -13px !important;
                    }
                }

                /* Mobile Devices */
                @media (max-width: 576px) {
                    .note-margin {
                        margin-top: -80px !important;
                    }
                }

                /* Dotted connectors */
                .dotted-connector {
                    position: absolute;
                    top: 40px;
                    left: 32%;
                    width: 100%;
                    height: 3px;
                    background-image: radial-gradient(circle, white 2px, transparent 2px);
                    background-size: 10px 1px;
                    background-position: 0 0;
                    transform: translateY(-50%);
                    z-index: 0;
                }

                /* Show dotted lines only on desktop (≥768px) */
                @media (min-width: 768px) {
                    .dotted-connector {
                        display: block;
                    }
                }

                @media (max-width: 768px) {
                    .dotted-connector {
                        display: none;
                    }
                }
            </style>

            <!-- Running Note / Marquee -->
            <div class="note-margin marquee-container" style="padding: 30px 0;">
                <div class="marquee-content">
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                    <!-- Duplicate for seamless loop -->
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                    <!-- Duplicate 2 for seamless loop -->
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                    <!-- Duplicate 3 for seamless loop -->
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                </div>
            </div>

            <div class="container">
                <div class="row align-items-center" style="margin-top: 50px;">

                    <!-- LEFT SIDE CONTENT -->
                    <div class="col-lg-7 col-md-12 text-white mb-5 ">

                        <h2 class=" mb-3"
                            style="font-family: Times New Roman;font-size:48px; line-height: 1.3;color:#ffff;font-weight:400;text-transform:none !important;">
                            Empowering Your <br>Dreams
                        </h2>

                        <p class="mb-4" style="font-size: 18px; color: #ffff;font-family:'Poppins', sans-serif; ">
                            JEAP’s mission is to empower deserving students to pursue their
                            academic aspirations and reach their highest potential.
                        </p>

                        <!-- ICON ROW -->
                        <div class="icons-container" style="position: relative;">
                            <div class="row text-center">

                                <div class="col-6 col-md-3 mb-4">
                                    <div class="p-3 bg-white rounded-circle mx-auto"
                                        style="width:80px;height:80px; display:flex; justify-content:center; align-items:center;    z-index: 9;
                                    position: relative;">
                                        <svg width="50" height="41" viewBox="0 0 50 41" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M40.3906 18.6055L30.1172 23.5283C28.5151 24.294 26.7649 24.6914 24.9932 24.6914C23.2214 24.6914 21.4713 24.2941 19.8691 23.5283H19.8701L9.5957 18.6055L8.87988 18.2617V29.9443C8.87988 31.7772 9.47652 33.4018 10.7402 34.3242C13.0727 36.0522 17.5785 38.3349 24.9932 38.335C32.4126 38.335 36.905 36.0334 39.2461 34.3242C40.5145 33.4073 41.1074 31.7909 41.1074 29.9443V18.2617L40.3906 18.6055ZM24.9932 2.65625C23.5362 2.65629 22.0976 2.98323 20.7812 3.61328L2.91895 12.1348L1.97363 12.5859L2.91895 13.0371L20.7803 21.5576V21.5586C22.0968 22.1889 23.5359 22.5156 24.9932 22.5156C26.3594 22.5156 27.7097 22.2282 28.958 21.6729L29.2061 21.5586L47.0674 13.0371L48.0137 12.5859L47.0674 12.1348L29.2051 3.61328C27.8888 2.98334 26.45 2.65625 24.9932 2.65625ZM6.75684 17.2666L6.47266 17.1309L2.00684 15.001V15L1.84082 14.9141C1.46339 14.7003 1.14277 14.3944 0.90918 14.0225C0.642089 13.5972 0.5 13.1032 0.5 12.5986C0.500021 12.0941 0.642103 11.6001 0.90918 11.1748C1.17624 10.7496 1.55744 10.4109 2.00684 10.1973L2.04004 10.1816L2.05859 10.168L19.8877 1.66309C21.4898 0.897379 23.24 0.500071 25.0117 0.5C26.7836 0.5 28.5345 0.89731 30.1367 1.66309L47.998 10.1846V10.1836C48.4465 10.3982 48.8266 10.7379 49.0928 11.1631C49.359 11.5883 49.5001 12.0819 49.5 12.5859V29.9443C49.5 30.232 49.3871 30.5072 49.1875 30.709C48.9881 30.9105 48.7182 31.0225 48.4385 31.0225C48.159 31.0224 47.8898 30.9103 47.6904 30.709C47.4908 30.5072 47.377 30.2319 47.377 29.9443V15.2959L46.6621 15.6387L43.5391 17.1309L43.2549 17.2666V29.9541C43.2548 32.2311 42.5305 34.6399 40.5117 36.1143C37.8113 38.0609 32.8857 40.5 25.0059 40.5C17.6153 40.5 12.8138 38.3687 10.0303 36.4873L9.5 36.1143C7.48128 34.6335 6.75689 32.2057 6.75684 29.9541V17.2666Z"
                                                fill="#FFD800" stroke="#FFD800" />
                                        </svg>
                                    </div>
                                    <div class="dotted-connector"></div>
                                    <p class="mt-2 text-white"
                                        style="font-family:'Poppins', sans-serif;font-size:18px;font-weight:400;">
                                        Student
                                        <br>
                                        Empowerment
                                    </p>
                                </div>

                                <div class="col-6 col-md-3 mb-4">
                                    <div class="p-3 bg-white rounded-circle mx-auto"
                                        style="width:80px;height:80px; display:flex; justify-content:center; align-items:center;    z-index: 9;
                                    position: relative;">
                                        <svg width="35" height="43" viewBox="0 0 35 43" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.4305 19.863C15.1026 18.1548 11.6137 15.1677 1.61102 15.1677V36.5562C11.6137 36.5562 15.1026 39.5433 17.4305 41.2515M17.4305 19.863V41.2515M17.4305 19.863C19.7585 18.1548 23.2473 15.1677 33.25 15.1677V36.5562C23.2473 36.5562 19.7585 39.5433 17.4305 41.2515M23.6114 1.41834V8.93088M29.1418 1.25153H8.36146C7.78088 1.25083 7.21169 1.41133 6.7182 1.71488L1.25 5.0943L6.7182 8.46753C7.21169 8.77109 7.78088 8.93159 8.36146 8.93088H29.1418C29.6589 8.94545 30.1736 8.85694 30.6556 8.67061C31.1376 8.48427 31.577 8.20389 31.9479 7.84605C32.3188 7.4882 32.6137 7.06016 32.815 6.58725C33.0163 6.11434 33.1201 5.60615 33.1201 5.09275C33.1201 4.57935 33.0163 4.07117 32.815 3.59825C32.6137 3.12534 32.3188 2.6973 31.9479 2.33946C31.577 1.98161 31.1376 1.70123 30.6556 1.5149C30.1736 1.32856 29.6589 1.23697 29.1418 1.25153Z"
                                                stroke="#FFD800" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="dotted-connector"></div>
                                    <p class="mt-2 text-white"
                                        style="font-family:'Poppins', sans-serif;font-size:18px;font-weight:400;">
                                        Educational
                                        <br> Access
                                    </p>
                                </div>

                                <div class="col-6 col-md-3 mb-4">
                                    <div class="p-3 bg-white rounded-circle mx-auto"
                                        style="width:80px;height:80px; display:flex; justify-content:center; align-items:center;    z-index: 9;
                                    position: relative;">
                                        <svg width="36" height="41" viewBox="0 0 36 41" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M32.2143 41H29.2857V36.6071C29.2834 34.6661 28.5113 32.8052 27.1388 31.4327C25.7662 30.0601 23.9053 29.288 21.9643 29.2857H13.1786C11.2375 29.288 9.37664 30.0601 8.00411 31.4327C6.63158 32.8052 5.85947 34.6661 5.85714 36.6071V41H2.92857V36.6071C2.93245 33.8898 4.0136 31.285 5.935 29.3636C7.85641 27.4421 10.4613 26.361 13.1786 26.3571H21.9643C24.6816 26.361 27.2864 27.4421 29.2079 29.3636C31.1293 31.285 32.2104 33.8898 32.2143 36.6071V41ZM1.46429 5.85712C1.07593 5.85712 0.703487 6.01139 0.42888 6.286C0.154273 6.5606 0 6.93305 0 7.3214V20.5H2.92857V7.3214C2.92857 6.93305 2.7743 6.5606 2.49969 6.286C2.22509 6.01139 1.85264 5.85712 1.46429 5.85712Z"
                                                fill="#FFD800" />
                                            <path
                                                d="M0 0V2.92857H7.32143V13.1786C7.32143 15.897 8.40134 18.5042 10.3236 20.4264C12.2458 22.3487 14.853 23.4286 17.5714 23.4286C20.2899 23.4286 22.897 22.3487 24.8193 20.4264C26.7415 18.5042 27.8214 15.897 27.8214 13.1786V2.92857H35.1429V0H0ZM10.25 2.92857H24.8929V7.32143H10.25V2.92857ZM17.5714 20.5C15.6297 20.5 13.7674 19.7286 12.3944 18.3556C11.0214 16.9826 10.25 15.1203 10.25 13.1786V10.25H24.8929V13.1786C24.8929 15.1203 24.1215 16.9826 22.7485 18.3556C21.3754 19.7286 19.5132 20.5 17.5714 20.5Z"
                                                fill="#FFD800" />
                                        </svg>
                                    </div>
                                    <div class="dotted-connector"></div>
                                    <p class="mt-2 text-white"
                                        style="font-family:'Poppins', sans-serif;font-size:18px;font-weight:400;">
                                        Financial
                                        <br>
                                        Support
                                    </p>
                                </div>

                                <div class="col-6 col-md-3 mb-4">
                                    <div class="p-3 bg-white rounded-circle mx-auto"
                                        style="width:80px;height:80px; display:flex; justify-content:center; align-items:center;    z-index: 9;
                                    position: relative;">
                                        <svg width="37" height="39" viewBox="0 0 37 39" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1.46289 29.75C1.7172 29.7501 1.96153 29.851 2.1416 30.0312C2.3218 30.2117 2.42285 30.4574 2.42285 30.7129V37.5371C2.42285 37.7926 2.3218 38.0383 2.1416 38.2188C1.96153 38.399 1.7172 38.4999 1.46289 38.5C1.20839 38.5 0.963375 38.3992 0.783203 38.2188C0.60301 38.0383 0.501953 37.7926 0.501953 37.5371V30.7129C0.501953 30.4574 0.603009 30.2117 0.783203 30.0312C0.963375 29.8508 1.20839 29.75 1.46289 29.75ZM11.1992 21.9502C11.4536 21.9503 11.6979 22.0511 11.8779 22.2314C12.058 22.4118 12.1591 22.6568 12.1592 22.9121V37.5371C12.1592 37.7926 12.0581 38.0383 11.8779 38.2188C11.6979 38.399 11.4535 38.4999 11.1992 38.5C10.9447 38.5 10.6997 38.3992 10.5195 38.2188C10.3393 38.0383 10.2383 37.7926 10.2383 37.5371V22.9121C10.2384 22.6568 10.3395 22.4118 10.5195 22.2314C10.6997 22.051 10.9447 21.9502 11.1992 21.9502ZM20.9355 25.8496C21.1899 25.8497 21.4342 25.9515 21.6143 26.1318C21.7943 26.3123 21.8955 26.5571 21.8955 26.8125V37.5371C21.8955 37.7926 21.7945 38.0383 21.6143 38.2188C21.4342 38.399 21.1899 38.4999 20.9355 38.5C20.6811 38.5 20.436 38.3992 20.2559 38.2188C20.0757 38.0383 19.9746 37.7926 19.9746 37.5371V26.8125C19.9746 26.5571 20.0758 26.3123 20.2559 26.1318C20.436 25.9514 20.681 25.8496 20.9355 25.8496ZM30.6719 16.0996C30.9262 16.0997 31.1705 16.2015 31.3506 16.3818C31.5306 16.5623 31.6318 16.8071 31.6318 17.0625V37.5371C31.6318 37.7926 31.5308 38.0383 31.3506 38.2188C31.1705 38.399 30.9262 38.4999 30.6719 38.5C30.4174 38.5 30.1724 38.3991 29.9922 38.2188C29.812 38.0383 29.7109 37.7926 29.7109 37.5371V17.0625C29.7109 16.8071 29.8121 16.5623 29.9922 16.3818C30.1724 16.2014 30.4174 16.0996 30.6719 16.0996ZM35.6084 0.5L35.7314 0.516602L35.8584 0.552734L35.9482 0.59082C36.0416 0.63135 36.1309 0.691329 36.2168 0.775391L36.2656 0.829102L36.3262 0.908203L36.3975 1.0293L36.4463 1.14355L36.4707 1.22266L36.4863 1.29492L36.5 1.43359V10.2451C36.4999 10.4892 36.4074 10.7242 36.2412 10.9023C36.075 11.0805 35.847 11.1885 35.6045 11.2051C35.3622 11.2215 35.1222 11.1458 34.9336 10.9922C34.7481 10.841 34.6256 10.6255 34.5898 10.3887L34.5791 10.2246V3.78223L33.7256 4.63672L21.1846 17.1943C21.0219 17.3573 20.8063 17.4565 20.5771 17.4736C20.3515 17.4904 20.1277 17.4266 19.9443 17.2939L19.8115 17.1797L13.9209 11.5146L13.5674 11.1748L13.2207 11.5225L2.14062 22.6152V22.6162C1.9692 22.7884 1.73841 22.8893 1.49609 22.8984C1.25396 22.9074 1.01769 22.8236 0.833984 22.665C0.650141 22.5063 0.532547 22.2839 0.505859 22.042C0.479621 21.8039 0.542559 21.5647 0.682617 21.3711L0.794922 21.2412L12.8955 9.125C13.0583 8.96225 13.2747 8.86361 13.5039 8.84668C13.729 8.83014 13.9527 8.89319 14.1357 9.02539L14.2588 9.13184H14.2598L20.1602 14.8057L20.5137 15.1465L20.8604 14.7988L32.3652 3.27832L33.2168 2.4248H26.7734L26.6875 2.4209C26.487 2.40252 26.2965 2.32122 26.1436 2.1875C25.9724 2.0378 25.8594 1.83237 25.8252 1.60742L25.8145 1.4502C25.8174 1.22182 25.9018 1.00224 26.0518 0.830078C26.2014 0.658275 26.4064 0.544866 26.6309 0.510742L26.7949 0.5H35.6084Z"
                                                fill="#FFD800" stroke="#FFD800" />
                                        </svg>
                                    </div>
                                    <p class="mt-2 text-white"
                                        style="font-family:'Poppins', sans-serif;font-size:18px;font-weight:400;">Future
                                        <br>
                                        Growth
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE IMAGE -->
                    <div class="col-lg-5 col-md-12 text-center">
                        <img src="{{ asset('website/images/books.png') }}" alt="" class="img-fluid" style="">
                    </div>

                </div>
            </div>

        </div>

        <style>
            @media (min-width: 1200px) {
                .desktop-margin {
                    margin-top: 200px;
                }
            }

            @media (max-width: 1199px) {
                .desktop-margin {
                    margin-top: 0;
                }
            }
        </style>

        <script>
            function updateCardLayout() {
                const container = document.getElementById('cardContainer');
                if (window.innerWidth < 768) {
                    container.style.position = 'static';
                    container.style.transform = 'none';
                    container.style.flexDirection = 'column';
                    container.style.alignItems = 'center';
                    container.style.gap = '20px';
                } else {
                    container.style.position = 'absolute';
                    container.style.bottom = '-150px';
                    container.style.left = '50%';
                    container.style.transform = 'translateX(-50%)';
                    container.style.flexDirection = 'row';
                    container.style.gap = '100px';
                }
            }

            window.addEventListener('resize', updateCardLayout);
            window.addEventListener('load', updateCardLayout);
        </script>

    </section>

    <!-- Responsive CSS -->
    <style>
        @media (max-width: 768px) {
            .card-container {
                flex-wrap: wrap !important;
            }
        }
    </style>
    <style>
        @media (max-width: 768px) {
            /* Center image container on mobile */
            .about-img-container {
                display: flex !important;
                justify-content: center !important;
            }

            .about-img-container img {
                margin: 0 auto !important;
                display: block !important;
                width: 100% !important;
                max-width: 300px !important;
                transform: none !important;
            }

            /* Reduce gap on smaller screens */
            .text-image-wrapper {
                gap: 30px !important;
            }
        }
    </style>

    {{-- =============================KEY INSTRUCTIONS SECTION================= --}}
    <section class="key-instructions-section" style="background:#ffffff;  padding:80px 0;">
        <div class="container">
            <!-- Title -->
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">KEY</span> <span style="color: #393186;">INSTRUCTIONS</span>
                    </h2>
                </div>
            </div>

            <!-- Cards Row -->
            <div class="row justify-content-center mt-4" id="keyInstructionsRow">
                
                <!-- Styles for Hover Effect -->
                <style>
                    .key-card {
                        transition: all 0.3s ease;
                    }
                    
                    /* Hover effects using data attributes */
                    .key-card[data-color="blue"]:hover {
                        background-color: #00008B !important;
                        border-color: #00008B !important;
                    }
                    .key-card[data-color="blue"]:hover .card-title,
                    .key-card[data-color="blue"]:hover .card-text {
                        color: #fff !important;
                    }
                    
                    .key-card[data-color="green"]:hover {
                        background-color: #009846 !important;
                        border-color: #009846 !important;
                    }
                    .key-card[data-color="green"]:hover .card-title,
                    .key-card[data-color="green"]:hover .card-text {
                        color: #fff !important;
                    }
                    
                    .key-card[data-color="yellow"]:hover {
                        background-color: #FFD800 !important;
                        border-color: #FFD800 !important;
                    }
                    .key-card[data-color="yellow"]:hover .card-title,
                    .key-card[data-color="yellow"]:hover .card-text {
                        color: #000 !important;
                    }
                    
                    .key-card[data-color="red"]:hover {
                        background-color: #E31E25 !important;
                        border-color: #E31E25 !important;
                    }
                    .key-card[data-color="red"]:hover .card-title,
                    .key-card[data-color="red"]:hover .card-text {
                        color: #fff !important;
                    }
                    
                    .key-card[data-color="purple"]:hover {
                        background-color: #393186 !important;
                        border-color: #393186 !important;
                    }
                    .key-card[data-color="purple"]:hover .card-title,
                    .key-card[data-color="purple"]:hover .card-text {
                        color: #fff !important;
                    }
                </style>

                <!-- Card 1 -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="key-card" data-color="blue"
                        style="position: relative; background: #ffffff; border-radius: 0px;
                                border: 2px solid #00008B; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 200px; display: flex; flex-direction: column; justify-content: center; align-items: center; ">
                        <div class="icon-circle"
                            style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); background: #00008B; border-radius: 50%; border: 5px solid #ffff;
                                width: 45%;
                                height: 45%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M35.4167 1.5H4.58333C2.88046 1.5 1.5 2.88046 1.5 4.58333V27.1944C1.5 28.8973 2.88046 30.2778 4.58333 30.2778H35.4167C37.1195 30.2778 38.5 28.8973 38.5 27.1944V4.58333C38.5 2.88046 37.1195 1.5 35.4167 1.5Z"
                                    stroke="white" stroke-width="3" stroke-linejoin="round" />
                                <path d="M9.72266 38.5H30.2782M20.0004 30.2778V38.5" stroke="white" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px;">
                            Use a Computer</h5>
                        <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5;">
                            Use a laptop or desktop to complete the application (not a mobile device).</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="key-card" data-color="green"
                        style="position: relative; background: #ffffff; border-radius: 0px;
                        border: 2px solid #009846; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 200px; display: flex; flex-direction: column; justify-content: center; align-items: center; ">
                        <div class="icon-circle"
                            style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); background: #009846; border-radius: 50%; border: 5px solid #ffff;
                            width: 45%;
                            height: 45%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <svg width="38" height="42" viewBox="0 0 38 42" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.375 18.8333V31.8333M14.625 18.8333V31.8333M5.875 10.1667V36.1667C5.875 37.3159 6.33594 38.4181 7.15641 39.2308C7.97688 40.0435 9.08968 40.5 10.25 40.5H27.75C28.9103 40.5 30.0231 40.0435 30.8436 39.2308C31.6641 38.4181 32.125 37.3159 32.125 36.1667V10.1667M1.5 10.1667H36.5M8.0625 10.1667L12.4375 1.5H25.5625L29.9375 10.1667"
                                    stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px;">
                            Clear Browser Cache</h5>
                        <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5;">
                            Clear your browser cache and history before beginning.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="key-card" data-color="yellow"
                        style="position: relative; background: #ffffff; border-radius: 0px;
                        border: 2px solid #FFD800; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 200px; display: flex; flex-direction: column; justify-content: center; align-items: center; ">
                        <div class="icon-circle"
                            style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); background: #FFD800; border-radius: 50%; border: 5px solid #ffff;
                            width: 45%;
                            height: 45%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M28.5 0.25C28.8315 0.25 29.1494 0.381791 29.3838 0.616211C29.6182 0.850632 29.75 1.16848 29.75 1.5V4.25H35.5C36.8924 4.25 38.2273 4.80352 39.2119 5.78809C40.1965 6.77265 40.75 8.10761 40.75 9.5V35.5C40.75 36.8924 40.1965 38.2273 39.2119 39.2119C38.2273 40.1965 36.8924 40.75 35.5 40.75H5.5C4.1082 40.7483 2.77321 40.1951 1.78906 39.2109C0.804914 38.2268 0.251667 36.8918 0.25 35.5V9.5L0.256836 9.23926C0.32269 7.94234 0.866478 6.71165 1.78906 5.78906C2.77321 4.80491 4.1082 4.25167 5.5 4.25H11.25V1.5C11.25 1.16848 11.3818 0.850631 11.6162 0.616211C11.8506 0.381791 12.1685 0.25 12.5 0.25C12.8315 0.25 13.1494 0.381791 13.3838 0.616211C13.6182 0.850632 13.75 1.16848 13.75 1.5V4.25H27.25V1.5C27.25 1.16848 27.3818 0.850632 27.6162 0.616211C27.8506 0.381791 28.1685 0.25 28.5 0.25ZM2.75 35.5C2.75 36.2293 3.03994 36.9286 3.55566 37.4443C4.07139 37.9601 4.77065 38.25 5.5 38.25H35.5C36.2293 38.25 36.9286 37.9601 37.4443 37.4443C37.9601 36.9286 38.25 36.2293 38.25 35.5V18.75H2.75V35.5ZM5.5 6.75C3.97829 6.75 2.75 7.98185 2.75 9.5V16.25H38.25V9.5C38.25 8.77065 37.9601 8.07139 37.4443 7.55566C36.9286 7.03994 36.2293 6.75 35.5 6.75H29.75V9.5C29.75 9.83152 29.6182 10.1494 29.3838 10.3838C29.1494 10.6182 28.8315 10.75 28.5 10.75C28.1685 10.75 27.8506 10.6182 27.6162 10.3838C27.3818 10.1494 27.25 9.83152 27.25 9.5V6.75H13.75V9.5C13.75 9.83152 13.6182 10.1494 13.3838 10.3838C13.1494 10.6182 12.8315 10.75 12.5 10.75C12.1685 10.75 11.8506 10.6182 11.6162 10.3838C11.3818 10.1494 11.25 9.83152 11.25 9.5V6.75H5.5Z"
                                    fill="white" stroke="white" stroke-width="0.5" />
                            </svg>
                        </div>
                        <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px;">
                            Application Deadline</h5>
                        <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5;">
                            Apply at least 90 days before your course start date.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="key-card" data-color="red"
                        style="position: relative; background: #ffffff; border-radius: 0px;
                        border: 2px solid #E31E25; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 200px; display: flex; flex-direction: column; justify-content: center; align-items: center; ">
                        <div class="icon-circle"
                            style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); background: #E31E25; border-radius: 50%; border: 5px solid #ffff;
                            width: 45%;
                            height: 45%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <svg width="44" height="42" viewBox="0 0 44 42" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M21.9289 40.5C32.1856 40.5 40.5003 32.1853 40.5003 21.9285C40.5003 11.6718 32.1856 3.35712 21.9289 3.35712C11.6721 3.35712 3.35742 11.6718 3.35742 21.9285C3.35742 32.1853 11.6721 40.5 21.9289 40.5Z"
                                    stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M21.9286 12.6429V21.9286L27.5 27.5M1.5 7.07143L7.07143 1.5M36.7857 1.5L42.3571 7.07143"
                                    stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px;">
                            Submission Validity</h5>
                        <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5;">
                            Submit your form within 30 days of creation or it will be disabled.</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="key-card" data-color="purple"
                        style="position: relative; background: #ffffff; border-radius: 0px;
                        border: 2px solid #393186; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 200px; display: flex; flex-direction: column; justify-content: center; align-items: center; ">
                        <div class="icon-circle"
                            style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); background: #393186; border-radius: 50%; border: 5px solid #ffff;
                            width: 45%;
                            height: 45%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <svg width="38" height="42" viewBox="0 0 38 42" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.375 18.8333V31.8333M14.625 18.8333V31.8333M5.875 10.1667V36.1667C5.875 37.3159 6.33594 38.4181 7.15641 39.2308C7.97688 40.0435 9.08968 40.5 10.25 40.5H27.75C28.9103 40.5 30.0231 40.0435 30.8436 39.2308C31.6641 38.4181 32.125 37.3159 32.125 36.1667V10.1667M1.5 10.1667H36.5M8.0625 10.1667L12.4375 1.5H25.5625L29.9375 10.1667"
                                    stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px;">
                            Required Documents</h5>
                        <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5;">
                            Keep all required documents ready before starting.<br>Checklist on JEAP website.</p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="key-card" data-color="green"
                        style="position: relative; background: #ffffff; border-radius: 0px;
                        border: 2px solid #009846; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 200px; display: flex; flex-direction: column; justify-content: center; align-items: center; ">
                        <div class="icon-circle"
                            style="position: absolute; top: -40px; left: 50%; transform: translateX(-50%); background: #009846; border-radius: 50%; border: 5px solid #ffff;
                            width: 45%;
                            height: 45%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                            <svg width="38" height="42" viewBox="0 0 38 42" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.375 18.8333V31.8333M14.625 18.8333V31.8333M5.875 10.1667V36.1667C5.875 37.3159 6.33594 38.4181 7.15641 39.2308C7.97688 40.0435 9.08968 40.5 10.25 40.5H27.75C28.9103 40.5 30.0231 40.0435 30.8436 39.2308C31.6641 38.4181 32.125 37.3159 32.125 36.1667V10.1667M1.5 10.1667H36.5M8.0625 10.1667L12.4375 1.5H25.5625L29.9375 10.1667"
                                    stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px;">
                            Clear Browser Cache</h5>
                        <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5;">
                            Clear your browser cache and history before beginning.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

           {{-- =============================WORKING COMMITTEE SECTION================= --}}
    <section style="padding: 80px 0; background: #FFF9E6;">
        <div class="container">
            <!-- Header -->
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">WORKING</span> <span style="color: #393186;">COMMITTEE</span>
                    </h2>
                </div>
            </div>

            <!-- Custom Styling for Hover Effects -->
            <style>
                .committee-card-item {
                    background-color: #393186; /* Default: Blue Background */
                    border: 2px solid #FFD800; /* Default: Yellow Border */
                    padding: 30px 20px;
                    text-align: center;
                    height: 100%;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    transition: all 0.3s ease; /* Smooth transition for hover */
                }

                /* Hover State */
                .committee-card-item:hover {
                    background-color: #ffffff; /* Hover: White Background */
                    border-color: #393186;      /* Hover: Blue Border */
                }

                /* Text Colors - Default (On Blue) */
                .committee-card-item h3 {
                    color: #ffffff; /* White Name */
                    transition: color 0.3s ease;
                }
                .committee-card-item p {
                    color: #e0e0e0; /* Light Grey Role */
                    transition: color 0.3s ease;
                }
                .committee-card-item a {
                    color: #FFD800; /* Yellow Link */
                }

                /* Text Colors - Hover (On White) */
                .committee-card-item:hover h3 {
                    color: #393186; /* Blue Name */
                }
                .committee-card-item:hover p {
                    color: #666; /* Dark Grey Role */
                }
                .committee-card-item:hover a {
                    color: #393186; /* Blue Link */
                }

                /* Image Circle Border Logic */
                .committee-card-item .img-circle {
                    border: 3px solid #ffffff; /* White border on Blue card */
                    transition: border-color 0.3s ease;
                }
                .committee-card-item:hover .img-circle {
                    border-color: #393186; /* Blue border on White card */
                }
            </style>

            <!-- Cards Grid Layout -->
            <div class="row">
                
                <!-- Card 1 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="committee-card-item">
                        <div class="img-circle" style="width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden;">
                            <img src="{{ asset('website/images/wc11.png') }}" alt="Hilash Deshi" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h3 style="font-size: 16px; font-weight: 600; font-family: 'Poppins', sans-serif; margin-bottom: 5px; text-transform: none;">
                            Hilash Deshi
                        </h3>
                        <p style="font-size: 16px; font-weight: 500; margin-bottom: 15px;">
                            Chairman
                        </p>
                        <a href="#" style="font-size: 16px; text-decoration: underline; font-weight: 500;">Show more</a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="committee-card-item">
                        <div class="img-circle" style="width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden;">
                            <img src="{{ asset('website/images/wc001.png') }}" alt="Dr. Lipin Doshi" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h3 style="font-size: 16px; font-weight: 600; font-family: 'Poppins', sans-serif; margin-bottom: 5px; text-transform: none;">
                            Dr. Lipin Doshi
                        </h3>
                        <p style="font-size: 16px; font-weight: 500; margin-bottom: 15px;">
                            Vice Chairman
                        </p>
                        <a href="#" style="font-size: 16px; text-decoration: underline; font-weight: 500;">Show more</a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="committee-card-item">
                        <div class="img-circle" style="width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden;">
                            <img src="{{ asset('website/images/wc002.png') }}" alt="Mahaveer Singh Choudhary" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h3 style="font-size: 16px; font-weight: 600; font-family: 'Poppins', sans-serif; margin-bottom: 5px; text-transform: none;">
                            Mahaveer Singh Choudhary
                        </h3>
                        <p style="font-size: 16px; font-weight: 500; margin-bottom: 15px;">
                            Vice Chairman
                        </p>
                        <a href="#" style="font-size: 16px; text-decoration: underline; font-weight: 500;">Show more</a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="committee-card-item">
                        <div class="img-circle" style="width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden;">
                            <img src="{{ asset('website/images/wc003.png') }}" alt="CA Satish Hiran" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h3 style="font-size: 16px; font-weight: 600; font-family: 'Poppins', sans-serif; margin-bottom: 5px; text-transform: none;">
                            CA Satish Hiran
                        </h3>
                        <p style="font-size: 16px; font-weight: 500; margin-bottom: 15px;">
                            Chief Secretary
                        </p>
                        <a href="#" style="font-size: 16px; text-decoration: underline; font-weight: 500;">Show more</a>
                    </div>
                </div>

                

            </div>
        </div>
    </section>
    
    {{-- =============================ABOUT US SECTION================= --}}

    <section style="padding: 100px 0; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;">

            <!-- About Us Section -->
            <div class="text-image-wrapper row">
                <!-- Image -->
                <div class="about-img-container col-md-5" style="">
                    <img src="{{ asset('website/images/books22.png') }}" alt="About Us Image" style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">
                </div>
                <!-- Text -->
                <div style="" class="col-md-7">
                    <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                        <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                        <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            <span style="color: #FFD800;">Empowering</span> <span style="color: #393186;">Futures</span>
                        </h2>
                    </div>
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 20px; font-family: Arial; color: #5B5B5B; text-align: justify;">
                        We are committed to empowering deserving, needy, and meritorious students to pursue higher
                        education in India and abroad. Through financial assistance and essential resources, we enable
                        them to access top-tier institutions and unlock their true potential.
                    </p>
                    <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;margin-top:30px;">
                        <div style="width: 10px; height: 10px; background-color: #FFD800;border-radius:50%"></div>
                        <h2 style="font-size: 20px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            <span style="color: #FFD800;">Vision</span> <span style="color: #393186;">of JEAP</span>
                        </h2>
                    </div>
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 10px; font-family: Arial; color: #5B5B5B; text-align: justify;">
                        Aligned with JITO’s overarching vision, JEAP (JITO Education Assistance Program) was established
                        with a dedicated focus on uplifting Jain students through quality education and meaningful
                        opportunities.
                    </p>
                    <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;margin-top:30px;">
                        <div style="width: 10px; height: 10px; background-color: #FFD800;border-radius:50%"></div>
                        <h2 style="font-size: 20px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            <span style="color: #FFD800;">Mission</span> <span style="color: #393186;">of JEAP</span>
                        </h2>
                    </div>
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 10px; font-family: Arial; color: #5B5B5B; text-align: justify;">
                        To reach every deserving and underprivileged Jain student by extending timely and impactful
                        support that enables meaningful academic progress and nurtures their overall personal growth.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 0px 0 0 0; background: #ffffff; margin-bottom:0px;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;">
            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                    <span style="color: #FFD800;">Achievements</span> <span style="color: #393186;">& Impact</span>
                </h2>
            </div>
        </div>
    </section>

    <section style="padding:20px 0 0 0; background: #393186;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;">
            <!-- About Us Section -->
            <div class="text-image-wrapper row">
                <!-- Text -->
                <div style="" class="col-md-7">
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 20px; font-family: Arial; color: #FFFF; text-align: justify;">
                        At JEAP, we’ve reshaped student financing with the support of 250+ generous donors who have
                        contributed over ₹39.85 crore. This has enabled us to assist 561+ students, disbursing ₹39.80+
                        crore to date. These numbers reflect transformed lives and fulfilled dreams. Join us in ensuring
                        that financial barriers never limit a student’s pursuit of education.
                    </p>
                    <div class="row">
                        <div class="col-md-3 ">
                            <div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;">
                                <h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">250+</h3>
                                <p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">
                                    Number of Donors
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;">
                                <h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">261+</h3>
                                <p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">
                                    Students got benefits
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;">
                                <h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">39.80+</h3>
                                <p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">
                                    Financial Assistance Amount
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;">
                                <h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">39.85 Cr+</h3>
                                <p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">
                                    Amount collected from Donors
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Image -->
                <div class="about-img-container col-md-5" style="">
                    <img src="{{ asset('website/images/trophy22.png') }}" alt="About Us Image" style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);margin-bottom:-9.5px;">
                </div>
            </div>
        </div>
    </section>

       {{-- Photo Gallery Section --}}
    <section style="padding:80px 0; background: #fff;">
        <div class="container">
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Photo</span> <span style="color: #393186;">Gallery</span>
                    </h2>
                </div>
            </div>

            <!-- Updated Gallery Container -->
            <div class="gallery-slider-container" style="overflow-x: auto; position: relative; width: 100%; scroll-behavior: smooth;">
                <div class="gallery-slider" style="display: flex; gap: 0; padding: 10px 0;">
                    
                    <!-- Original Images -->
                    <img src="{{ asset('website/images/gallery_img_1.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 1">
                    <img src="{{ asset('website/images/gallery_img_2.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 2">
                    <img src="{{ asset('website/images/gallery_img_3.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 3">
                    <img src="{{ asset('website/images/gallery_img_4.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 4">
                    <img src="{{ asset('website/images/gallery_img_5.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 5">

                    <!-- Duplicate Images for seamless loop -->
                    <img src="{{ asset('website/images/gallery_img_1.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 1">
                    <img src="{{ asset('website/images/gallery_img_2.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 2">
                    <img src="{{ asset('website/images/gallery_img_3.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 3">
                    <img src="{{ asset('website/images/gallery_img_4.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 4">
                    <img src="{{ asset('website/images/gallery_img_5.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0;" alt="Gallery Image 5">
                </div>
            </div>
        </div>
    </section>

    {{-- UPDATED STYLES TO HIDE SCROLLBAR --}}
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .gallery-slider-container::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .gallery-slider-container {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        .gallery-img {
            transition: transform 0.3s ease;
        }

        .gallery-img:hover {
            transform: scale(1.05);
            z-index: 1;
        }
    </style>
    
   
    
   

        {{-- ============================= OUR TESTIMONIALS SECTION ============================= --}}
    
    <section>
        <div class="container mt-5 mb-5">
            <div style="flex: 1 1 50%; max-width: 700px;">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">OUR</span> <span style="color: #393186;">TESTIMONIALS</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 60px 0 80px 0; background-color: #FFF9E6;">
        <div class="container">
            <div class="row justify-content-center align-items-stretch">
                
                <!-- Testimonial 1 (Left - White Card) -->
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100" style="background: #ffffff; border: 1px solid #D7D7D7; border-radius: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <div style="width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 3px solid #FFD800;">
                            <img src="{{ asset('website/images/t1.png') }}" alt="Samyukta Shah" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h5 style="color: #393186; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 18px;">Life - Changing Support</h5>
                        <p style="color: #5B5B5B; font-size: 14px; margin-bottom: 20px;">JEAP’s assistance helped me pursue my education without financial stress.</p>
                        <p style="color: #333; font-weight: 600; font-size: 15px; margin-bottom: 5px;">Samyukta Shah</p>
                        <p style="color: #999; font-size: 13px; margin-bottom: 0;">24 Dec 2024</p>
                    </div>
                </div>

                <!-- Testimonial 2 (Middle - Purple Card) -->
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100" style="background: #393186; border: none; border-radius: 0; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                        <div style="width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 3px solid #ffffff;">
                            <img src="{{ asset('website/images/t2.png') }}" alt="Kural Mehta" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <!-- Yellow Title for contrast on purple -->
                        <h5 style="color: #FFD800; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 18px;">A Dream Made Possible</h5>
                        <p style="color: #e0e0e0; font-size: 14px; margin-bottom: 20px;">Their support enabled me to study at my desired university with confidence.</p>
                        <p style="color: #fff; font-weight: 600; font-size: 15px; margin-bottom: 5px;">Kural Mehta</p>
                        <p style="color: #ccc; font-size: 13px; margin-bottom: 0;">24 Dec 2024</p>
                    </div>
                </div>

                <!-- Testimonial 3 (Right - White Card) -->
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100" style="background: #ffffff; border: 1px solid #D7D7D7; border-radius: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <div style="width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 3px solid #FFD800;">
                            <img src="{{ asset('website/images/t3.png') }}" alt="Shreya Jain" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h5 style="color: #393186; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 18px;">Life - Changing Support</h5>
                        <p style="color: #5B5B5B; font-size: 14px; margin-bottom: 20px;">JEAP’s assistance helped me pursue my education without financial stress.</p>
                        <p style="color: #333; font-weight: 600; font-size: 15px; margin-bottom: 5px;">Shreya Jain</p>
                        <p style="color: #999; font-size: 13px; margin-bottom: 0;">24 Dec 2024</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

        {{-- ============================= SUCCESS STORIES SECTION ============================= --}}
    
    <section style="padding: 80px 0; background: #FFF;">
        <div class="container">
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">SUCCESS</span> <span style="color: #393186;">STORIES</span>
                    </h2>
                </div>
            </div>

            <div class="row">
                <!-- Video Item 1 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <!-- Video Thumbnail -->
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_1.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 1">
                    </div>
                    <!-- Custom Watch on YouTube Button -->
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Video Item 2 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_2.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 2">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Video Item 3 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_3.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 3">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Video Item 4 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_4.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 4">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('testimonialContainer');
            const items = container.querySelectorAll('.testimonial-item');
            const totalItems = items.length;
            const visibleItems = 3;
            const maxIndex = totalItems - visibleItems;
            let currentIndex = 0;

            document.getElementById('rightArrow').addEventListener('click', function() {
                currentIndex++;
                if (currentIndex >= maxIndex) {
                    setTimeout(function() {
                        container.style.transition = 'none';
                        currentIndex = 0;
                        updateTransform();
                        setTimeout(function() {
                            container.style.transition = 'transform 0.5s ease';
                        }, 50);
                    }, 250);
                } else {
                    updateTransform();
                }
            });

            document.getElementById('leftArrow').addEventListener('click', function() {
                currentIndex--;
                if (currentIndex < 0) {
                    setTimeout(function() {
                        container.style.transition = 'none';
                        currentIndex = maxIndex - 1;
                        updateTransform();
                        setTimeout(function() {
                            container.style.transition = 'transform 0.5s ease';
                        }, 50);
                    }, 250);
                } else {
                    updateTransform();
                }
            });

            function updateTransform() {
                const transformValue = -(currentIndex * (100 / visibleItems)) + '%';
                container.style.transform = 'translateX(' + transformValue + ')';
                items.forEach((item, i) => {
                    if (i === currentIndex + 1) {
                        item.style.transform = 'scale(1.1)';
                    } else {
                        item.style.transform = 'scale(1)';
                    }
                });
            }
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('videoCarousel');
            let isDown = false;
            let startX;
            let transformAmount = 0;

            carousel.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.clientX - transformAmount;
                carousel.style.cursor = 'grabbing';
            });

            carousel.addEventListener('mouseleave', () => {
                isDown = false;
                carousel.style.cursor = 'grab';
            });

            carousel.addEventListener('mouseup', () => {
                isDown = false;
                carousel.style.cursor = 'grab';
            });

            carousel.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.clientX;
                transformAmount = x - startX;
                carousel.style.transform = `translateX(${transformAmount}px)`;
            });
        });
    </script>
@endsection