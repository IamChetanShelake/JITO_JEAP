@extends('website.layout.main')

@section('content')

<style>

/* SECTION */
.about-section{
    padding: 260px 0 80px;
    background: #ffffff;
}

.about-container{
    max-width: 1400px;
    margin: auto;
}

/* HEADING */
.about-heading{
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.heading-line{
    width: 4px;
    height: 50px;
    background: #E31E24;
}

.about-heading h1{
    font-size: 48px;
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
}

.about-yellow{
    color: #FFD800;
}

.about-blue{
    color: #393186;
}

/* SUBTITLE */
.about-subtitle{
    font-size: 34px;
    font-family: 'Times New Roman', Times, serif;
    margin-bottom: 30px;
    color: #2f2f2f;
}

/* GRID */
.about-grid{
    display: flex;
    align-items: flex-start;
    gap: 40px;
    flex-wrap: wrap;
}

/* LEFT TEXT */
.about-text{
    flex: 1;
    min-width: 300px;
}

.about-text p{
    font-size: 18px;
    line-height: 1.7;
    font-family: 'Poppins';
    color: #5B5B5B;
    margin-bottom: 20px;
    text-align: justify;
}

/* MAP */
.about-map{
    flex: 1;
    text-align: center;
    min-width: 300px;
}

.about-map img{
    max-width: 500px;
    width: 100%;
}

/* ========================= */
/* STATS SECTION */
/* ========================= */
.about-stats{
    display: flex;
    justify-content: flex-start; /* Aligns to left inside text column */
    align-items: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: nowrap; /* Prevent wrapping - all boxes in one line */
}

.stat-box{
    background-color: #393186; /* JITO Blue */
    color: #ffffff;
    
    /* Dimensions - Normal Width & Reduced Height */
    flex: 0 0 auto; /* Prevents stretching */
    width: calc(25% - 15px);   /* Equal width for 4 boxes */
    min-width: 140px;   /* Minimum width */
    padding: 25px 10px; /* Reduced height (25px top/bottom) */
    
    /* Styling */
    border-radius: 0px; /* Sharp corners */
    box-shadow: 0 4px 4px rgba(0,0,0,0.2);
    text-align: center;
    
    /* Center content */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    
    transition: 0.3s;
}

.stat-box:hover{
    transform: translateY(-5px);
    box-shadow: 0 8px 8px rgba(0,0,0,0.3);
}

/* Number Style */
.stat-box h3{
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    font-family: 'Poppins';
    line-height: 1.2;
    color: #ffffff;
}

/* Text Style */
.stat-box p{
    margin-top: 8px;
    font-size: 18px;
    font-weight: 600;
    font-family: 'Poppins';
    color: #ffffff;
}

/* ========================= */
/* RESPONSIVE */
/* ========================= */

@media (max-width: 1200px){
    .about-stats{
        flex-wrap: wrap; /* Allow wrapping on smaller screens */
        justify-content: center;
    }
    
    .stat-box{
        width: calc(25% - 15px);
        min-width: 140px;
    }
}

@media (max-width: 992px){
    .about-grid{
        flex-direction: column;
    }

    .about-text, .about-map{
        min-width: auto;
    }

    .about-stats{
        flex-wrap: wrap;
        justify-content: center;
    }

    .stat-box{
        width: 45%; /* 2 boxes per row on tablet */
        margin-bottom: 15px;
        padding: 30px 20px; /* Slightly more padding for tablet */
    }
}

@media (max-width: 576px){
    .stat-box{
        width: 100%; /* 1 box per row on mobile */
    }
}

</style>


<section class="about-section">

    <div class="container about-container">

        <!-- HEADING -->
        <div class="about-heading">
            <div class="heading-line"></div>
            <h1>
                <span class="about-yellow">ABOUT</span>
                <span class="about-blue">US</span>
            </h1>
        </div>

        <!-- SUB HEADING -->
        <h2 class="about-subtitle">JITO at Glance</h2>

        <div class="about-grid">

            <!-- LEFT TEXT -->
            <div class="about-text">
                @forelse($items ?? [] as $item)
                    @foreach(($item->paragraphs ?? []) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                @empty
                    <p>
                        JITO is a global organisation of entrepreneurs, industrialists,
                        professionals, and knowledge leaders, committed to upholding
                        the legacy of ethical and responsible business practices.
                    </p>
                    <p>
                        With a worldwide footprint, JITO is dedicated to fostering
                        socio-economic empowerment, promoting value-based education,
                        advancing community welfare, inspiring compassion,
                        strengthening global harmony, and contributing to the
                        spiritual enrichment of society.
                    </p>
                @endforelse

                <!-- STATS - Inside Text Column -->
                @php
                    // Default static stats
                    $defaultStats = [
                        ['number' => '78', 'text' => 'Chapters'],
                        ['number' => '9', 'text' => 'Zones'],
                        ['number' => '18719+', 'text' => 'Donors'],
                        ['number' => '32', 'text' => 'International'],
                    ];
                    
                    // Get dynamic stats from database
                    $dynamicStats = $stats ?? collect();
                    
                    // Merge: DB stats override default stats by position
                    $finalStats = [];
                    for ($i = 0; $i < 4; $i++) {
                        if (isset($dynamicStats[$i]) && $dynamicStats[$i]->status) {
                            $finalStats[] = [
                                'number' => $dynamicStats[$i]->number,
                                'text' => $dynamicStats[$i]->text
                            ];
                        } else {
                            $finalStats[] = $defaultStats[$i] ?? ['number' => '-', 'text' => ''];
                        }
                    }
                @endphp
                
                <div class="about-stats">
                    @foreach($finalStats as $stat)
                        <div class="stat-box">
                            <h3>{{ $stat['number'] }}</h3>
                            <p>{{ $stat['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT MAP -->
            <div class="about-map">
                @forelse($items ?? [] as $item)
                    @if($item->image)
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title ?? 'JITO' }}">
                    @else
                        <img src="{{ asset('website/images/indianMap.png') }}" alt="India Map">
                    @endif
                @empty
                    <img src="{{ asset('website/images/indianMap.png') }}" alt="India Map">
                @endforelse
            </div>

        </div> <!-- End Grid -->

    </div>

</section>

@endsection