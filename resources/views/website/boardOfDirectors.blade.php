@extends('website.layout.main')

@section('content')
    <section>
        <div class="desktop-margin" style="position: relative; background-color: #393186; padding: 80px 0;">
            
            <style>
                /* Marquee Animation for Note */
                .marquee-container {
                    overflow: hidden;
                    background-color: white;
                    white-space: nowrap;
                    position: relative;
                }
                
                .marquee-content {
                    display: inline-block;
                    animation: marquee 50s linear infinite;
                    padding-left: 100%;
                }
                
                .marquee-content:hover {
                    animation-play-state: paused;
                }

                @keyframes marquee {
                    0%   { transform: translate(0, 0); }
                    100% { transform: translate(-100%, 0); }
                }

                @media (min-width: 992px) {
                    .note-margin { margin-top: -13px !important; }
                }

                @media (max-width: 576px) {
                    .note-margin { margin-top: -80px !important; }
                }

                .dotted-connector {
                    position: absolute;
                    top: 40px;
                    left: 32%;
                    width: 100%;
                    height: 3px;
                    background-image: radial-gradient(circle, white 2px, transparent 2px);
                    background-size: 10px 1px;
                    background-position: 0 0;
                    transform: translateY(-50%);
                    z-index: 0;
                }

                @media (min-width: 768px) {
                    .dotted-connector { display: block; }
                }

                @media (max-width: 768px) {
                    .dotted-connector { display: none; }
                }
            </style>

            <!-- Running Note / Marquee -->
            <div class="note-margin marquee-container" style="padding: 30px 0;">
                <div class="marquee-content">
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                    <p style="color: red; background-color: white; padding: 0 50px; text-align: center; display: inline-block; font-size: 16px; margin: 0;">
                        *Note :- 1) Welcome to our Website, this application should be filled in Laptop or Desktop specifically. Request you to please clear the history and cache of your Laptop or Desktop
                    </p>
                </div>
            </div>

            <div class="container">
                <div class="row align-items-center" style="margin-top: 50px;">
                    <div class="col-lg-7 col-md-12 text-white mb-5 ">
                        <h2 class=" mb-3" style="font-family: Times New Roman;font-size:48px; line-height: 1.3;color:#ffff;font-weight:400;text-transform:none !important;">
                            Empowering Dreams
                        </h2>
                        <p class="mb-4" style="font-size: 18px; color: #ffff;font-family:'Poppins', sans-serif; ">
                            @if(isset($empoweringDreams) && $empoweringDreams->count() > 0) {{ $empoweringDreams->first()->description }} @else JEAP's mission is to empower deserving students to pursue their academic aspirations and reach their highest potential. @endif
                        </p>

                        <!-- ICON ROW -->
