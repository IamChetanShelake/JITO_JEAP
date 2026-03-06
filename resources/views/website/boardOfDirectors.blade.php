@extends('website.layout.main')

@section('content')
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;        max-width: 1400px;">

            <!-- About Us Section -->
            <div class="text-image-wrapper row align-items-center" style="">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">BOARD</span> <span style="color: #393186;">OF
                            DIRECTORS</span>
                    </h2>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="row">

                        {{-- <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/wc11.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Hitesh Doshi
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Chairman
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">hiteshdoshi@waaree.com</a>
                            </div>

                        </div> --}}
                        {{-- <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/wc11.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Hitesh Doshi
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Designation 1
                                </p>
                                <a href="#" style="font-size: 16px;  color: #FFD800; text-decoration:underline;">Show
                                    more</a>
                            </div>

                        </div> --}}
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d001.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Hitesh Doshi
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Chairman
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">hiteshdoshi@waaree.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d002.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Mahaveer Singh Choudhary
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Vice Chairman
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">navkarassociates@yahoo.in</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d003.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Dr.Bipin Doshi
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Vice Chairman
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">drbipindoshi@yahoo.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d004.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    CA Satish Hiran
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Chief Secretary
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">casatishhiran@gmail.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d005.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Siddharth Bhansali
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Secretary
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">bhansalisiddharth@gmail.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d006.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Dilip Nabera
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Treasurer
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">adhunik_finance@yahoo.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d007.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Ashok M. Katariya
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">ashok.katariya@ashokabuildcon.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d008.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    CA Satish Hiran
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Chief Secretary

                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">casatishhiran@gmail.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d009.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Hemant Jain
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">hj@kljindia.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d010.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Joitkumar B. Jain
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">md@cenzer.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d011.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Kamlesh Jain
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">kamlesh@jainmetalgroup.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d012.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Nilesh Jain
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">canileshjain@gmail.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d013.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Om Jain
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">omjain@gmail.com</a>
                            </div>

                        </div>
                        <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d015.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Sunil Kathotia
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Director
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">sunil@frontier.in.net</a>
                            </div>

                        </div>
                        {{-- <div class="col-md-3 mt-4 ">

                            <div class="card"
                                style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <div
                                    style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    <img src="{{ asset('website/images/d001.png') }}" alt="Photo"
                                        style="width: 100%; height: 106%; object-fit: cover;">
                                </div>
                                <h3
                                    style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    Hitesh Doshi
                                </h3>
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 500; margin-bottom: -4px;">
                                    Designation 1
                                </p>
                                <a href="#"
                                    style="font-size: 16px;  color: #FFD800; text-decoration:underline;">Show
                                    more</a>
                            </div>

                        </div> --}}




                    </div>

                </div>


            </div>

        </div>
    </section>
@endsection
