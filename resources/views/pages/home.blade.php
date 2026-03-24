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

        <p class="khula mb-5 mx-auto opacity-75 animate-fade-in-delayed" style="max-width: 500px; text-transform: none; letter-spacing: 0.05rem;">
            A grounded sanctuary designed for quiet mornings and shared celebrations.
        </p>

        <div class="d-flex justify-content-center gap-3 animate-fade-in-delayed">
            <a href="{{ url('/explore') }}" class="btn btn-dayunan-hero-light px-5 py-3 tenor-sans">
                The Villa
            </a>
            
            <a href="{{ url('/book') }}" class="btn btn-dayunan-hero-outline px-5 py-3 tenor-sans d-flex align-items-center gap-2">
                <span>Book Now</span>
                <i class="bi bi-arrow-right pointing-arrow"></i>
            </a>
        </div>
    </div>
</section>

<section class="container py-5 my-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 position-relative">
            <div class="img-wrapper shadow-lg mb-5" style="width: 85%; margin-left: auto;">
                <img src="{{ asset('images/1.jpg') }}" alt="Resort" class="img-fluid reveal-img">
            </div>
            <div class="img-wrapper shadow-lg position-absolute top-50 start-0 translate-middle-y w-50">
                <img src="{{ asset('images/2.jpg') }}" alt="Aesthetic" class="img-fluid reveal-img">
            </div>
        </div>
        
        <div class="col-lg-5 offset-lg-1">
            <h2 class="tenor-sans mb-4" style="color: #3A5F41;">Aesthetic Living.</h2>
            <p class="text-muted mb-4" style="line-height: 2; font-size: 1.1rem;">
                Crafted to feel like an extension of home, only quieter. Every corner captures the soft morning light and evening warmth.
            </p>
            <a href="{{ url('/explore') }}" class="text-terracotta-link khula fw-bold text-decoration-none" style="font-size: 0.7rem; letter-spacing: 0.2rem;">
                LEARN MORE <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
    /* --- CORE HERO STYLING --- */
    .hero-parallax {
        height: 100vh;
        background-image: url("{{ asset('images/505854273_122101605782901962_1827962554700351857_n.jpg') }}"); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        overflow: hidden;
        z-index: 0;
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.2));
        z-index: 0;
    }

    /* --- THE ULTRA-DEEP PERMANENT BLUR --- */
    .bottom-blur-layer {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 70vh; /* Taller coverage for a "wider" feel */
        z-index: 1;
        
        /* Max intensity blur and darker brightness for depth */
        backdrop-filter: blur(50px) brightness(0.75);
        -webkit-backdrop-filter: blur(50px) brightness(0.75);

        /* Very smooth gradient mask */
        mask-image: linear-gradient(to bottom, 
            transparent 0%, 
            rgba(0,0,0,0.02) 10%, 
            rgba(0,0,0,1) 100%
        );
        -webkit-mask-image: -webkit-linear-gradient(top, 
            transparent 0%, 
            rgba(0,0,0,0.02) 10%, 
            rgba(0,0,0,1) 100%
        );
        
        pointer-events: none;
    }

    /* --- BUTTONS & ARROW --- */
    .btn-dayunan-hero-light {
        background: #FFFFFF;
        color: #3A5F41;
        border: none;
        border-radius: 0;
        letter-spacing: 0.2rem;
        font-size: 0.7rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .btn-dayunan-hero-light:hover {
        background: #C26B4E; 
        color: #FFFFFF;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(194, 107, 78, 0.3);
    }

    .btn-dayunan-hero-outline {
        background: transparent;
        color: #FFFFFF;
        border: 1px solid rgba(255,255,255,0.8);
        border-radius: 0;
        letter-spacing: 0.2rem;
        font-size: 0.7rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-dayunan-hero-outline:hover {
        background: #C26B4E;
        border-color: #C26B4E;
        color: #FFFFFF;
        transform: translateY(-5px);
    }

    .pointing-arrow {
        display: inline-block;
        animation: arrowBounce 2s infinite;
        transition: transform 0.3s ease;
    }
    .btn-dayunan-hero-outline:hover .pointing-arrow {
        animation: none;
        transform: translateX(8px);
    }
    @keyframes arrowBounce {
        0%, 20%, 50%, 80%, 100% { transform: translateX(0); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(3px); }
    }

    /* --- TYPOGRAPHY & Z-INDEX --- */
    .z-3 { z-index: 3 !important; }
    .title-container { overflow: hidden; }
    
    .animate-slide-up-1 { animation: slideReveal 1.2s forwards; }
    .animate-slide-up-2 { animation: slideReveal 1.2s 0.3s forwards; opacity: 0; }
    .animate-fade-in-delayed { animation: fadeIn 1.5s 0.8s forwards; opacity: 0; }

    @keyframes slideReveal {
        from { opacity: 0; transform: translateY(80px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* --- IMAGE HOVER --- */
    .img-wrapper { overflow: hidden; }
    .reveal-img { transition: transform 1.2s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .img-wrapper:hover .reveal-img { transform: scale(1.08); }

    .text-terracotta-link {
        color: #C26B4E;
        transition: color 0.3s ease;
    }
</style>
@endsection