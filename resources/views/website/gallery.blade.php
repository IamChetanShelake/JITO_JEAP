@extends('website.layout.main')
@section('content')
    <style>
        .image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-item {
            position: relative;
            overflow: hidden;
            height: 250px;
            margin-bottom: 15px;
        }
        .gallery-item img {
            transition: transform 0.3s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
    </style>
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container page-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="heading-line">
                        <!-- <div class="accent-bar"></div> -->
                        <div class="headline">
                            <h1><span class="yellow">PHOTO</span> <span class="purple">GALLERY</span></h1>
                        </div>
                    </div>

                    @if($photoGalleries && count($photoGalleries) > 0)
                        <div class="row">
                            @foreach($photoGalleries as $gallery)
                                @php
                                    $images = $gallery->images;
                                    if (is_string($images)) {
                                        $images = json_decode($images, true);
                                    }
                                    $images = $images ?? [];
                                @endphp
                                @foreach($images as $img)
                                    @php
                                        $imgPath = public_path($img);
                                    @endphp
                                    @if(file_exists($imgPath))
                                        <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="gallery-item">
                                                <img src="{{ asset($img) }}" class="image" alt="Gallery Image">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-3 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_1.png') }}" class="image" alt="">
                            </div>
                            <div class="col-lg-5 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_2.png') }}" class="image" alt="">
                            </div>
                            <div class="col-lg-4 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_3.png') }}" class="image" alt="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_4.png') }}" class="image" alt="">
                            </div>
                            <div class="col-lg-4 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_5.png') }}" class="image" alt="">

                            </div>
                            <div class="col-lg-3 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_2.png') }}" class="image" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_3.png') }}" class="image" alt="">
                            </div>
                            <div class="col-lg-3 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_4.png') }}" class="image" alt="">

                            </div>
                            <div class="col-lg-5 col-md-6  col-sm-12 col-12">
                                <img src="{{ asset('website/images/gallery_img_5.png') }}" class="image" alt="">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
