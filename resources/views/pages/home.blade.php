@extends('layouts.app')

@section('content')
<section class="hero-parallax d-flex align-items-center justify-content-center">
    <div class="hero-overlay"></div>
    <div class="bottom-blur-layer"></div> 

    <div class="container position-relative z-3 text-center text-white">
        <span class="khula fw-bold d-block mb-3 animate-fade-in" style="letter-spacing: 0.6rem; font-size: 0.8rem; opacity: 0.9;">
            EST. 2025 &bull; BACOLOD CITY
        </span>

        <h1 class="display-1 tenor-sans mb-4 title-container">
            <span class="d-block animate-slide-up-1">Slow Down</span> 
            <span class="d-block animate-slide-up-2">
                <span class="fst-italic" style="font-family: 'Cormorant Garamond', serif; text-transform: lowercase; font-weight: 300;">at</span> 
                Dayúnan.
            </span>
        </h1>

       <p class="khula mb-5 mx-auto opacity-75 animate-fade-in-delayed" 
   style="max-width: 500px; text-transform: none; letter-spacing: 0.05rem; font-size: 1.05rem;">
    A grounded sanctuary designed for quiet relaxation and shared celebrations.
</p>

        <div class="d-flex justify-content-center gap-3 animate-fade-in-delayed">
           <a href="{{ url('/explore') }}" class="btn btn-dayunan-hero-light px-5 py-3 tenor-sans fs-5">
    The Villa
</a>

<a href="{{ url('/book') }}" class="btn btn-dayunan-hero-outline px-5 py-3 tenor-sans fs-5 d-flex align-items-center gap-2">
    <span>Book Now</span>
    <i class="bi bi-arrow-right pointing-arrow"></i>
</a>
        </div>
    </div>
</section>

<section class="container py-5 my-5">
    <div class="row align-items-center g-5">
        
        <div class="col-lg-7">
            <div class="staircase-wrapper">
                
                <div class="staircase-box step-1">
                    <div class="box-inner">
                        <img src="{{ asset('images/1.jpg') }}" alt="Entrance" class="zoom-img">
                        <div class="inner-hover-text">
                            <h6 class="tenor-sans text-white m-0">THE ARRIVAL</h6>
                        </div>
                    </div>
                </div>

                <div class="staircase-box step-2 shadow-lg">
                    <div class="box-inner">
                        <img src="{{ asset('images/2.jpg') }}" alt="Detail" class="zoom-img">
                        <div class="inner-hover-text">
                            <h6 class="tenor-sans text-white m-0">QUIET CORNERS</h6>
                        </div>
                    </div>
                </div>

                <div class="staircase-box step-3 shadow-lg">
                    <div class="box-inner">
                        <img src="{{ asset('images/3.jpg') }}" alt="Texture" class="zoom-img">
                        <div class="inner-hover-text">
                            <h6 class="tenor-sans text-white m-0">NATURAL SOUL</h6>
                        </div>
                    </div>
                </div>

                <div class="staircase-box step-4 shadow-lg">
                    <div class="box-inner">
                        <img src="{{ asset('images/4.jpg') }}" alt="The Villa" class="zoom-img">
                        <div class="inner-hover-text">
                            <h6 class="tenor-sans text-white m-0">SHARED SPACES</h6>
                        </div>
                    </div>
                </div>

                <div class="staircase-box step-5 shadow-sm">
                    <div class="box-inner">
                        <img src="{{ asset('images/5.jpg') }}" alt="Light" class="zoom-img">
                        <div class="inner-hover-text">
                            <h6 class="tenor-sans text-white m-0">GOLDEN HOUR</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-4 offset-lg-1">
    <div class="gallery-story">
        <span class="text-terracotta khula d-block mb-3" style="letter-spacing: 0.4rem; font-size: 1rem;">
    THE EXPERIENCE
</span>

        <h2 class="tenor-sans mb-4" style="color: #3A5F41; font-size: 2.8rem; line-height: 1.1;">
            A Place to Pause and Breathe.
        </h2>
        
        <div class="phrase-list mt-5">
            <div class="mb-4 pb-3 border-bottom border-light">
                <p class="khula text-muted mb-0" style="font-size: 1.15rem;">
                    Step inside and settle into a space made for rest, quiet work, and easy moments.
                </p>
            </div>

            <div class="mb-4 pb-3 border-bottom border-light">
                <p class="khula text-muted mb-0" style="font-size: 1.15rem;">
                    Spend your day by the pool, gather with friends, or simply take your time.
                </p>
            </div>

            <div>
                <p class="khula text-muted mb-0" style="font-size: 1.15rem;">
                    Everything is set so you can arrive, unwind, and feel at ease.
                </p>
            </div>
        </div>
    </div>
</div>
    </div>
</section>

<style>
    /* --- STAIRCASE LOGIC --- */
    .staircase-wrapper {
        position: relative;
        height: 650px; 
        width: 100%;
        display: block;
    }

    .staircase-box {
        position: absolute;
        aspect-ratio: 1 / 1;
        width: 400px; 
        background: #fff;
        padding: 6px;
        transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        z-index: 1;
        bottom: 0;
    }

    .step-1 { left: 0; height: 350px; z-index: 1; }
    .step-2 { left: 100px; height: 430px; z-index: 2; }
    .step-3 { left: 200px; height: 510px; z-index: 3; }
    .step-4 { left: 300px; height: 590px; z-index: 4; }
    .step-5 { left: 400px; height: 470px; z-index: 5; }

    /* --- INNER TEXT (REVEAL ON HOVER) --- */
    .inner-hover-text {
        position: absolute;
        bottom: 25px;
        left: 25px;
        opacity: 0; /* Hidden by default */
        transform: translateY(15px); /* Slide up start position */
        transition: all 0.5s ease 0.1s; /* Slight delay for smoothness */
        z-index: 10;
    }

    .tiny-num { 
        font-size: 0.6rem; 
        color: #C26B4E; 
        letter-spacing: 0.2rem; 
        display: block; 
        margin-bottom: 5px; 
        font-weight: bold;
    }

    /* --- HOVER EFFECTS --- */
    .staircase-box:hover {
        z-index: 100 !important;
        transform: scale(1.1) translateY(-20px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.3);
    }

    /* THE REVEAL TRIGGER */
    .staircase-box:hover .inner-hover-text {
        opacity: 1; /* Show text */
        transform: translateY(0); /* Slide text to final position */
    }

    .box-inner {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .zoom-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s ease, filter 0.6s ease;
    }

    .staircase-box:hover .zoom-img {
        filter: brightness(0.8); 
        transform: scale(1.1);
    }

    /* Blur others on hover */
    .staircase-wrapper:hover .staircase-box:not(:hover) {
        filter: blur(3px) grayscale(0.5);
        opacity: 0.4;
    }

    /* --- HERO STYLING (Same as before) --- */
    .hero-parallax {
        height: 100vh;
        background-image: url("{{ asset('images/home.jpg') }}"); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        z-index: 0;
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.2));
        z-index: 0;
    }

    .bottom-blur-layer {
        position: absolute;
        bottom: 0; left: 0; width: 100%; height: 70vh;
        z-index: 1;
        backdrop-filter: blur(50px) brightness(0.75);
        -webkit-backdrop-filter: blur(50px) brightness(0.75);
        mask-image: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,1) 100%);
        pointer-events: none;
    }

    .btn-dayunan-hero-light {
        background: #FFFFFF; color: #3A5F41; border: none; border-radius: 0;
        letter-spacing: 0.2rem; font-size: 0.7rem; transition: all 0.4s ease;
    }
    .btn-dayunan-hero-light:hover { background: #C26B4E; color: #FFFFFF; transform: translateY(-5px); }

    .btn-dayunan-hero-outline {
        background: transparent; color: #FFFFFF; border: 1px solid rgba(255,255,255,0.8);
        border-radius: 0; letter-spacing: 0.2rem; font-size: 0.7rem; transition: all 0.4s ease;
    }
    .btn-dayunan-hero-outline:hover { background: #C26B4E; border-color: #C26B4E; transform: translateY(-5px); }

    .text-terracotta { color: #C26B4E; }

    @keyframes slideReveal {
        from { opacity: 0; transform: translateY(80px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up-1 { animation: slideReveal 1.2s forwards; }
    .animate-slide-up-2 { animation: slideReveal 1.2s 0.3s forwards; opacity: 0; }

    @media (max-width: 991px) {
        .staircase-wrapper { height: auto; display: flex; flex-direction: column; align-items: center; }
        .staircase-box { position: relative; left: 0 !important; width: 90%; margin-bottom: 20px; height: 350px !important; }
        .gallery-story { margin-top: 50px; text-align: center; }
        .inner-hover-text { opacity: 1; transform: translateY(0); } /* Auto-show on mobile */
    }
</style>
@endsection