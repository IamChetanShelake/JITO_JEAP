@extends('website.layout.main')

@section('content')
    <style>
        /* Custom scrollbar for dropdown */
        .custom-dropdown-options::-webkit-scrollbar {
            width: 8px;
            padding: 5px;
        }

        .custom-dropdown-options::-webkit-scrollbar-track {
            background: #A9A9A9;
            border-radius: 4px;
        }

        .custom-dropdown-options::-webkit-scrollbar-thumb {
            background: #393186;
            border-radius: 4px;

        }

        .custom-dropdown-options::-webkit-scrollbar-thumb:hover {
            background: #2d2358;
        }

        /* Custom dropdown styling */
        .custom-dropdown-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 384px;
            min-width: 200px;
        }

        .custom-dropdown-trigger {
            appearance: none;
            width: 100%;
            background-color: #f9f9f9;
            border: 2px solid #393186;
            border-radius: 50px;
            padding: 12px 45px 12px 45px;
            font-size: 16px;
            font-family: 'Poppins';
            color: #666;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .custom-dropdown-trigger::after {
            content: '';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 12px;
            height: 8px;
            background-image: url("data:image/svg+xml,%3csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M1 1L6 6L11 1' stroke='%23393186' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            pointer-events: none;
        }

        .custom-dropdown-options {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #393186;
            /* border-radius: 15px; */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: none;
            max-height: 200px;
            overflow-y: auto;
        }

        .custom-dropdown-options.show {
            display: block;
        }

        .custom-dropdown-option {
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-family: 'Poppins';
            font-size: 14px;
            color: #666;
        }

        .custom-dropdown-option:hover {
            background-color: #f5f5f5;
        }

        .custom-dropdown-option.selected {
            background-color: #393186;
            color: white;
        }

        .dropdown-icon-container {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #393186;
            pointer-events: none;
            z-index: 10;
        }

        /* =========================================
           DONOR CARD HOVER EFFECT STYLES
           ========================================= */
        .donor-card {
            transition: all 0.3s ease; /* Smooth transition for background and border */
        }

        /* Hover State for Card */
        .donor-card:hover {
            background-color: #393186 !important; /* Blue Background */
            border-color: #393186 !important;     /* Blue Border */
        }

        /* Name Text: Change to White on Hover */
        .donor-card:hover h3 {
            color: #ffffff !important;
        }

        /* Email Link: Change to White/Yellow on Hover */
        .donor-card:hover a {
            color: #ffffff !important; /* White looks clean, or use #FFD800 for yellow */
        }

        /* Image Border: Change to White on Hover */
        .donor-card:hover .donor-img-wrapper {
            border-color: #ffffff !important;
        }
    </style>
    
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px; max-width: 1400px;">

            <!-- About Us Section -->
            <div class="text-image-wrapper row align-items-center" style="">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <!-- <div style="width: 3px; height: 40px; background-color: #E31E25;"></div> -->
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">OUR</span> <span style="color: #393186;">DONORS</span>
                    </h2>
                </div>
                
                <div class="my-3" style="display: flex; justify-content: space-between; align-items: center; flex-direction: row; gap: 15px;">
                    <span style="font-size: 32px; color: #5B5B5B; font-weight: 400; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        Shaping Legends: The Hall of Honour
                    </span>

                    <div class="custom-dropdown-wrapper">
                        <div class="dropdown-icon-container">
                            <i class="fas fa-search" style="zoom: 1.4;"></i>
                        </div>
                        <div class="custom-dropdown-trigger" id="dropdownTrigger">
                            All Zones
                        </div>
                        <div class="custom-dropdown-options" id="dropdownOptions">
                            <div class="custom-dropdown-option" data-value="">All Zones</div>
                            <div class="custom-dropdown-option" data-value="businessman">Businessman</div>
                            <div class="custom-dropdown-option" data-value="entrepreneur">Entrepreneur</div>
                            <div class="custom-dropdown-option" data-value="philanthropist">Philanthropist</div>
                            <div class="custom-dropdown-option" data-value="industrialist">Industrialist</div>
                            <div class="custom-dropdown-option" data-value="leader">Leader</div>
                            <div class="custom-dropdown-option" data-value="doctor">Doctor</div>
                            <div class="custom-dropdown-option" data-value="engineer">Engineer</div>
                            <div class="custom-dropdown-option" data-value="teacher">Teacher</div>
                            <div class="custom-dropdown-option" data-value="artist">Artist</div>
                            <div class="custom-dropdown-option" data-value="student">Student</div>
                            <div class="custom-dropdown-option" data-value="retired">Retired</div>
                            <div class="custom-dropdown-option" data-value="other">Other</div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const trigger = document.getElementById('dropdownTrigger');
                            const options = document.getElementById('dropdownOptions');

                            // Toggle dropdown
                            trigger.addEventListener('click', function() {
                                options.classList.toggle('show');
                            });

                            // Close dropdown when clicking outside
                            document.addEventListener('click', function(event) {
                                if (!event.target.closest('.custom-dropdown-wrapper')) {
                                    options.classList.remove('show');
                                }
                            });

                            // Handle option selection
                            options.addEventListener('click', function(event) {
                                if (event.target.classList.contains('custom-dropdown-option')) {
                                    const value = event.target.getAttribute('data-value');
                                    const text = event.target.textContent;

                                    // Update trigger text
                                    trigger.textContent = text;

                                    // Remove previous selection
                                    document.querySelectorAll('.custom-dropdown-option').forEach(opt => {
                                        opt.classList.remove('selected');
                                    });

                                    // Add selected class
                                    event.target.classList.add('selected');

                                    // Close dropdown
                                    options.classList.remove('show');

                                    // Trigger change event for external listeners
                                    const customEvent = new CustomEvent('customDropdownChange', {
                                        detail: {
                                            value: value,
                                            text: text
                                        }
                                    });
                                    trigger.dispatchEvent(customEvent);
                                }
                            });
                        });
                    </script>
                </div>
                
                <div class="col-md-12 mt-4">
                    <div class="row">

                        <!-- Donor Card 1 -->
                        <div class="col-md-3 mt-4 ">
                            <!-- Added 'donor-card' class -->
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <!-- Added 'donor-img-wrapper' class -->
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn1.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Aarav prakash shah
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">p.shah369@yahoo.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 2 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn2.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Abhayakumar s. srisrimal
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">abhaya@abushaims.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 3 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn3.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Ajay sheth
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">ajay@questinvest.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 4 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn4.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Ajay sukhraj nahar
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">ajaynahar@gmail.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 5 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn5.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Ajit Tarachand Dungarwal
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">ajitdungarwal7@gmail.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 6 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn6.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Ajitkumar n. chordia
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">ajitchordia@olympiatechpark.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 7 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn7.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Akhilesh jain
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">director@atishay.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 8 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn8.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Amit bhupatraj kanter
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">amitkanter@gmail.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 9 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn9.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Amit virendrasingh banthia
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">amit@vibfast.com</a>
                            </div>
                        </div>

                        <!-- Donor Card 10 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn10.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Amit kc jain
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">amitkcjain@akcj.in</a>
                            </div>
                        </div>

                        <!-- Donor Card 11 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn11.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Anand sancheti
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">anand.sancheti@smsl.co.in</a>
                            </div>
                        </div>

                        <!-- Donor Card 12 -->
                        <div class="col-md-3 mt-4 ">
                            <div class="card donor-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px; border:1px solid #D7D7D7;">
                                <div class="donor-img-wrapper" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/dn12.png') }}" alt="Photo" style="width: 155px; height: 155px; object-fit: cover;">
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px; font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Anil bhanwarlal jain
                                </h3>
                                <a href="#" class="mt-2" style="font-size: 16px; color: #FFD800; text-decoration:underline;">anil@meridianchembond.com</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection