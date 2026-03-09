@extends('website.layout.main')

@section('content')
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;        max-width: 1400px;">

            <!-- About Us Section -->
            <div class="text-image-wrapper row align-items-center" style="">
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="row">
                        <div class="col-12 m">

                            <!-- Text -->
                            <div style="flex: 1 1 50%; max-width: 700px;">
                                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                                    <h2
                                        style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                        <span style="color: #FFD800;">About</span> <span style="color: #393186;">JEAP</span>
                                    </h2>
                                </div>
                                <div class="my-3"
                                    style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                    <span
                                        style="font-size: 32px;color: #5B5B5B; font-weight: 400; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                        Empowering Futures : Our Journey
                                    </span>
                                </div>
                                <p
                                    style="font-size: 18px; line-height: 1.6; margin-top: 20px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                    We are committed to empowering deserving, needy, and meritorious students to pursue
                                    higher education in India and abroad. Through financial assistance and essential
                                    resources, we enable them to access top-tier institutions and unlock their true
                                    potential.
                                </p>


                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="" style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <div style="width: 6px;height: 6px;border-radius: 50%; background-color: #FFD800;">
                                </div>
                                <h2 style="font-size: 18px; font-weight: bold; font-family: Poppins; margin: 0;">
                                    <span style="color: #FFD800;">VISION</span> <span style="color: #393186;">OF
                                        JEAP</span>
                                </h2>
                            </div>
                            <p
                                style="font-size: 18px; line-height: 1.6; margin-top: 20px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                Aligned with JITO’s overarching vision, JEAP (JITO Education Assistance Program) was
                                established with a dedicated focus on uplifting Jain students through quality
                                education and meaningful opportunities.
                            </p>

                        </div>
                        <div class="col-12 mt-5">
                            <div class="" style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <div style="width: 6px;height: 6px;border-radius: 50%; background-color: #FFD800;">
                                </div>
                                <h2 style="font-size: 18px; font-weight: bold; font-family: Poppins; margin: 0;">
                                    <span style="color: #FFD800;">MISSION</span> <span style="color: #393186;">OF
                                        JEAP</span>
                                </h2>
                            </div>
                            <p
                                style="font-size: 18px; line-height: 1.6; margin-top: 20px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                Aligned with JITO’s overarching vision, JEAP (JITO Education Assistance Program) was
                                established with a dedicated focus on uplifting Jain students through quality
                                education and meaningful opportunities.
                            </p>

                        </div>
                    </div>

                </div>

                <div class="col-lg-5 col-md-5 col-12">
                    <div class="row gap-5">
                        <div class="col-12">
                            <!-- Image -->
                            <div class="about-img-container" style="position: relative; flex: 1 1 45%; max-width: 500px;">
                                <div
                                    style="background-color: #FFD800; width: 80%;     border-radius: 0px 0px 0px 20px; height: 100%; position: absolute; top: -20px; right: 15px; z-index: 1;">
                                </div>
                                <!--<img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}"-->
                                <!--    alt="About Us Image"-->
                                <!--    style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">-->

                                <img src="{{ asset('website/images/about01.png') }}" alt="About Us Image"
                                    style="width: 80%;     border-radius: 0px 0px 0px 20px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">

                            </div>
                        </div>
                        <div class="col-12">
                            <!-- Image -->
                            <div class="about-img-container" style="position: relative; flex: 1 1 45%; max-width: 500px;">
                                <div
                                    style="background-color: #393186; width: 80%;     border-radius: 0px 0px 0px 20px; height: 100%; position: absolute; top: -20px; right: 15px; z-index: 1;">
                                </div>
                                <!--<img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}"-->
                                <!--    alt="About Us Image"-->
                                <!--    style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">-->

                                <img src="{{ asset('website/images/about01.png') }}" alt="About Us Image"
                                    style="width: 80%;     border-radius: 0px 0px 0px 20px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
