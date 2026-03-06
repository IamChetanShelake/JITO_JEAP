@extends('website.layout.main')
@section('content')
    <style>
        .image {
            width: 100%;
            height: 100%;
        }
    </style>
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container page-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="heading-line">
                        <div class="accent-bar"></div>
                        <div class="headline">
                            <h1><span class="yellow">PHOTO</span> <span class="purple">GALLERY</span></h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery1.png') }}" class="image" alt="">
                        </div>
                        <div class="col-lg-5 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery2.png') }}" class="image" alt="">
                        </div>
                        <div class="col-lg-4 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery3.png') }}" class="image" alt="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery2.png') }}" class="image" alt="">
                        </div>
                        <div class="col-lg-4 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery3.png') }}" class="image" alt="">

                        </div>
                        <div class="col-lg-3 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery1.png') }}" class="image" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery3.png') }}" class="image" alt="">
                        </div>
                        <div class="col-lg-3 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery1.png') }}" class="image" alt="">

                        </div>
                        <div class="col-lg-5 col-md-6  col-sm-12 col-12">
                            <img src="{{ asset('Images/gallery2.png') }}" class="image" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
