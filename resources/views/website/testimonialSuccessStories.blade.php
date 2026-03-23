@extends('website.layout.main')

@section('content')
    
    {{-- ============================= OUR TESTIMONIALS SECTION ============================= --}}
    <section style="padding-top: 280px; position: relative; z-index: 1; background: #fff;" class="testimonial-section">
        <style>
            .testimonial-section {
                padding-top: 280px;
                position: relative;
                z-index: 1;
                background: #fff;
            }
            @media (max-width: 991px) {
                .testimonial-section {
                    padding-top: 250px;
                }
            }
            @media (max-width: 576px) {
                .testimonial-section {
                    padding-top: 220px;
                }
            }
            
            /* Testimonial Card Hover Styles */
            .testimonial-card {
                transition: all 0.3s ease;
            }
            .testimonial-card:hover {
                background: #393186 !important;
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
                border-color: #393186 !important;
            }
            .testimonial-card:hover h5 {
                color: #FFD800 !important;
            }
            .testimonial-card:hover p {
                color: #ffffff !important;
            }
        </style>
        <div class="container mb-5">
            <div style="flex: 1 1 50%; max-width: 700px;">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">OUR</span> <span style="color: #393186;">TESTIMONIALS</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 60px 0 80px 0; background-color: #FFF9E6;">
        <div class="container">
            <div class="row justify-content-center align-items-stretch">
                
                @forelse($testimonials as $index => $testimonial)
                @php
                    $bgColors = ['#ffffff', '#393186', '#ffffff'];
                    $titleColors = ['#393186', '#FFD800', '#393186'];
                    $borderColors = ['#FFD800', '#ffffff', '#FFD800'];
                    $textColors = ['#5B5B5B', '#e0e0e0', '#5B5B5B'];
                    $nameColors = ['#333', '#fff', '#333'];
                    $dateColors = ['#999', '#ccc', '#999'];
                    $bgIndex = $index % 3;
                @endphp
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100 h-100 testimonial-card" style="background: {{ $bgColors[$bgIndex] }}; border: 1px solid #D7D7D7; border-radius: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <div style="width: 120px; height: 120px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 4px solid {{ $borderColors[$bgIndex] }};">
                            @if(!empty($testimonial->image))
                                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('website/images/t1.png') }}" alt="{{ $testimonial->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <h5 style="color: {{ $titleColors[$bgIndex] }}; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 18px;">{{ $testimonial->title ?? 'Testimonial' }}</h5>
                        <p style="color: {{ $textColors[$bgIndex] }}; font-size: 14px; margin-bottom: 20px;">{{ $testimonial->feedback }}</p>
                        <p style="color: {{ $nameColors[$bgIndex] }}; font-weight: 600; font-size: 15px; margin-bottom: 5px;">{{ $testimonial->name }}</p>
                        <p style="color: {{ $dateColors[$bgIndex] }}; font-size: 13px; margin-bottom: 0;">{{ $testimonial->date ? \Carbon\Carbon::parse($testimonial->date)->format('d M Y') : '' }}</p>
                    </div>
                </div>
                @empty
                <!-- Default fallback testimonials if none in database -->
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100 h-100" style="background: #ffffff; border: 1px solid #D7D7D7; border-radius: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <div style="width: 120px; height: 120px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 4px solid #FFD800;">
                            <img src="{{ asset('website/images/t1.png') }}" alt="Samyukta Shah" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h5 style="color: #393186; font-weight: 700; font-family: 'Poppins', sans-serif; font-size: 18px;">Life - Changing Support</h5>
                        <p style="color: #5B5B5B; font-size: 14px; margin-bottom: 20px;">JEAP's assistance helped me pursue my education without financial stress.</p>
                        <p style="color: #333; font-weight: 600; font-size: 15px; margin-bottom: 5px;">Samyukta Shah</p>
                        <p style="color: #999; font-size: 13px; margin-bottom: 0;">24 Dec 2024</p>
                    </div>
                </div>
                @endforelse

            </div>
        </div>
    </section>

    {{-- ============================= SUCCESS STORIES SECTION ============================= --}}
    
    <section style="padding: 80px 0; background: #FFF;">
        <div class="container">
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">SUCCESS</span> <span style="color: #393186;">STORIES</span>
                    </h2>
                </div>
            </div>

            {{-- Added ID 'videoCarousel' here so the script below works --}}
            <div class="row" id="videoCarousel">
                @forelse($successStories as $story)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        @if(!empty($story->image))
                            <img src="{{ asset($story->image) }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story">
                        @else
                            <img src="{{ asset('website/images/gallery_img_1.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story">
                        @endif
                    </div>
                    <div class="text-center mt-3">
                        @if(!empty($story->video_link))
                            <a href="{{ $story->video_link }}" target="_blank" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                <span style="font-size: 16px;">Watch on</span>
                                <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                                <span style="font-size: 16px;">YouTube</span>
                            </a>
                        @else
                            <span class="text-muted">No video link</span>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Default fallback if no stories in database -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_1.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 1">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Video Item 2 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_2.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 2">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Video Item 3 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_3.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 3">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>

                <!-- Video Item 4 -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_4.png') }}" style="width: 100%; height: 200px; object-fit: cover; display: block;" alt="Success Story 4">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>
                @endforelse

            </div>
        </div>
    </section>

    {{-- Script only for Video Carousel (Testimonials are static grid now) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('videoCarousel');
            
            // Only run if element exists
            if(carousel) {
                let isDown = false;
                let startX;
                let transformAmount = 0;

                carousel.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.clientX - transformAmount;
                    carousel.style.cursor = 'grabbing';
                });

                carousel.addEventListener('mouseleave', () => {
                    isDown = false;
                    carousel.style.cursor = 'grab';
                });

                carousel.addEventListener('mouseup', () => {
                    isDown = false;
                    carousel.style.cursor = 'grab';
                });

                carousel.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.clientX;
                    transformAmount = x - startX;
                    carousel.style.transform = `translateX(${transformAmount}px)`;
                });
            }
        });
    </script>
@endsection