<div class="icons-container" style="position: relative;">
    <div class="row text-center">
        @php
            $features = [];
            $featureImages = [];
            $firstDream = $empoweringDreams->first();
            if ($firstDream && $firstDream->features) {
                $features = array_map('trim', explode(',', $firstDream->features));
                $featureImages = json_decode($firstDream->feature_images, true) ?? [];
            }
        @endphp
        @foreach($features as $index => $feature)
        <div class="col-6 col-md-3 mb-4">
            <div class="p-3 bg-white rounded-circle mx-auto"
                style="width:80px;height:80px; display:flex; justify-content:center; align-items:center; z-index: 9; position: relative;">
                @if(isset($featureImages[$index]) && file_exists(public_path($featureImages[$index])))
                    <img src="{{ asset($featureImages[$index]) }}" alt="{{ $feature }}" style="width: 60px; height: 60px; object-fit: contain;">
                @else
                    <svg width="50" height="41" viewBox="0 0 50 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40.3906 18.6055L30.1172 23.5283C28.5151 24.294 26.7649 24.6914 24.9932 24.6914C23.2214 24.6914 21.4713 24.2941 19.8691 23.5283H19.8701L9.5957 18.6055L8.87988 18.2617V29.9443C8.87988 31.7772 9.47652 33.4018 10.7402 34.3242C13.0727 36.0522 17.5785 38.3349 24.9932 38.335C32.4126 38.335 36.905 36.0334 39.2461 34.3242C40.5145 33.4073 41.1074 31.7909 41.1074 29.9443V18.2617L40.3906 18.6055ZM24.9932 2.65625C23.5362 2.65629 22.0976 2.98323 20.7812 3.61328L2.91895 12.1348L1.97363 12.5859L2.91895 13.0371L20.7803 21.5576V21.5586C22.0968 22.1889 23.5359 22.5156 24.9932 22.5156C26.3594 22.5156 27.7097 22.2282 28.958 21.6729L29.2061 21.5586L47.0674 13.0371L48.0137 12.5859L47.0674 12.1348L29.2051 3.61328C27.8888 2.98334 26.45 2.65625 24.9932 2.65625ZM6.75684 17.2666L6.47266 17.1309L2.00684 15.001V15L1.84082 14.9141C1.46339 14.7003 1.14277 14.3944 0.90918 14.0225C0.642089 13.5972 0.5 13.1032 0.5 12.5986C0.500021 12.0941 0.642103 11.6001 0.90918 11.1748C1.17624 10.7496 1.55744 10.4109 2.00684 10.1973L2.04004 10.1816L2.05859 10.168L19.8877 1.66309C21.4898 0.897379 23.24 0.500071 25.0117 0.5C26.7836 0.5 28.5345 0.89731 30.1367 1.66309L47.998 10.1846V10.1836C48.4465 10.3982 48.8266 10.7379 49.0928 11.1631C49.359 11.5883 49.5001 12.0819 49.5 12.5859V29.9443C49.5 30.232 49.3871 30.5072 49.1875 30.709C48.9881 30.9105 48.7182 31.0225 48.4385 31.0225C48.159 31.0224 47.8898 30.9103 47.6904 30.709C47.4908 30.5072 47.377 30.2319 47.377 29.9443V15.2959L46.6621 15.6387L43.5391 17.1309L43.2549 17.2666V29.9541C43.2548 32.2311 42.5305 34.6399 40.5117 36.1143C37.8113 38.0609 32.8857 40.5 25.0059 40.5C17.6153 40.5 12.8138 38.3687 10.0303 36.4873L9.5 36.1143C7.48128 34.6335 6.75689 32.2057 6.75684 29.9541V17.2666Z" fill="#FFD800" stroke="#FFD800" />
                    </svg>
                @endif
            </div>
            {{-- REMOVED THE DOT FROM HERE --}}
            <p class="mt-2 text-white" style="font-family:'Poppins', sans-serif;font-size:18px;font-weight:400;">
                {{ $feature }}
            </p>
        </div>
        @endforeach
    </div>
    
    {{-- ADDED ONE SINGLE LINE HERE --}}
    <div class="dotted-connector"></div>
</div>
                    </div>

                    <div class="col-lg-5 col-md-12 text-center">
                        @if($firstDream && $firstDream->image && file_exists(public_path($firstDream->image)))
                            <img src="{{ asset($firstDream->image) }}" alt="{{ $firstDream->title }}" style="max-width: 100%; height: auto; max-height: 500px; width: auto; object-fit: contain;">
                        @else
                            <img src="{{ asset('website/images/books.png') }}" alt="" style="max-width: 100%; height: auto; max-height: 500px; width: auto; object-fit: contain;">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <style>
            @media (min-width: 1200px) { .desktop-margin { margin-top: 200px; } }
            @media (max-width: 1199px) { .desktop-margin { margin-top: 0; } }
            .dotted-connector {
    position: absolute;
    top: 40px;
    /* Adjusted to start at the first icon and end at the last icon */
    left: 12%; 
    width: 76%; 
    height: 3px;
    background-image: radial-gradient(circle, white 2px, transparent 2px);
    background-size: 10px 1px;
    background-position: 0 0;
    transform: translateY(-50%);
    z-index: 0;
}

/* Show dotted lines only on desktop (≥768px) */
@media (min-width: 768px) {
    .dotted-connector { display: block; }
}

