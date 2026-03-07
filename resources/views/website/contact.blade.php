@extends('website.layout.main')

@section('content')
    <style>
        /* Adjusting margin for header */
        @media (min-width: 768px) {
            .reset-desktop-margin {
                margin-top: 300px;
            }
        }
    </style>

    <section class="section reset-desktop-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <a href="{{ route('index') }}"><i class='fas fa-angle-left' style='font-size:43px;color:#E31E25'></i></a>
                        <span style="color: #FFD800;">contact</span> <span style="color: #393186;">us</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section style="padding: 60px 0; background-color: #f4f4f4;">
        <div class="container">
            <div class="row no-gutters" style="box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                
                <!-- Left Side: Contact Info (White Background) -->
                <div class="col-lg-5" style="background-color: #ffffff; padding: 50px;">
                    <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold; font-size: 32px; margin-bottom: 10px;">
                        <span style="color: #FFD800;">CONTACT</span> <span style="color: #393186;">US</span>
                    </h2>
                    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px;">Get In Touch With Us</h4>
                    
                    <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                        Welcome to JEAP! We are here to assist you with any questions, concerns, or feedback you may have. Whether you need help with the application process or want to learn more about our programs, our team is ready to support you.
                    </p>

                    <div style="margin-bottom: 20px;">
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 16px; display: flex; align-items: center;">
                            <i class="fas fa-map-marker-alt" style="color: #FFD800; margin-right: 15px; font-size: 18px;"></i>
                            Location
                        </h5>
                        <p style="margin-left: 33px; color: #5B5B5B; font-size: 14px; line-height: 1.5;">
                            JITO HOUSE, Plot No. A-56, Road No. 1, MIDC MAROL, Near International by Tunga Hotel, Mulgaon, Andheri (East), Mumbai - 400 093.
                        </p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 16px; display: flex; align-items: center;">
                            <i class="fas fa-envelope" style="color: #FFD800; margin-right: 15px; font-size: 18px;"></i>
                            Email
                        </h5>
                        <p style="margin-left: 33px; color: #5B5B5B; font-size: 14px;">
                            <a href="mailto:support.jitojeap@jito.org" style="color: #5B5B5B; text-decoration: none;">support.jitojeap@jito.org</a><br>
                            <a href="mailto:grievance.jitojeap@jito.org" style="color: #5B5B5B; text-decoration: none;">grievance.jitojeap@jito.org</a>
                        </p>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #333; font-size: 16px; display: flex; align-items: center;">
                            <i class="fas fa-clock" style="color: #FFD800; margin-right: 15px; font-size: 18px;"></i>
                            Business Hours
                        </h5>
                        <p style="margin-left: 33px; color: #5B5B5B; font-size: 14px;">
                            MON - Fri 9 Am - 5 Pm
                        </p>
                    </div>
                </div>

                <!-- Right Side: Contact Form (Purple Background) -->
                <div class="col-lg-7" style="background-color: #393186; padding: 50px;">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Name" required
                                    style="background-color: #ffffff; border: none; border-radius: 0; padding: 15px; font-size: 14px; color: #333;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" required
                                    style="background-color: #ffffff; border: none; border-radius: 0; padding: 15px; font-size: 14px; color: #333;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="tel" name="phone" class="form-control" placeholder="Phone"
                                    style="background-color: #ffffff; border: none; border-radius: 0; padding: 15px; font-size: 14px; color: #333;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="subject" class="form-control" placeholder="Subject"
                                    style="background-color: #ffffff; border: none; border-radius: 0; padding: 15px; font-size: 14px; color: #333;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="5" placeholder="Message" required
                                style="background-color: #ffffff; border: none; border-radius: 0; padding: 15px; font-size: 14px; color: #333; resize: none;"></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn" style="background-color: #FFD800; color: #393186; padding: 12px 40px; font-weight: 600; border-radius: 0; border: none; font-size: 16px;">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section style="padding: 0 0 80px 0; background-color: #f4f4f4;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.989692387584!2d72.87641691490113!3d19.11339198708933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6306644edc1%3A0x5b3ed4ee8b16a4c6!2sJITO%20HOUSE!5e0!3m2!1sen!2sin!4v1645432000000!5m2!1sen!2sin" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Font Awesome CDN (Ensure this is in your head or layout, adding here just in case) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection