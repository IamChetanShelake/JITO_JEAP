@extends('website.layout.main')
@section('content')
    <script>
        function removeElementsByClass(className) {
            const elements = document.getElementsByClassName(className);
            while (elements.length > 0) {
                elements[0].parentNode.removeChild(elements[0]);
            }
        }
        setTimeout(() => {
            removeElementsByClass('decodeme');
        }, 4000);
    </script>
    {{-- <!-- Breadcrumbs-->
    <section class="breadcrumbs-custom bg-image context-dark"
        style="background-image: url({{ asset('website/images/conbni.png') }});background-repeat: no-repeat; display: flex; justify-content: center; align-items: center;">
        <div class="container" style="display: flex; justify-content: center; align-items: center;">
            <img src="{{ asset('website/images/bninmd.png') }}" alt="BNI Logo" style="display: flex;">
        </div>
    </section>
    <!--Google Map-->
    <section class="section" style="padding: 0;">
        <div class="google-map-container" data-center="Govind Nagar, Nashik, Maharashtra 422009, India" data-key="YOUR_API_KEY"
            data-zoom="15" data-icon="images/gmap_marker.png" data-icon-active="images/gmap_marker_active.png"
            data-styles='[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":60}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"lightness":30}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ef8c25"},{"lightness":40}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#b6c54c"},{"lightness":40},{"saturation":-40}]},{}]'>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d119989.42976415642!2d73.69624960475052!3d19.980389171570792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3bddeb77db3e836b%3A0x35f07b85dee5fa0!2sGovind%20Nagar%2C%20Nashik%2C%20Maharashtra%20422009!3m2!1d19.9804085!2d73.7786514!5e0!3m2!1sen!2sin!4v1727064221426!5m2!1sen!2sin"
                width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            <ul class="google-map-markers">
                <li data-location="Govind Nagar, Nashik, Maharashtra, India" data-description="Govind Nagar, Nashik"></li>
            </ul>
        </div>
    </section>

    <!--Mailform-->
    <section class="section section-lg bg-default">
        <div class="container">
            <x-session-message />
            <div class="row row-30 justify-content-center">
                <div class="col-xs-10 col-sm-9 col-md-6 col-lg-7 col-xl-8">
                    <h6>Contact with us</h6>
                    <h3>Have a question? Write a<br class="d-none d-xs-block"> message.
                    </h3>
                    <!--RD Mailform-->
                    <form class="rd-mailform rd-form" data-form-output="form-output-global" data-form-type="contact"
                        method="post" action="#">
                        <div class="row row-10 row-narrow-xs">
                            <div class="col-lg-6">
                                <div class="form-wrap">
                                    <label class="form-label" for="contact-name">Your Name</label>
                                    <input class="form-input" id="contact-name" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-wrap">
                                    <label class="form-label" for="contact-email">Email Address</label>
                                    <input class="form-input" id="contact-email" type="email" name="email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-wrap">
                                    <label class="form-label" for="contact-message">Write Message</label>
                                    <textarea class="form-input" id="contact-message" name="message"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-button">
                                    <button class="button button-lg button-primary" type="submit"
                                        data-triangle=".button-overlay"><span class="button-overlay"></span><span>Send
                                            Message</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-10 col-sm-9 col-md-6 col-lg-5 col-xl-4" style="margin-top:50px;">
                    <div class="block-address">
                        <div class="block-address-item">
                            <h5 class="block-address-title">Address</h5>
                            <p class="block-address-text">Hotel Treat, Govind Nagar,<br class="d-none d-xs-block">
                                Nashik, Maharashtra</p>
                        </div>
                        <div class="block-address-item">
                            <h5 class="block-address-title">Phone</h5>
                            <p class="block-address-text">

                                <span>Mobile:</span> +91 93222 23279
                            </p>
                        </div>
                        <div class="block-address-item">
                            <h5 class="block-address-title">Email</h5>
                            <p class="block-address-text"><a href="mailto:support@bninashik.in">support@bninashik.in</a><br>

                            </p>
                        </div>
                        <div class="block-address-item">
                            <h5 class="block-address-title">Follow</h5>
                            <ul class="list-inline list-inline-xs">
                                <li><a class="icon icon-rect icon-xs icon-white fa-instagram"
                                        href="https://www.instagram.com/bni_nasik?igsh=MTUzOHg2bHpoOHRoYw=="
                                        data-triangle=".icon-rect-overlay">
                                        <div class="icon-rect-overlay"></div>
                                    </a></li>

                                <li><a class="icon icon-rect icon-xs icon-white fa-youtube-play"
                                        href="https://youtube.com/@bni-i2x?si=79FV0_dO5H36Ld93"
                                        data-triangle=".icon-rect-overlay">
                                        <div class="icon-rect-overlay"></div>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <style>
        @media (min-width: 768px) {
            .reset-desktop-margin {
                margin-top: 300px
            }
        }
    </style>
    <section class="section reset-desktop-margin">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    {{-- <ul class="list-xl">
                            <li> --}}

                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <a href="{{ route('index') }}"><i class='fas fa-angle-left'
                                style='font-size:43px;color:#E31E25'></i></a>
                        <span style="color: #FFD800;">contact</span> <span style="color: #393186;">us</span>

                    </h2>
                    {{-- </li>
                        </ul> --}}
                </div>

            </div>
    
        </div>
    </section>


    {{-- <section style="position: relative; background-color: #f1f0f0; padding: 60px 20px; display: flex; justify-content: center;">
            <div style="position: relative; max-width: 100%; width: 1200px; display: flex; justify-content: center;">

                <!-- Get in Touch Form -->
                <div style="width: 880px; height: 520px; background-color: white; padding: 40px 30px; border-radius: 10px;
                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); position: relative; z-index: 1;padding-left: 180px;">
                    <h3 style="margin-bottom: 10px; font-weight: 600; font-size: 24px; color: #333;">Get In Touch</h3>
                    <p style="margin-bottom: 25px;">Have a question? Write a message.</p>

                    <input type="text" placeholder="Your name" style="width: 100%; padding: 15px; margin-bottom: 15px;
                           border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">

                    <input type="email" placeholder="Email - ID" style="width: 100%; padding: 15px; margin-bottom: 15px;
                           border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">

                    <textarea placeholder="Type your message here" rows="5" style="width: 100%; padding: 15px;
                              border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;"></textarea>
                </div>

                <!-- Contact Us Box -->
                <div style="width: 320px; height: 400px; background-color: #393186; color: white; padding: 30px;
                            border-radius: 10px; position: absolute; left: 0px; top: 60px; z-index: 2;
                            ">
                    <h3 style="margin-bottom: 20px; font-weight: 600;">Contact us</h3>

                    <p style="margin-bottom: 15px;"><i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i>
                        njdtdvh xxbg gfscnhm<br>vgfcxfa xb xgvc
                    </p>

                    <p style="margin-bottom: 15px;"><i class="fas fa-phone-alt" style="margin-right: 10px;"></i> +91</p>

                    <p style="margin-bottom: 15px;"><i class="fas fa-envelope" style="margin-right: 10px;"></i>
                        btfs5fttt@hughubjjn
                    </p>

                    <p style="margin-top: 20px;">To know more, Follow us here!</p>

                    <div style="margin-top: 10px;">
                        <i class="fab fa-instagram" style="font-size: 20px; margin-right: 15px;"></i>
                        <i class="fab fa-youtube" style="font-size: 20px;"></i>
                    </div>
                </div>
            </div>
        </section> --}}

    <!-- Outer White Background -->
    <!-- Full white background -->
    {{-- <section style="background-color: white; padding: 60px 20px; display: flex; justify-content: center;">
        <!-- Outer grey container -->
        <div
            style="position: relative; background-color: #f1f0f0; width: 100%; max-width: 1200px; border-radius: 10px; padding: 60px 30px; display: flex; justify-content: center; padding-left: 165px;">

            <!-- Contact form box -->
            <div
                style="background-color: white; width: 100%; max-width: 850px; padding: 40px 40px 40px 210px; border-radius: 10px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); position: relative; ">
                <p style="margin-bottom: 10px; font-weight: 600; font-size: 24px; color: #525252; font-family: Poppins;">Get In Touch</p>
                <p style="margin-bottom: 25px; margin-top:5px; color: #525252;font-family: Poppins;">Have a question? Write a message.</p>

                <input type="text" placeholder="Your name"
                    style="width: 100%; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">
                <input type="email" placeholder="Email - ID"
                    style="width: 100%; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">
                <textarea placeholder="Type your message here" rows="5"
                    style="width: 100%; padding: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;"></textarea>
            </div>

            <!-- Contact Info Overlap Box -->
            <!-- Contact Info Overlap Box -->
            <div
                style="position: absolute; left: 90px; top: 50%; transform: translateY(-50%);
                width: 320px; height: 370px; background-color: #393186; color: white;
                padding: 55px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden;">

                <p style="margin-bottom: 20px; font-size: 24px; font-family: Poppins;">Contact us</p>

                <p style="margin-bottom: 15px; text-align: justify;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i>
                    njdtdvh xxbg gfscnhm<br>vgfcxfa xb xgvc
                </p>

                <p style="margin-bottom: 15px; text-align: justify;">
                    <i class="fas fa-phone-alt" style="margin-right: 10px;"></i> +91 9898989898
                </p>

                <p style="margin-bottom: 15px;text-align: justify;">
                    <i class="fas fa-envelope" style="margin-right: 10px;"></i>
                    btfs5fttt@hughubjjn
                </p>

                <p style="margin-top: 20px;text-align: center;">To know more, Follow us here!</p>

                <div style="margin-top: 10px; text-align: center;">
                    <i class="fab fa-instagram" style="font-size: 20px; margin-right: 15px;"></i>
                    <i class="fab fa-youtube" style="font-size: 20px;"></i>
                </div>
            </div>

        </div>
    </section>




    <!-- Font Awesome CDN for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection --}}


    <section style="background-color: white; padding: 60px 20px; display: flex; justify-content: center;">
        <!-- Outer grey container -->

        <div class="contact-section"
            style="position: relative; background-color: #f1f0f0; width: 100%; max-width: 1200px; border-radius: 10px; padding: 60px 30px; display: flex; justify-content: center; padding-left: 165px;">


            <!-- Contact form box -->
            <div class="form-box"
                style="background-color: white; width: 100%; max-width: 850px; padding: 40px 40px 40px 210px; border-radius: 10px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); position: relative;">

                <p style="margin-bottom: 10px; font-weight: 600; font-size: 24px; color: #525252; font-family: Poppins;">Get
                    In Touch</p>
                <p style="margin-bottom: 25px; margin-top:5px; color: #525252; font-family: Poppins;">Have a question? Write
                    a message.</p>

                <form action="" method="POST" enctype="multipart/form-data"
                    style="width: 100%;">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Your Name"
                            style="width: 100%; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">

                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email - ID"
                            style="width: 100%; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">
                    </div>
                    <div class="mb-3">
                        <textarea placeholder="Type your message here" name="message" rows="5"
                            style="width: 100%; padding: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;"></textarea>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn  px-4 py-2 "
                            style="border-radius: 10px; background-color: #393186 !important;color:#ffff;">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info Overlap Box -->
            <div class="contact-box mt-2"
                style="position: absolute; left: 90px; top: 50%; transform: translateY(-50%);
        width: 320px; height: 370px; background-color: #393186; color: white;
        padding: 55px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden;">

                <p style="margin-bottom: 20px; font-size: 24px; font-family: Poppins;margin-top:-35px;">Contact us</p>
                <p style="margin-bottom: 15px; text-align: start;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 10px;"></i>
                    JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL, Near International by Tunga Hotel, Mulgaon, Andheri
                    (East), Mumbai - 400 093.
                </p>
                <p style="margin-bottom: 15px; text-align: justify;">
                    <i class="fas fa-phone-alt" style="margin-right: 10px;"></i>+91 86559 88411
                </p>
                <p style="margin-bottom: 15px;text-align: justify;">
                    <i class="fas fa-envelope" style="margin-right: 10px;"></i>
                    support.jitojeap@jito.org
                </p>
                {{-- <p style="margin-top: 20px;text-align: center;">To know more, Follow us here!</p> --}}
                <div style="margin-top: 10px; text-align: center;">
                    <a href="https://www.instagram.com/jito_rom_zone?igsh=MW12M2F3end5c2liNA==" target="blank"><i
                            class="fab fa-instagram" style="font-size: 20px; margin-right: 15px;color:#ffff;"></i></a>
                    <a href="https://youtube.com/@jitoromzone3554?si=95bNmKyQ1wvaxi0V" target="blank"> <i
                            class="fab fa-youtube" style="font-size: 20px;color:#ffff;"></i></a>
                </div>
            </div>
        </div>
    </section>


    {{--  <form action="" method="post" style="display: flex; flex-direction: column; gap: 20px;">

                    <input type="text" placeholder="Your name"
                        style="width: 100%; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">
                    <input type="email" placeholder="Email - ID"
                        style="width: 100%; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;">
                    <textarea placeholder="Type your message here" rows="5"
                        style="width: 100%; padding: 15px; border-radius: 6px; border: none; background-color: #f1f1f1; font-size: 16px;"></textarea>
                          <button type="submit" class="btn  px-4 py-2 mb-2"
                        style="border-radius: 10px; display: none;background-color: #393186 !important;color:#ffff;">
                        Submit
                    </button>

                </form>  --}}
    <style>
        @media (max-width: 768px) {
            .contact-section {
                flex-direction: column !important;
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .contact-box {
                position: static !important;
                transform: none !important;
                margin-bottom: 20px;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            .form-box {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
@endsection
