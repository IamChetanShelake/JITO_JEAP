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
                        <span style="color: #FFD800;">Terms</span> <span style="color: #393186;">& Conditions</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms & Conditions Section -->
    <section style="padding: 60px 0; background-color: #f4f4f4;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div style="background-color: #ffffff; padding: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <h2 style="font-family: 'Times New Roman', Times, serif; font-weight: bold; font-size: 32px; margin-bottom: 10px;">
                            <span style="color: #FFD800;">Terms</span> <span style="color: #393186;">& Conditions</span>
                        </h2>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            <strong>Effective Date:</strong> {{ date('F j, Y') }}
                        </p>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            Welcome to <strong>JITO JEAP (jitojeap.in)</strong>. By accessing or using our website, you agree to the following terms:
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">1. Acceptance of Terms</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            By using this website, you agree to comply with these Terms & Conditions.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">2. Use of Website</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            You agree:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>Not to misuse the website</li>
                            <li>Not to engage in illegal activities</li>
                            <li>Not to attempt unauthorized access</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">3. User Accounts</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            If you create an account:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>You are responsible for maintaining confidentiality</li>
                            <li>You must provide accurate information</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">4. Intellectual Property</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            All content on this website (text, logos, graphics) is owned by JITO JEAP and protected by applicable laws. Unauthorized use is prohibited.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">5. Limitation of Liability</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 20px;">
                            We are not responsible for:
                        </p>
                        <ul style="font-size: 15px; color: #5B5B5B; line-height: 1.8; margin-bottom: 30px; padding-left: 20px;">
                            <li>Any indirect or consequential damages</li>
                            <li>Errors or interruptions in service</li>
                        </ul>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">6. Third-Party Services</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            We may use third-party services. We are not responsible for their actions or policies.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">7. Termination</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            We reserve the right to suspend or terminate access to users who violate these terms.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">8. Changes to Terms</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            We may update these terms at any time. Continued use means acceptance of updated terms.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">9. Governing Law</h4>
                        <p style="font-size: 15px; color: #5B5B5B; line-height: 1.6; margin-bottom: 30px;">
                            These terms are governed by the laws of India.
                        </p>

                        <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #393186; margin-bottom: 20px; margin-top: 30px;">10. Contact Information</h4>
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