@media (max-width: 768px) {
    .dotted-connector { display: none; }
}
        </style>

        <script>
            function updateCardLayout() {
                const container = document.getElementById('cardContainer');
                if (window.innerWidth < 768) {
                    container.style.position = 'static';
                    container.style.transform = 'none';
                    container.style.flexDirection = 'column';
                    container.style.alignItems = 'center';
                    container.style.gap = '20px';
                } else {
                    container.style.position = 'absolute';
                    container.style.bottom = '-150px';
                    container.style.left = '50%';
                    container.style.transform = 'translateX(-50%)';
                    container.style.flexDirection = 'row';
                    container.style.gap = '100px';
                }
            }
            window.addEventListener('resize', updateCardLayout);
            window.addEventListener('load', updateCardLayout);
        </script>
    </section>

    <style>
        @media (max-width: 768px) {
            .card-container { flex-wrap: wrap !important; }
            .about-img-container { display: flex !important; justify-content: center !important; }
            .about-img-container img { margin: 0 auto !important; display: block !important; width: 100% !important; max-width: 300px !important; transform: none !important; }
            .text-image-wrapper { gap: 30px !important; }
        }
    </style>

    {{-- =============================KEY INSTRUCTIONS SECTION================= --}}
    <section class="key-instructions-section" style="background:#ffffff; padding:80px 0; overflow: visible;">
        <div class="container">
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">KEY</span> <span style="color: #393186;">INSTRUCTIONS</span>
                    </h2>
                </div>
            </div>

            <div class="key-instructions-carousel position-relative" style="padding: 100px 20px 50px; overflow: visible;">
                <button class="carousel-btn prev-btn" id="prevBtn" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); z-index: 10; background: #393186; border: none; border-radius: 50%; width: 50px; height: 50px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button class="carousel-btn next-btn" id="nextBtn" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); z-index: 10; background: #393186; border: none; border-radius: 50%; width: 50px; height: 50px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>

                <div class="carousel-track-container" style="overflow: hidden; margin: 0 40px; width: calc(100% - 80px);">
                    <div class="carousel-track" id="keyInstructionsTrack" style="display: flex; margin-top:50px; transition: transform 0.5s ease-in-out; gap: 20px; justify-content: center;">
                        <style>
                            .key-card { transition: all 0.3s ease; }
                            .key-card[data-color="blue"]:hover { background-color: #00008B !important; border-color: #00008B !important; }
                            .key-card[data-color="blue"]:hover .card-title, .key-card[data-color="blue"]:hover .card-text { color: #fff !important; }
                            .key-card[data-color="green"]:hover { background-color: #009846 !important; border-color: #009846 !important; }
                            .key-card[data-color="green"]:hover .card-title, .key-card[data-color="green"]:hover .card-text { color: #fff !important; }
                            .key-card[data-color="yellow"]:hover { background-color: #FFD800 !important; border-color: #FFD800 !important; }
                            .key-card[data-color="yellow"]:hover .card-title, .key-card[data-color="yellow"]:hover .card-text { color: #000 !important; }
                            .key-card[data-color="red"]:hover { background-color: #E31E25 !important; border-color: #E31E25 !important; }
                            .key-card[data-color="red"]:hover .card-title, .key-card[data-color="red"]:hover .card-text { color: #fff !important; }
                            .key-card[data-color="purple"]:hover { background-color: #393186 !important; border-color: #393186 !important; }
                            .key-card[data-color="purple"]:hover .card-title, .key-card[data-color="purple"]:hover .card-text { color: #fff !important; }
                            .carousel-btn:hover { background: #E31E25 !important; transform: translateY(-50%) scale(1.1); }
                            .icon-circle svg { width: 45px !important; height: 45px !important; position: absolute !important; top: 50% !important; left: 50% !important; transform: translate(-50%, -50%) !important; margin: 0 !important; }
                            .icon-circle svg circle, .icon-circle svg path { stroke: white !important; }
                            @media (max-width: 768px) { .carousel-btn { width: 40px; height: 40px; } .key-instructions-carousel .carousel-track-container { margin: 0 30px; } .key-card-wrapper { width: calc(50% - 10px) !important; } }
                            @media (max-width: 576px) { .key-card-wrapper { width: calc(100% - 20px) !important; } .key-instructions-carousel .carousel-track-container { margin: 0 35px; } }
                        </style>

                        @forelse($keyInstructions as $instruction)
                        @php
                            $borderColor = $instruction->color ?? '#393186';
                            $totalCount = $keyInstructions->count();
                            if ($totalCount >= 6) { $cardWidth = '16.666%'; } elseif ($totalCount == 5) { $cardWidth = '20%'; } elseif ($totalCount == 4) { $cardWidth = '25%'; } elseif ($totalCount == 3) { $cardWidth = '33.333%'; } else { $cardWidth = '25%'; }
                            $iconSvg = '';
                            $iconImage = null;
                            
                            // Check for uploaded image first
                            if (!empty($instruction->icon_image)) {
                                $iconImage = asset('storage/' . $instruction->icon_image);
                            } elseif (!empty($instruction->icon_svg)) {
                                $iconSvg = preg_replace('/(<svg)/i', '$1 width="35" height="39" viewBox="0 0 24 24"', $instruction->icon_svg);
                                $iconSvg = preg_replace('/stroke="[^"]*"/i', 'stroke="white"', $iconSvg);
                            } else {
                                switch($instruction->icon) {
                                    case 'info': $iconSvg = '<svg width="35" height="39" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/><path d="M12 16V12M12 8H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>'; break;
                                    case 'check': $iconSvg = '<svg width="35" height="39" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/><path d="M8 12L11 15L16 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'; break;
                                    case 'money': $iconSvg = '<svg width="35" height="39" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/><path d="M12 6V18M15 9H9M15 12H9M15 15H9" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>'; break;
                                    default: $iconSvg = '<svg width="35" height="39" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/><path d="M12 16V12M12 8H12.01" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>';
                                }
                            }
                        @endphp
                        <div class="key-card-wrapper" style="flex: 0 0 auto; width: calc({{ $cardWidth }} - 17px); min-width: 180px;">
                            <div class="key-card" data-color="{{ $borderColor }}" style="--card-color: {{ $borderColor }}; position: relative; background: #ffffff; border-radius: 0px; border: 2px solid {{ $borderColor }}; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 30px 25px 30px; height: 240px; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor=this.dataset.color; this.style.backgroundColor=this.dataset.color; this.querySelector('.card-title').style.color='#fff'; this.querySelector('.card-text').style.color='#fff'; this.querySelector('.icon-circle').style.backgroundColor='#ffffff'; this.querySelector('.icon-circle').style.borderColor=this.dataset.color; this.querySelector('.icon-circle').style.borderWidth='3px';" onmouseout="this.style.borderColor=this.dataset.color; this.style.backgroundColor='#ffffff'; this.querySelector('.card-title').style.color='#3E3E3E'; this.querySelector('.card-text').style.color='#5B5B5B'; this.querySelector('.icon-circle').style.backgroundColor=this.dataset.color; this.querySelector('.icon-circle').style.borderColor='#ffff'; this.querySelector('.icon-circle').style.borderWidth='5px';">
                                <div class="icon-circle" style="position: absolute; top: -55px; left: 50%; transform: translateX(-50%); background: {{ $borderColor }}; border-radius: 50%; border: 5px solid #ffff; width: 110px; height: 110px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: all 0.3s ease; overflow: visible;">
                                    @if($iconImage)
                                        <img src="{{ $iconImage }}" alt="Icon" style="width: 80px; height: 80px; object-fit: contain; border-radius: 50%;">
                                    @else
                                        <span style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">{!! $iconSvg !!}</span>
                                    @endif
                                </div>
                                <h5 class="card-title" style="font-family:'Poppins', sans-serif;font-size: 16px; font-weight: 600; color: #3E3E3E; text-align: center; margin-top: 45px; margin-bottom: 6px; transition: color 0.3s ease;">{{ $instruction->title }}</h5>
                                <p class="card-text" style="font-size: 13px; color: #5B5B5B; text-align: center; line-height: 1.5; transition: color 0.3s ease;">{{ $instruction->description }}</p>
                            </div>
                        </div>
                        @empty
                            <p class="text-center w-100">No key instructions available at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('keyInstructionsTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (!track || !prevBtn || !nextBtn) return;
        const cards = track.querySelectorAll('.key-card-wrapper');
        let currentIndex = 0;
        function getCardsPerView() {
            const width = window.innerWidth;
            if (width >= 1200) return 6;
            if (width >= 992) return 5;
            if (width >= 768) return 3;
            if (width >= 576) return 2;
            return 1;
        }
        function updateCarousel() {
            const cardsPerView = getCardsPerView();
            const firstCard = cards[0];
            if (!firstCard) return;
            const gap = 20;
            const cardWidth = firstCard.offsetWidth + gap;
            const maxIndex = Math.max(0, cards.length - cardsPerView);
            if (currentIndex > maxIndex) currentIndex = maxIndex;
            if (currentIndex < 0) currentIndex = 0;
            if (cards.length <= cardsPerView) {
                track.style.justifyContent = 'center';
                track.style.transform = 'translateX(0px)';
            } else {
                track.style.justifyContent = 'flex-start';
                const translateX = -(currentIndex * cardWidth);
                track.style.transform = 'translateX(' + translateX + 'px)';
            }
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
            prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        }
        prevBtn.addEventListener('click', function() {
            const cardsPerView = getCardsPerView();
            if (currentIndex > 0) { currentIndex -= cardsPerView; updateCarousel(); }
        });
        nextBtn.addEventListener('click', function() {
            const cardsPerView = getCardsPerView();
            const maxIndex = Math.max(0, cards.length - cardsPerView);
            if (currentIndex < maxIndex) { currentIndex += cardsPerView; updateCarousel(); }
        });
        window.addEventListener('resize', updateCarousel);
        updateCarousel();
    });
    </script>

    {{-- =============================WORKING COMMITTEE SECTION================= --}}
    <section style="padding: 80px 0; background: #FFF9E6;">
        <div class="container">
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">WORKING</span> <span style="color: #393186;">COMMITTEE</span>
                    </h2>
                </div>
            </div>

            <style>
                .committee-card-item {
                    background-color: #393186;
                    border: 2px solid #FFD800;
                    padding: 30px 20px;
                    text-align: center;
                    height: 100%;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    transition: all 0.3s ease;
                }
                .committee-card-item:hover {
                    background-color: #ffffff;
                    border-color: #393186;
                }
                .committee-card-item h3 { color: #ffffff; transition: color 0.3s ease; }
                .committee-card-item p { color: #e0e0e0; transition: color 0.3s ease; }
                .committee-card-item a { color: #FFD800; }
                .committee-card-item:hover h3 { color: #393186; }
                .committee-card-item:hover p { color: #666; }
                .committee-card-item:hover a { color: #393186; }
                .committee-card-item .img-circle {
                    border: 3px solid #ffffff;
                    transition: border-color 0.3s ease;
                }
                .committee-card-item:hover .img-circle {
                    border-color: #393186;
                }
            </style>

            <div class="row">
                @forelse($workingCommittee as $member)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="committee-card-item">
                        <div class="img-circle" style="width: 150px; height: 150px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden;">
                            @if(!empty($member->photo))
                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('website/images/wc11.png') }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <h3 style="font-size: 16px; font-weight: 600; font-family: 'Poppins', sans-serif; margin-bottom: 5px; text-transform: none;">
                            {{ $member->name }}
                        </h3>
                        <p style="font-size: 16px; font-weight: 500; margin-bottom: 15px;">
                            {{ $member->designation }}
                        </p>
                        @if(!empty($member->description))
                            <a href="#" data-bs-toggle="modal" data-bs-target="#wcModal{{ $member->id }}" style="font-size: 16px; text-decoration: underline; font-weight: 500;">Show more</a>
                        @endif
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    
    {{-- ============================= FIXED WORKING COMMITTEE MODAL ============================= --}}
    @foreach($workingCommittee as $member)
    @if(!empty($member->description))
    <div class="modal fade" id="wcModal{{ $member->id }}" tabindex="-1" aria-labelledby="wcModalLabel{{ $member->id }}" aria-hidden="true">
        {{-- REMOVED modal-sm, added centered --}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #393186; border-radius: 15px; border: 2px solid #FFD800; max-width: 600px; margin: 1.75rem auto;">
                
                {{-- HEADER: Image, Name, Designation --}}
                <div class="modal-header text-center" style="border-bottom: 1px solid rgba(255,255,255,0.2); display: block; position: relative; padding: 30px;">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px;"></button>
                    
                    {{-- Image Logic Fixed and Enlarged --}}
                    <div style="margin-bottom: 15px;">
                        @if(!empty($member->photo))
                            <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #FFD800;">
                        @else
                            <img src="{{ asset('website/images/wc11.png') }}" alt="{{ $member->name }}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #FFD800;">
                        @endif
                    </div>
                    
                    <h5 class="modal-title" id="wcModalLabel{{ $member->id }}" style="color: #FFD800; font-family: 'Times New Roman', Times, serif; font-size: 24px; font-weight: bold;">
                        {{ $member->name }}
                    </h5>
                    
                    @if(!empty($member->designation))
                        <p style="color: #ffffff; font-size: 16px; margin: 5px 0 0;">
                            {{ $member->designation }}
                        </p>
                    @endif
                </div>
                
                {{-- BODY: Description --}}
                <div class="modal-body" style="padding: 25px;">
                    <p style="color: #ffffff; font-size: 15px; line-height: 1.7; text-align: justify; margin-bottom: 0; white-space: pre-wrap;">
                        {!! nl2br(e($member->description)) !!}
                    </p>
                </div>
                
                {{-- FOOTER: Close Button --}}
                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.2); justify-content: center; padding: 15px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #FFD800; color: #393186; font-weight: bold; padding: 10px 40px; border-radius: 5px;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    
    {{-- =============================ABOUT US SECTION================= --}}
    <section style="padding: 100px 0; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;">
            <div class="text-image-wrapper row align-items-center">
                <div class="about-img-container col-md-6">
                    @if($empoweringDreams && $empoweringDreams->count() > 0 && $empoweringDreams->first()->image)
                    <img src="{{ asset($empoweringDreams->first()->image) }}" alt="About Us Image" style="width: 100%; max-width: 500px; height: auto; border-radius: 10px; position: relative; z-index: 2; display: block;">
                @else
                    <img src="{{ asset('website/images/books22.png') }}" alt="About Us Image" style="width: 100%; max-width: 500px; height: auto; border-radius: 10px; position: relative; z-index: 2; display: block;">
                @endif
                </div>
                <div class="col-md-6">
                    <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                        <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                        <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            <span style="color: #FFD800;">Empowering Future</span>
                        </h2>
                    </div>
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 20px; font-family: Arial; color: #5B5B5B; text-align: justify;">
                        @if($empoweringDreams && $empoweringDreams->count() > 0 && $empoweringDreams->first()->description)
                            {{ $empoweringDreams->first()->description }}
                        @else
                            We are committed to empowering deserving, needy, and meritorious students to pursue higher education in India and abroad. Through financial assistance and essential resources, we enable them to access top-tier institutions and unlock their true potential.
                        @endif
                    </p>
                    <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;margin-top:30px;">
                        <div style="width: 10px; height: 10px; background-color: #FFD800;border-radius:50%"></div>
                        <h2 style="font-size: 20px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            <span style="color: #FFD800;">Vision Of Jeap</span>
                        </h2>
                    </div>
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 10px; font-family: Arial; color: #5B5B5B; text-align: justify;">
                        @if($empoweringDreams && $empoweringDreams->count() > 0 && $empoweringDreams->first()->vision_description)
                            {{ $empoweringDreams->first()->vision_description }}
                        @else
                            Aligned with JITO's overarching vision, JEAP (JITO Education Assistance Program) was established with a dedicated focus on uplifting Jain students through quality education and meaningful opportunities.
                        @endif
                    </p>
                    <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;margin-top:30px;">
                        <div style="width: 10px; height: 10px; background-color: #FFD800;border-radius:50%"></div>
                        <h2 style="font-size: 20px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            <span style="color: #FFD800;">Mission Of Jeap</span>
                        </h2>
                    </div>
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 10px; font-family: Arial; color: #5B5B5B; text-align: justify;">
                        @if($empoweringDreams && $empoweringDreams->count() > 0 && $empoweringDreams->first()->mission_description)
                            {{ $empoweringDreams->first()->mission_description }}
                        @else
                            To reach every deserving and underprivileged Jain student by extending timely and impactful support that enables meaningful academic progress and nurtures their overall personal growth.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 0px 0 0 0; background: #ffffff; margin-bottom:0px;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;">
            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                    <span style="color: #FFD800;">Achievements</span> <span style="color: #393186;">& Impact</span>
                </h2>
            </div>
        </div>
    </section>

    <section style="padding:20px 0 0 0; background: #393186;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px;">
            <div class="text-image-wrapper row">
                <div class="col-md-7">
                    <p style="font-size: 16px; line-height: 1.6; margin-top: 20px; font-family: Arial; color: #FFFF; text-align: justify;">
                        At JEAP, we’ve reshaped student financing with the support of 250+ generous donors who have contributed over ₹39.85 crore. This has enabled us to assist 561+ students, disbursing ₹39.80+ crore to date. These numbers reflect transformed lives and fulfilled dreams. Join us in ensuring that financial barriers never limit a student’s pursuit of education.</p>
                    <div class="row">
                        @if($achievementImpacts && $achievementImpacts->count() > 0)
                            @foreach($achievementImpacts as $impact)
                                @php
                                    $numbers = json_decode($impact->numbers, true) ?? [];
                                    $numberTexts = json_decode($impact->number_texts, true) ?? [];
                                @endphp
                                @if(count($numbers) > 0)
                                    @foreach($numbers as $idx => $number)
                                        <div class="col-md-3 ">
                                            <div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;">
                                                <h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">{{ $number }}</h3>
                                                <p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">{{ $numberTexts[$idx] ?? '' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <div class="col-md-3 "><div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;"><h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">250+</h3><p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">Number of Donors</p></div></div>
                            <div class="col-md-3 "><div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;"><h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">261+</h3><p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">Students got benefits</p></div></div>
                            <div class="col-md-3 "><div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;"><h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">39.80+</h3><p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">Financial Assistance Amount</p></div></div>
                            <div class="col-md-3 "><div class="card text-center" style="background: #ffff; border-radius: 0px; padding: 15px; margin: 10px;height:120px;"><h3 style="font-size: 24px; font-weight: 600; font-family: 'Poppins', sans-serif; color: #393186; margin: 0;">39.85 Cr+</h3><p style="font-size: 14px; color: #5B5B5B; margin-top: 10px; font-family: Arial; text-align: center;">Amount collected from Donors</p></div></div>
                        @endif
                    </div>
                </div>
                <div class="about-img-container col-md-5">
                    @if($achievementImpacts && $achievementImpacts->count() > 0)
                        @foreach($achievementImpacts as $impact)
                            @if($impact->image && file_exists(public_path($impact->image)))
                                <img src="{{ asset($impact->image) }}" alt="Achievement Image" style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);margin-bottom:-9.5px;">
                            @else
                                <img src="{{ asset('website/images/trophy22.png') }}" alt="Achievement Image" style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);margin-bottom:-9.5px;">
                            @endif
                        @endforeach
                    @else
                        <img src="{{ asset('website/images/trophy22.png') }}" alt="Achievement Image" style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);margin-bottom:-9.5px;">
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Photo Gallery Section --}}
    <section style="padding:80px 0; background: #fff;">
        <div class="container">
            <div class="text-start mb-5">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Photo</span> <span style="color: #393186;">Gallery</span>
                    </h2>
                </div>
            </div>
            <div class="gallery-slider-container" style="overflow-x: auto; position: relative; width: 100%; scroll-behavior: smooth;">
                <div class="gallery-slider" style="display: flex; gap: 15px; padding: 10px 0;">
                    @if($photoGalleries && $photoGalleries->count() > 0)
                        @foreach($photoGalleries as $gallery)
                            @php $images = $gallery->images ?? []; if (is_string($images)) { $images = json_decode($images, true) ?? []; } @endphp
                            @foreach($images as $img)
                                @if(file_exists(public_path($img)))
                                    <img src="{{ asset($img) }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0; border-radius: 8px;" alt="Gallery Image">
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <img src="{{ asset('website/images/gallery_img_1.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0; border-radius: 8px;" alt="Gallery Image 1">
                        <img src="{{ asset('website/images/gallery_img_2.png') }}" class="gallery-img" style="width:350px; height: 250px; object-fit: cover; flex-shrink: 0; border-radius: 8px;" alt="Gallery Image 2">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .gallery-slider-container::-webkit-scrollbar { display: none; }
        .gallery-slider-container { -ms-overflow-style: none; scrollbar-width: none; }
        .gallery-img { transition: transform 0.3s ease; }
        .gallery-img:hover { transform: scale(1.05); z-index: 1; }
        .testimonial-card { transition: all 0.3s ease; }
        .testimonial-card:hover { background: #393186 !important; transform: translateY(-10px) scale(1.02) !important; box-shadow: 0 15px 40px rgba(57, 49, 134, 0.4) !important; border: 3px solid #FFD800 !important; }
        .testimonial-card:hover h5 { color: #FFD800 !important; }
        .testimonial-card:hover p { color: #ffffff !important; }
        .testimonial-card:hover .testimonial-img { border-color: #FFD800 !important; }
    </style>
    
    {{-- ============================= OUR TESTIMONIALS SECTION ============================= --}}
    <section>
        <div class="container mt-5 mb-5">
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
                    $bgColors = ['#ffffff', '#ffffff', '#ffffff']; 
                    $titleColors = ['#393186', '#393186', '#393186'];
                    $borderColors = ['#D7D7D7', '#D7D7D7', '#D7D7D7'];
                    $textColors = ['#5B5B5B', '#5B5B5B', '#5B5B5B'];
                    $nameColors = ['#333', '#333', '#333'];
                    $dateColors = ['#999', '#999', '#999'];
                    $bgIndex = $index % 3;
                    $displayDate = '';
                    if (!empty($testimonial->date)) {
                        try { $displayDate = \Carbon\Carbon::parse($testimonial->date)->format('d M Y'); } catch (\Exception $e) { $displayDate = ''; }
                    }
                @endphp
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100 testimonial-card" style="background: {{ $bgColors[$bgIndex] }}; border: 1px solid {{ $borderColors[$bgIndex] }}; border-radius: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <div class="testimonial-img" style="width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 3px solid #FFD800;">
                            @if(!empty($testimonial->image))
                                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('website/images/t1.png') }}" alt="{{ $testimonial->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <h5 style="color: {{ $titleColors[$bgIndex] }}; font-weight: 700; font-family: Poppins, sans-serif; font-size: 18px;">{{ $testimonial->title ?? 'Testimonial' }}</h5>
                        <p style="color: {{ $textColors[$bgIndex] }}; font-size: 14px; margin-bottom: 20px;">{{ $testimonial->feedback }}</p>
                        <p style="color: {{ $nameColors[$bgIndex] }}; font-weight: 600; font-size: 15px; margin-bottom: 5px;">{{ $testimonial->name }}</p>
                        <p style="color: {{ $dateColors[$bgIndex] }}; font-size: 13px; margin-bottom: 0;">{{ $displayDate }}</p>
                    </div>
                </div>
                @empty
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card text-center p-4 w-100" style="background: #ffffff; border: 1px solid #D7D7D7; border-radius: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <div style="width: 100px; height: 100px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 3px solid #FFD800;">
                            <img src="{{ asset('website/images/t1.png') }}" alt="Samyukta Shah" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <h5 style="color: #393186; font-weight: 700; font-family: Poppins, sans-serif; font-size: 18px;">Life - Changing Support</h5>
                        <p style="color: #5B5B5B; font-size: 14px; margin-bottom: 20px;">JEAP assistance helped me pursue my education without financial stress.</p>
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

            <div class="row">
                @forelse($successStories as $story)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        @if(!empty($story->image))
                            <img src="{{ asset($story->image) }}" style="width: 100%; height: 350px; object-fit: cover; display: block;" alt="Success Story">
                        @else
                            <img src="{{ asset('website/images/gallery_img_1.png') }}" style="width: 100%; height: 350px; object-fit: cover; display: block;" alt="Success Story">
                        @endif
                    </div>
                    <div class="text-center mt-3">
                        @if(!empty($story->video_link))
                            <a href="{{ $story->video_link }}" target="_blank" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                <span style="font-size: 16px;">Watch on</span>
                                <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                <span style="font-size: 16px;">YouTube</span>
                            </a>
                        @else
                            <span class="text-muted">No video link</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div style="position: relative; overflow: hidden; border: 1px solid #e0e0e0;">
                        <img src="{{ asset('website/images/gallery_img_1.png') }}" style="width: 100%; height: 350px; object-fit: cover; display: block;" alt="Success Story 1">
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" style="display: inline-flex; align-items: center; background-color: #393186; padding: 10px 25px; border-radius: 0px; text-decoration: none; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 500; gap: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <span style="font-size: 16px;">Watch on</span>
                            <div style="background-color: #FF0000; width: 28px; height: 28px; display: flex; justify-content: center; align-items: center; border-radius: 4px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                            <span style="font-size: 16px;">YouTube</span>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection