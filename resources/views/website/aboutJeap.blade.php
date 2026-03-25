@extends('website.layout.main')

@section('content')
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="max-width: 1400px;">

            @forelse($jeapItems as $item)
            <!-- About Us Section -->
            <div class="text-image-wrapper row align-items-center mb-5">
                <!-- Left Side - Content -->
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <!-- Title -->
                            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                                <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                    <span style="color: #FFD800;">About</span> <span style="color: #393186;">JEAP</span>
                                </h2>
                            </div>
                            <!-- Admin Title -->
                            @if($item->title)
                            <h3 style="font-size: 24px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin-top: 25px; color: #393186;">
                                {{ $item->title }}
                            </h3>
                            @endif
                        </div>

                        <div class="col-12">
                            <!-- Description -->
                            <p style="font-size: 18px; line-height: 1.6; margin-top: 20px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                {!! nl2br(e($item->description)) !!}
                            </p>
                        </div>

                        <!-- Small Titles and Descriptions -->
                        @if($item->small_titles && count($item->small_titles) > 0)
                        <div class="col-12 mt-4">
                            @foreach($item->small_titles as $index => $smallTitle)
                            <div class="mb-4">
                                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                    <div style="width: 6px;height: 6px;border-radius: 50%; background-color: #FFD800;"></div>
                                    <h2 style="font-size: 18px; font-weight: bold; font-family: Poppins; margin: 0;">
                                        <span style="color: #FFD800;">{{ $smallTitle }}</span>
                                    </h2>
                                </div>
                                @if(isset($item->small_descriptions[$index]))
                                <p style="font-size: 16px; line-height: 1.6; margin-top: 15px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                    {!! nl2br(e($item->small_descriptions[$index])) !!}
                                </p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side - Image -->
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="about-img-container" style="position: relative; display: flex; flex-direction: column; align-items: center;">
                        
                        <!-- Main Image with Yellow Background -->
                        <!-- Container size accommodates the offsets -->
                        <div style="position: relative; margin-bottom: 40px; width: 410px; height: 320px;">
                            
                            <!-- Yellow Background Image (Positioned Top-Right: top: 0, left: 20px) -->
                            <img src="{{ asset('website/images/yellow.png') }}" alt="Yellow BG" 
                                style="width: 380px; height: 290px; position: absolute; top: 0; left: 20px; z-index: 1; opacity: 1;">
                            
                            <!-- Foreground Image (Shifted Down: top: 20px, left: 0) -->
                            @if($item->image)
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title ?? 'About JEAP' }}"
                                style="width: 380px; height: 290px; position: absolute; top: 20px; left: 0; z-index: 2; object-fit: cover;">
                            @else
                            <img src="{{ asset('website/images/about01.png') }}" alt="About JEAP"
                                style="width: 380px; height: 290px; position: absolute; top: 20px; left: 0; z-index: 2; object-fit: cover;">
                            @endif
                        </div>
                        
                        <!-- Additional Images with Blue Background -->
                        @if($item->images && count($item->images) > 0)
                        <div style="display: flex; flex-direction: column; gap: 40px; align-items: center;">
                            @foreach($item->images as $img)
                            <div style="position: relative; width: 410px; height: 320px;">
                                
                                <!-- Blue Background Image (Positioned Top-Right) -->
                                <img src="{{ asset('website/images/blue.png') }}" alt="Blue BG" 
                                    style="width: 380px; height: 290px; position: absolute; top: 0; left: 20px; z-index: 1; opacity: 1; border-bottom-left-radius: 20px;">
                                
                                <!-- Foreground Image (Shifted Down) -->
                                <img src="{{ asset($img) }}" alt="JEAP Image"
                                    style="width: 380px; height: 290px; position: absolute; top: 20px; left: 0; z-index: 2; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <!-- Default content when no data -->
            <div class="text-image-wrapper row align-items-center">
                <div class="col-lg-7 col-md-7 col-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                                <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                                    <span style="color: #FFD800;">About</span> <span style="color: #393186;">JEAP</span>
                                </h2>
                            </div>
                        </div>
                        <div class="col-12">
                            <p style="font-size: 18px; line-height: 1.6; margin-top: 20px; font-family: Poppins; color: #5B5B5B; text-align: justify;">
                                We are committed to empowering deserving, needy, and meritorious students to pursue higher education in India and abroad. Through financial assistance and essential resources, we enable them to access top-tier institutions and unlock their true potential.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-12">
                    <div class="about-img-container" style="position: relative; display: flex; flex-direction: column; align-items: center;">
                        <!-- Default Image Block -->
                        <div style="position: relative; width: 410px; height: 320px;">
                            <img src="{{ asset('website/images/yellow.png') }}" alt="Yellow BG" 
                                style="width: 380px; height: 290px; position: absolute; top: 0; left: 20px; z-index: 1;">
                            <img src="{{ asset('website/images/about01.png') }}" alt="About JEAP"
                                style="width: 380px; height: 290px; position: absolute; top: 20px; left: 0; z-index: 2; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
            @endforelse

        </div>
    </section>
@endsection