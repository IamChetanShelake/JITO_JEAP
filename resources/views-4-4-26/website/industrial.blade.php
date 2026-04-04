@extends('website.layout.main')
@section('content')
<!-- Breadcrumbs-->
<section class="breadcrumbs-custom bg-image context-dark"
    style="background-image: url({{ asset('website/images/Industrial_Connect_pg.png')}});background-repeat: no-repeat; display: flex; justify-content: center; align-items: center;">
    <div class="container" style="display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('website/images/BNI_2024_Logo.png')}}" alt="BNI Logo" style="display: flex;">
    </div>
</section>
<!--Base typography-->
<section class="section section-lg bg-default">
    <div class="container">
        <div class="row row-50">
            <div class="col-xl-12">
                <ul class="list-xl">
                    <li style="margin-bottom: 0;">
                        <h4
                            style="font-size: 25px; width: auto; font-family: Poppins; color: #1f1f1f;; margin-left: 10px; display: inline-flex; align-items: center; margin-bottom: 5px;">
                            <span
                                style="display: inline-flex; justify-content: center; align-items: center; width: 40px; height: 40px; border: 1px solid black; border-radius: 50%; text-align: center; margin-right: 10px;">
                                <i class="fa fa-arrow-left fa-light" style="font-size: 25px; color: #1f1f1f;"></i>
                            </span>
                            Industrial Connect
                        </h4>
                        <div class="list-container">
                            <ol>
                                <li
                                    style="display: flex; align-items: center; justify-content: center; margin-left: 100px; color: #1f1f1f; margin-top: 10px;">
                                    <img src="{{ asset('website/images/alert_1.png') }}" alt="alert"
                                        style="margin-right: 5px;"> <!-- Add margin for spacing -->
                                    <b>Tip: You can only book one Industrial Connect session at a time. Make sure to
                                        choose your slot wisely!</b>
                                </li>
                            </ol>
                        </div>
                        {{-- <p style="text-align: center; margin-left: 100px;color: #1f1f1f;">Tip: You can only book
                            one
                            Industrial Connect session at a time. Make sure to choose your slot wisely!</p> --}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<!-- Section Gold Sponsors-->
<section class="section section-lg bg-default text-center" style="margin-top:-60px">
    <div class="container">
        {{-- <h4>Gold Sponsors.</h4> --}}
        <div class="row row-30 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_47.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_48.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_49.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_50.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-30 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_47.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_48.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_49.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_50.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-30 justify-content-left">
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_47.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <!-- Sponsor Modern-->
                <div class="sponsor-ritmo">
                    <div class="news-img">
                        <a><img src="{{ asset('website/images/Rectangle_48.png')}}" alt="" width="370"
                                height="284" /></a>
                    </div>
                    <div class="sponsor-ritmo-body"
                        style="margin-top:-20px; display: flex; flex-direction: column; align-items: center;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Company Name:</span> <b style="margin-left: 7px;">ABC Company</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Name: </span><b style="margin-left: 75px;">Mr. Jia</b>
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Designation:</span>
                                <b style="margin-left: 33px;">CEO</b> <!-- Adjust the margin value as needed -->
                            </li>
                            <li style="color: #1f1f1f; text-align: left; white-space: nowrap;">
                                <span>Slot: </span><b style="margin-left: 88px;"> 40</b>
                            </li>
                            <li style="color: #D11C2F; text-align: left;white-space: nowrap;">
                                <span>Remaining Slots: </span><b style="margin-left: 4px;"> 39</b>
                            </li>
                        </ul>

                        <a class="button button-secondary box-with-triangle-right wow fadeScale" href="#"
                            data-triangle=".button-overlay"
                            style="width: 250px; text-align: center; margin-bottom: -27px;">
                            <!-- Adjusted margin using media queries -->
                            <span>Register Now</span>
                            <span class="button-overlay"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section Grid Gallery-->
{{-- <section class="section section-lg bg-default text-center">
    <div class="container container-wide">
        <h4 class="font-weight-bold">Grid Gallery.</h4>
        <div class="row row-ten row-narrow row-30 row-lg-50 justify-content-center" data-lightgallery="group">
            <div class="col-sm-4 col-md-3 col-lg-2">
                <!-- Gallery Thumbnail--><a class="thumbnail"
                    href="{{ asset('website/images/logo1.png')}}images/gallery-01-original-1200x800.jpg"
                    data-lightgallery="item"><span></span><span></span><img src="{{ asset('website/images/logo1.png')}}"
                        alt="" width="298" height="343" /></a>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-2">
                <!-- Gallery Thumbnail--><a class="thumbnail" href="images/gallery-02-original-1200x800.jpg"
                    data-lightgallery="item" data-triangle=".thumbnail-overlay"><span
                        class="thumbnail-overlay"></span><span class="thumbnail-icon"></span><img
                        src="images/gallery-02-298x343.jpg" alt="" width="298" height="343" /></a>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-2">
                <!-- Gallery Thumbnail--><a class="thumbnail" href="images/gallery-03-original-1200x800.jpg"
                    data-lightgallery="item" data-triangle=".thumbnail-overlay"><span
                        class="thumbnail-overlay"></span><span class="thumbnail-icon"></span><img
                        src="images/gallery-03-298x343.jpg" alt="" width="298" height="343" /></a>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-2">
                <!-- Gallery Thumbnail--><a class="thumbnail" href="images/gallery-04-original-1200x800.jpg"
                    data-lightgallery="item" data-triangle=".thumbnail-overlay"><span
                        class="thumbnail-overlay"></span><span class="thumbnail-icon"></span><img
                        src="images/gallery-04-298x343.jpg" alt="" width="298" height="343" /></a>
            </div>
            <div class="col-sm-4 col-md-3 col-lg-2">
                <!-- Gallery Thumbnail--><a class="thumbnail" href="images/gallery-05-original-1200x800.jpg"
                    data-lightgallery="item" data-triangle=".thumbnail-overlay"><span
                        class="thumbnail-overlay"></span><span class="thumbnail-icon"></span><img
                        src="images/gallery-05-298x343.jpg" alt="" width="298" height="343" /></a>
            </div>
        </div>
    </div>
</section> --}}

@endsection