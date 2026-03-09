@extends('website.layout.main')

@section('content')
    <style>
        .jitoMember-item1 p {
            font-family: 'Poppins';
            font-weight: 800;
            font-size: clamp(16px, 2.67vw, 20px);
            color: #5B5B5B;
        }

        .jitoMember-item3 p {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: clamp(14px, 2.4vw, 18px);
            color: #5B5B5B;

        }


        .jitoMember-item3 ul {
            list-style-type: disc;
            padding-left: clamp(15px, 4vw, 25px);
            margin-top: 5px;
            /* important for proper bullet alignment */
        }

        .jitoMember-item3 ul li {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: clamp(14px, 2.4vw, 18px);
            color: #5B5B5B;
            padding-left: 10px;
            display: list-item !important;
            list-style-type: disc !important;
        }

        .jitoMember-item3 a {
            text-decoration: underline;
            color: #5B5B5B;
        }

        .numbering {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .numbering p {
            font-family: 'Poppins';
            font-weight: 500;
            font-size: clamp(32px, 6.4vw, 48px);
            color: white;
        }

        .jitoMember {
            padding: clamp(10px, 2vw, 15px);
        }

        @media (max-width: 768px) {
            .jitoMember p {
                padding: 8px 10px;
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
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;        max-width: 1400px;">

            <!-- About Us Section -->
            <div class="text-image-wrapper row align-items-center" style="">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12 ">
                            <!-- Text -->
                            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                                <h2
                                    style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                    <span style="color: #FFD800;">BE A </span> <span style="color: #393186;">DONOR</span>
                                </h2>
                            </div>
                            <div class="my-3" style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <span
                                    style="font-size: 32px;color: #5B5B5B; font-weight: 400; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                    Benefits
                                </span>
                            </div>

                            <!-- About Us Section -->
                            <div class="text-image-wrapper align-items-center" style="">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="row p-5 justify-content-center">

                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12 p-3"
                                                style="height: 222px;width: 268px;color:white;text-align:center;margin-bottom: 70px;">
                                                <div class="testimonial-item d-flex justify-content-center align-items-center"
                                                    style="background-color:#393186;">
                                                    <div class="row position-relative" style="padding: 15px;">
                                                        <div
                                                            class="col-12 mb-4 d-flex align-items-center justify-content-center">
                                                            <div class="testOwner position-absolute"
                                                                style="height:115px;width:115px;border-radius:50%;background-color:#FFFFFF;border-top: 58px solid #393186;display: flex;align-items: center;justify-content: center;top: -70px;">
                                                                <div class="position-absolute"
                                                                    style="height:100px;width:100px;bottom: 7px;border-radius:50%;background-color:#FFFFFF;display: flex;align-items: center;justify-content: center;">
                                                                    <img src="{{ asset('website/images/studentICon.png') }}"
                                                                        alt="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div
                                                            class="col-12 mb-2 mt-5 d-flex align-items-center justify-content-center">
                                                            <p
                                                                style="font-size:15px;font-weight:bold;font-family:Poppins;letter-spacing: 1px;">
                                                                Social Impact</p>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <p style="font-size: 12px;font-family:Poppins;">Give back to
                                                                society by supporting
                                                                the educational dreams of
                                                                students. The contribution directly impacts the lives of
                                                                aspiring Jain students.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12 p-3"
                                                style="height: 222px;width: 268px;color:white;text-align:center;margin-bottom: 70px;">
                                                <div class="testimonial-item d-flex justify-content-center align-items-center"
                                                    style="background-color:#009846;">
                                                    <div class="row position-relative" style="padding: 15px;">
                                                        <div
                                                            class="col-12 mb-4 d-flex align-items-center justify-content-center">
                                                            <div class="testOwner position-absolute"
                                                                style="height:115px;width:115px;border-radius:50%;background-color:#FFFFFF;border-top: 58px solid #009846;display: flex;align-items: center;justify-content: center;top: -70px;">
                                                                <div class="position-absolute"
                                                                    style="height:100px;width:100px;bottom: 7px;border-radius:50%;background-color:#FFFFFF;display: flex;align-items: center;justify-content: center;">
                                                                    <img src="{{ asset('website/images/BookPencilIcon.png') }}"
                                                                        alt="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div
                                                            class="col-12 mb-2 mt-5 d-flex align-items-center justify-content-center">
                                                            <p
                                                                style="font-size:15px;font-weight:bold;font-family:Poppins;letter-spacing: 1px;">
                                                                Social Impact</p>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <p style="font-size: 12px;font-family:Poppins;">Give back to
                                                                society by supporting
                                                                the educational dreams of
                                                                students. The contribution directly impacts the lives of
                                                                aspiring Jain students.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12 p-3"
                                                style="height: 222px;width: 268px;color:white;text-align:center;margin-bottom: 70px;">
                                                <div class="testimonial-item d-flex justify-content-center align-items-center"
                                                    style="background-color:#FFD800;">
                                                    <div class="row position-relative" style="padding: 15px;">
                                                        <div
                                                            class="col-12 mb-4 d-flex align-items-center justify-content-center">
                                                            <div class="testOwner position-absolute"
                                                                style="height:115px;width:115px;border-radius:50%;background-color:#FFFFFF;border-top: 58px solid #FFD800;display: flex;align-items: center;justify-content: center;top: -70px;">
                                                                <div class="position-absolute"
                                                                    style="height:100px;width:100px;bottom: 7px;border-radius:50%;background-color:#FFFFFF;display: flex;align-items: center;justify-content: center;">
                                                                    <img src="{{ asset('website/images/saveTax.png') }}"
                                                                        alt="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div
                                                            class="col-12 mb-2 mt-5 d-flex align-items-center justify-content-center">
                                                            <p
                                                                style="font-size:15px;font-weight:bold;font-family:Poppins;letter-spacing: 1px;">
                                                                Social Impact</p>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <p style="font-size: 12px;font-family:Poppins;">Give back to
                                                                society by supporting
                                                                the educational dreams of
                                                                students. The contribution directly impacts the lives of
                                                                aspiring Jain students.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12 p-3"
                                                style="height: 222px;width: 268px;color:white;text-align:center;margin-bottom: 70px;">
                                                <div class="testimonial-item d-flex justify-content-center align-items-center"
                                                    style="background-color:#E31E24;">
                                                    <div class="row position-relative" style="padding: 15px;">
                                                        <div
                                                            class="col-12 mb-4 d-flex align-items-center justify-content-center">
                                                            <div class="testOwner position-absolute"
                                                                style="height:115px;width:115px;border-radius:50%;background-color:#FFFFFF;border-top: 58px solid #E31E24;display: flex;align-items: center;justify-content: center;top: -70px;">
                                                                <div class="position-absolute"
                                                                    style="height:100px;width:100px;bottom: 7px;border-radius:50%;background-color:#FFFFFF;display: flex;align-items: center;justify-content: center;">
                                                                    <img src="{{ asset('website/images/peopleIcon.png') }}"
                                                                        alt="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div
                                                            class="col-12 mb-2 mt-5 d-flex align-items-center justify-content-center">
                                                            <p
                                                                style="font-size:15px;font-weight:bold;font-family:Poppins;letter-spacing: 1px;">
                                                                Social Impact</p>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <p style="font-size: 12px;font-family:Poppins;">Give back to
                                                                society by supporting
                                                                the educational dreams of
                                                                students. The contribution directly impacts the lives of
                                                                aspiring Jain students.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="my-3" style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <span
                                    style="font-size: 32px;color: #5B5B5B; font-weight: 400; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                    How to Become JEAP Member (Donor)
                                </span>
                            </div>

                            {{-- how to become JITO member Donor --}}
                            {{-- step 1  --}}
                            <div class="row p-3 jitoMember align-items-center">
                                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                                    <p>Obtain the membership form</p>
                                </div>
                                <div class="col-3 p-0 d-flex justify-content-center align-items-center jitoMember-item2">

                                    <div class="col-8 p-0 step-circle-container"
                                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                                        <div class="numbering"
                                            style="background-color:#393186;height:70px;width:70px;border-radius:50%;">
                                            <p>1</p>
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 ">
                                        <div class="dashedLine" style="border:3px dashed #393186;">
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 align-items-center endDot">
                                        <div
                                            style="height: 15px;width: 15px;border-radius: 50%;background-color: #393186;">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-5 p-0 d-flex justify-content-center jitoMember-item3">
                                    <p>Student have to go to google & search - <a href="https://jitojeap.in"
                                            target="_blank">https://jitojeap.in</a> </p>
                                </div>
                            </div>
                            {{-- step 2  --}}
                            <div class="row p-3 jitoMember align-items-center">
                                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                                    <p>Payment process</p>
                                </div>
                                <div class="col-3 p-0 d-flex justify-content-center align-items-center jitoMember-item2">

                                    <div class="col-8 p-0 step-circle-container"
                                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                                        <div class="numbering"
                                            style="background-color:#009846;height:70px;width:70px;border-radius:50%;">
                                            <p>2</p>
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 ">
                                        <div class="dashedLine" style="border:3px dashed #009846;">
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 align-items-center endDot">
                                        <div
                                            style="height: 15px;width: 15px;border-radius: 50%;background-color: #009846;">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-5 jitoMember-item3">
                                    <p>An individual JITO member can become a JEAP member by paying an upfront amount of Rs.
                                        54 Lakhs or Rs. 3 Lakhs at the time of application followed by instalments:
                                    </p>
                                    <ul>
                                        <li> 1st Installment of Rs. 17 Lacs within the 1st year.</li>
                                        <li>2nd Installment of Rs. 17 Lacs within the 2nd year.</li>
                                        <li>3rd Installment of Rs. 17 Lacs within the 3rd year. </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- step 3 --}}
                            <div class="row p-3 jitoMember align-items-center">
                                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                                    <p>Share transaction details</p>
                                </div>
                                <div class="col-3 p-0 d-flex justify-content-center align-items-center jitoMember-item2">

                                    <div class="col-8 p-0 step-circle-container"
                                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                                        <div class="numbering"
                                            style="background-color:#FFD800;height:70px;width:70px;border-radius:50%;">
                                            <p>3</p>
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 ">
                                        <div class="dashedLine" style="border:3px dashed #FFD800;">
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 align-items-center endDot">
                                        <div
                                            style="height: 15px;width: 15px;border-radius: 50%;background-color: #FFD800;">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-5 jitoMember-item3">
                                    <p>After making the payment, share the transaction details with JEAP for record-keeping.
                                    </p>

                                </div>
                            </div>

                            {{-- step 4  --}}
                            <div class="row p-3 jitoMember align-items-center">
                                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                                    <p>Submission of Membership form with required Documents</p>
                                </div>
                                <div class="col-3 p-0 d-flex justify-content-center align-items-center jitoMember-item2">

                                    <div class="col-8 p-0 step-circle-container"
                                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                                        <div class="numbering"
                                            style="background-color:#E31E24;height:70px;width:70px;border-radius:50%;">
                                            <p>4</p>
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 ">
                                        <div class="dashedLine" style="border:3px dashed #E31E24;">
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 align-items-center endDot">
                                        <div
                                            style="height: 15px;width: 15px;border-radius: 50%;background-color: #E31E24;">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-5 jitoMember-item3">
                                    <p>Send the completed form and necessary documents to the JEAP office.
                                    </p>

                                </div>
                            </div>
                            {{-- step 5  --}}
                            <div class="row p-3 jitoMember align-items-center">
                                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                                    <p>Confirmation and Receipt</p>
                                </div>
                                <div class="col-3 p-0 d-flex justify-content-center align-items-center jitoMember-item2">

                                    <div class="col-8 p-0 step-circle-container"
                                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                                        <div class="numbering"
                                            style="background-color:#393186;height:70px;width:70px;border-radius:50%;">
                                            <p>5</p>
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 ">
                                        <div class="dashedLine" style="border:3px dashed #393186;">
                                        </div>
                                    </div>
                                    <div class="col-2 p-0 align-items-center endDot">
                                        <div
                                            style="height: 15px;width: 15px;border-radius: 50%;background-color: #393186;">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-5 jitoMember-item3">
                                    <p>Upon receipt of payment, a receipt will be issued, and your membership will be
                                        officially in process.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
