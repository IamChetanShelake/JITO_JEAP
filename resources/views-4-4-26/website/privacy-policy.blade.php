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
                        <span style="color: #FFD800;">Privacy</span> <span style="color: #393186;">Policy</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Policy Section -->
    <section style="padding: 60px 0; background-color: #f4f4f4;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div style="background-color: #ffffff; padding: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold; font-size: 32px; margin-bottom: 10px;">
                            <span style="color: #FFD800;">Privacy</span> <span style="color: #393186;">Policy</span>
                        </h2>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            <strong>Effective Date:</strong> {{ date('F j, Y') }}
                        </p>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            Welcome to <strong>JITO JEAP (jitojeap.in)</strong>. We respect your privacy and are committed to protecting your personal information.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">1. Information We Collect</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            We may collect the following types of information:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>Personal Information (Name, Email Address, Phone Number, etc.)</li>
                            <li>Login or account details (if applicable)</li>
                            <li>Technical data (IP address, browser type, device info)</li>
                            <li>Usage data (pages visited, time spent on website)</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">2. How We Use Your Information</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            We use your information to:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>Provide and manage our services</li>
                            <li>Improve user experience</li>
                            <li>Communicate with users (updates, notifications)</li>
                            <li>Ensure security and prevent fraud</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">3. Sharing of Information</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            We do not sell your personal information. However, we may share data:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>With service providers (hosting, analytics, etc.)</li>
                            <li>When required by law or legal authorities</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">4. Cookies</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            Our website may use cookies to enhance your experience. You can disable cookies through your browser settings.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">5. Data Security</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            We implement reasonable security measures to protect your data, but no system is 100% secure.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">6. Third-Party Links</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            Our website may contain links to external sites. We are not responsible for their privacy practices.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">7. Your Rights</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            You have the right to:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>Access your data</li>
                            <li>Request correction or deletion</li>
                            <li>Withdraw consent</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">8. Changes to Privacy Policy</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            We may update this policy from time to time. Changes will be posted on this page.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">9. Contact Us</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            If you have any questions, contact us at:
                        </p>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 10px;">
                            <strong>Email:</strong> support.jitojeap@jito.org
                        </p>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            <strong>Phone:</strong> +91 86559 88411
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
