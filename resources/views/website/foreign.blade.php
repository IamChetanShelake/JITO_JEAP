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
    </style>
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;        max-width: 1400px;">

            .

            <!-- Header and Search Bar Row -->
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 gap-lg-0 mb-4 mt-0"
                style="margin-top:-40px !important;">
                <!-- Header -->
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Foreign</span> <span style="color: #393186;">(25 qs)</span>
                    </h2>
                </div>

                <!-- Search Bar -->
                <div style="min-width: 300px; max-width: 400px;width: 100%;">
                    <div style="position: relative;">
                        <input type="text" placeholder="Search..."
                            style="width: 100%; padding: 12px 45px 12px 15px; border: 2px solid #1a237e; border-radius: 15px; font-family: 'Poppins'; font-size: 16px; outline: none; background-color: #ffffff;">
                        <i class="fas fa-search"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #1a237e; font-size: 18px;"></i>
                    </div>
                </div>
            </div>


            <div class="row  " style="margin-top:0px;">



                <div class="col-12 ">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px; border-right: 4px solid white;">
                                        Sr.No</th>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px; border-right: 4px solid white;">
                                        Name</th>
                                    <th
                                        style="background-color: #393186; color: white; padding: 12px; text-align: left; font-family: 'Poppins'; font-weight: 500; font-size: 16px;">
                                        State</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        1</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        John Doe</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Maharashtra</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        2</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Jane Smith</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Delhi</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        3</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Bob Johnson</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Karnataka</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        1</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        John Doe</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Maharashtra</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        2</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Jane Smith</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Delhi</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        3</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Bob Johnson</td>
                                    <td
                                        style="padding: 12px; border-left: none; border-right: none; border-bottom: 1px solid #ddd; font-family: 'Poppins'; font-size: 14px;">
                                        Karnataka</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
