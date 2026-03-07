@extends('website.layout.main')

@section('content')
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;        max-width: 1400px;">

            <!-- About Us Section -->
            <div class="text-image-wrapper row align-items-center" style="">
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="row">
                        <div class="col-12">

                            <!-- Text -->
                            <div style="flex: 1 1 50%; max-width: 700px;">
                                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                                    <h2
                                        style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                        <span style="color: #FFD800;">About</span> <span style="color: #393186;">Us</span>
                                    </h2>
                                </div>
                                <div class="my-3"
                                    style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                    <span
                                        style="font-size: 32px;color: #5B5B5B; font-weight: 400; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                        JITO at Glance
                                    </span>
                                </div>
                                <p
                                    style="font-size: 18px; line-height: 1.6; margin-top: 20px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                    JITO is a global organisation of entrepreneurs, industrialists, professionals, and
                                    knowledge
                                    leaders, committed to upholding the legacy of ethical and responsible business
                                    practices.
                                    <br><br>
                                    With a worldwide footprint, JITO is dedicated to fostering socio-economic empowerment,
                                    promoting
                                    value-based education, advancing community welfare, inspiring compassion, strengthening
                                    global
                                    harmony, and contributing to the spiritual enrichment of society.
                                </p>


                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div id="cardContainer"
                                style="display: flex; justify-content: center; gap: 10px; flex-wrap: nowrap; width: auto;">

                                <!-- Card 1 -->
                                <a href="" style="text-decoration: none;">
                                    <div style="background-color: #393186; padding: 20px; box-shadow: 0 4px 4px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
                                        onmouseover="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
                                        <div class=""
                                            style="font-size: 30px; font-family:Poppins;font-weight:600; color: white;">
                                            78</div>
                                        <div class="label"
                                            style="font-weight: 600; font-family:Poppins;font-size: 20px; color: white;">
                                            Chapters</div>
                                    </div>
                                </a>
                                <a href="" style="text-decoration: none;">
                                    <div style="background-color: #393186; padding: 20px; box-shadow: 0 4px 4px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
                                        onmouseover="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
                                        <div class=""
                                            style="font-size: 30px; font-family:Poppins;font-weight:600; color: white;">
                                            9</div>
                                        <div class="label"
                                            style="font-weight: 600; font-family:Poppins;font-size: 20px; color: white;">
                                            Zones</div>
                                    </div>
                                </a>
                                <a href="" style="text-decoration: none;">
                                    <div style="background-color: #393186; padding: 20px; box-shadow: 0 4px 4px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
                                        onmouseover="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
                                        <div class=""
                                            style="font-size: 30px; font-family:Poppins;font-weight:600; color: white;">
                                            18,719+</div>
                                        <div class="label"
                                            style="font-weight: 600; font-family:Poppins;font-size: 20px; color: white;">
                                            Donors</div>
                                    </div>
                                </a>
                                <a href="" style="text-decoration: none;">
                                    <div style="background-color: #393186; padding: 20px; box-shadow: 0 4px 4px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
                                        onmouseover="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
                                        <div class=""
                                            style="font-size: 30px; font-family:Poppins;font-weight:600; color: white;">
                                            32</div>
                                        <div class="label"
                                            style="font-weight: 600; font-family:Poppins;font-size: 20px; color: white;">
                                            International</div>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-5 col-md-5 col-12">
                    <!-- Image -->
                    <div class="about-img-container" style="position: relative; flex: 1 1 45%; max-width: 500px;">
                        <img src="{{ asset('website/images/indianMap.png') }}" alt="About Us Image"
                            style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
