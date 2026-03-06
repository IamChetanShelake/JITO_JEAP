@extends('website.layout.main')

@section('content')
    <style>
        .jitoMember-item1 p {
            font-family: 'Poppins';
            font-weight: 400;
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


            <!-- Header -->
            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px; margin-bottom: 30px;">
                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                    <span style="color: #FFD800;">How</span> <span style="color: #393186;">To Apply</span>
                </h2>
            </div>

            <p style="font-family:'Poppins';font-size:28px;font-weight:400;color:#5B5B5B;">Process of
                Financial Assistance Application</p>
            <p style="font-family:'Poppins';">
                1. Meritorious, deserving, and financially needy Jain student residing in India.
            </p>
            <p style="font-family:'Poppins';">
                2. The applicant must be between 18 and 30 years of age, having completed HSC or a Diploma,
                with a minimum of 60% overall academic score.
            </p>
            <p style="font-family:'Poppins';">
                3. The applicant must log in and register on the official website to complete and submit the
                application form: www.jitojeap.in
            </p>

            {{-- step 1  --}}
            <div class="row p-3 jitoMember align-items-center">
                <div class="col-4 ">

                </div>
                <div class="col-4 p-0 d-flex justify-content-center align-items-center jitoMember-item2">
                    <div class="col-3">

                    </div>
                    <div class="col-6 p-0 step-circle-container"
                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                        <div class="numbering" style="background-color:#393186;height:70px;width:70px;border-radius:50%;">
                            <p>1</p>
                        </div>
                    </div>
                    <div class="col-2 p-0 ">
                        <div class="dashedLine" style="border:3px dashed #393186;">
                        </div>
                    </div>
                    <div class="col-1 p-0 align-items-center endDot">
                        <div style="height: 15px;width: 15px;border-radius: 50%;background-color: #393186;">
                        </div>
                    </div>

                </div>
                <div class="col-4 p-0 d-flex justify-content-center jitoMember-item3">
                    <p>Student have to go to google & search - <a href="https://jitojeap.in"
                            target="_blank">https://jitojeap.in</a> </p>
                </div>
            </div>
            {{-- step 2  --}}
            <div class="row p-3 jitoMember align-items-center">
                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                    <p>Explore website for understanding what actually JEAP does</p>
                </div>
                <div class="col-4  p-0 d-flex justify-content-center align-items-center jitoMember-item2">
                    <div class="col-1 p-0 d-flex justify-content-end align-items-center endDot">
                        <div style="height: 15px;width: 15px;border-radius: 50%;background-color: #009846;">
                        </div>
                    </div>
                    <div class="col-2 p-0 ">
                        <div class="dashedLine" style="border:3px dashed #009846;">
                        </div>
                    </div>

                    <div class="col-6 p-0 step-circle-container"
                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                        <div class="numbering" style="background-color:#009846;height:70px;width:70px;border-radius:50%;">
                            <p>2</p>
                        </div>
                    </div>
                    <div class="col-3"></div>

                </div>
                <div class="col-4 jitoMember-item3">

                </div>
            </div>
            {{-- step 3 --}}
            <div class="row p-3 jitoMember align-items-center">
                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">

                </div>
                <div class="col-4 p-0 d-flex justify-content-center align-items-center jitoMember-item2">
                    <div class="col-3"></div>
                    <div class="col-6 p-0 step-circle-container"
                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                        <div class="numbering" style="background-color:#FFD800;height:70px;width:70px;border-radius:50%;">
                            <p>3</p>
                        </div>
                    </div>
                    <div class="col-2 p-0 ">
                        <div class="dashedLine" style="border:3px dashed #FFD800;">
                        </div>
                    </div>
                    <div class="col-1 p-0 align-items-center endDot">
                        <div style="height: 15px;width: 15px;border-radius: 50%;background-color: #FFD800;">
                        </div>
                    </div>

                </div>
                <div class="col-4 jitoMember-item3">
                    <p>Who can apply for the Financial Assistance from JEAP?
                        Click the link for FAQ's section. FAQ's
                    </p>

                </div>
            </div>

            {{-- step 4  --}}
            <div class="row p-3 jitoMember align-items-center">
                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">
                    <p>You'll find List of documents according to the Financial Assistance you want to appear for i.e
                        Foreign or Domestic</p>
                </div>
                <div class="col-4 p-0 d-flex justify-content-center align-items-center jitoMember-item2">
                    <div class="col-1 p-0 d-flex justify-content-end align-items-center endDot">
                        <div style="height: 15px;width: 15px;border-radius: 50%;background-color: #E31E24;">
                        </div>
                    </div>
                    <div class="col-2 p-0 ">
                        <div class="dashedLine" style="border:3px dashed #E31E24;">
                        </div>
                    </div>
                    <div class="col-6 p-0 step-circle-container"
                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                        <div class="numbering" style="background-color:#E31E24;height:70px;width:70px;border-radius:50%;">
                            <p>4</p>
                        </div>
                    </div>
                    <div class="col-3"></div>


                </div>
                <div class="col-4 jitoMember-item3">
                    <p>Send the completed form and necessary documents to the JEAP office.
                    </p>

                </div>
            </div>
            {{-- step 5  --}}
            <div class="row p-3 jitoMember align-items-center">
                <div class="col-4 p-0 d-flex justify-content-start jitoMember-item1">

                </div>
                <div class="col-4 p-0 d-flex justify-content-center align-items-center jitoMember-item2">
                    <div class="col-3"></div>

                    <div class="col-6 p-0 step-circle-container"
                        style="background-color:white;height:80px;max-width:80px;border-radius:50%;box-shadow:0px 1px 10px 0px rgba(0, 0, 0, 0.1);display:flex;justify-content:center;align-items:center;">
                        <div class="numbering" style="background-color:#393186;height:70px;width:70px;border-radius:50%;">
                            <p>5</p>
                        </div>
                    </div>
                    <div class="col-2 p-0 ">
                        <div class="dashedLine" style="border:3px dashed #393186;">
                        </div>
                    </div>
                    <div class="col-1 p-0 align-items-center endDot">
                        <div style="height: 15px;width: 15px;border-radius: 50%;background-color: #393186;">
                        </div>
                    </div>

                </div>
                <div class="col-4 jitoMember-item3">
                    <p>Go through the list of Documents and keep ready all the documents before you start filling the
                        application
                    </p>

                </div>
            </div>

        </div>
    </section>
@endsection
