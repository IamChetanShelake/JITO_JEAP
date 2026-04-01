@extends('website.layout.main')

@section('content')
    
    {{-- CSS for Hover Effect --}}
    <style>
        .director-card {
            transition: all 0.3s ease; /* Smooth transition for background and border */
        }

        /* Hover State for Card */
        .director-card:hover {
            background-color: #393186 !important; /* Blue Background */
            border-color: #393186 !important;     /* Blue Border */
        }

        /* Text Colors: Change to White on Hover */
        .director-card:hover h3,
        .director-card:hover p {
            color: #ffffff !important;
        }

        /* Link Color: Change to White on Hover */
        .director-card:hover a {
            color: #ffffff !important;
        }

        /* Image Border: Change to White on Hover */
        .director-card:hover .img-circle {
            border-color: #ffffff !important;
        }
    </style>

    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container" style="display: flex; flex-direction: column; gap: 30px; max-width: 1400px;">

            <!-- Zone Chairmen Section -->
            <div class="text-image-wrapper row align-items-center" style="">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Zone</span> <span style="color: #393186;">Chairmen</span>
                    </h2>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="row">

                        @forelse($items as $item)
                        <div class="col-md-3 mt-4 ">
                            <div class="card director-card" style="width: 85%; margin: 0 auto; background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding: 20px;border:1px solid #D7D7D7;">
                                <p style="font-size: 16px; color: #4D4D4D;font-weight: 600; margin:0px 0px 7px;font-family: 'Poppins';">
                                    {{ $item->post }}
                                </p>
                                <div class="img-circle" style="border-radius: 50%; width: 150px; height: 150px; margin: 0 auto 15px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.2); border: 2px solid #ccc;">
                                    @if($item->image)
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 106%; height: 106%; object-fit: cover;">
                                    @else
                                    <img src="{{ asset('website/images/j1.png') }}" alt="{{ $item->name }}" style="width: 106%; height: 106%; object-fit: cover;">
                                    @endif
                                </div>
                                <h3 style="font-size: 16px; font-weight: 600; color: #393186; margin-bottom: -4px;font-family: 'Poppins', sans-serif !important; text-transform: none !important;">
                                    {{ $item->name }}
                                </h3>
                                @if($item->email)
                                <a href="mailto:{{ $item->email }}" style="font-size: 16px;  color: #FFD800; text-decoration:underline;">{{ $item->email }}</a>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12 text-center py-4">
                            <p class="text-muted">No Zone Chairmen data available</p>
                        </div>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection