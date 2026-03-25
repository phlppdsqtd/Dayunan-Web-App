@extends('layouts.app')

@section('content')
<div class="login-page-container">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                
                <div class="glass-card animate-in">
                    <div class="text-center mb-5">
                        <span class="text-terracotta khula fw-bold d-block mb-2" style="letter-spacing: 0.5rem; font-size: 0.6rem;">PRIVATE ACCESS</span>
                        <h1 class="tenor-sans mb-3 text-jungle" style="font-size: 1.6rem; letter-spacing: 0.3rem;">Welcome Back</h1>
                        <div class="mx-auto" style="width: 40px; height: 1px; background: var(--sandstorm-beige); opacity: 0.5;"></div>
                    </div>

                    @if ($errors->any())
                        <div class="alert-aesthetic">
                            <i class="bi bi-info-circle me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="input-group-aesthetic mb-4">
                            <label class="khula">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="yourname@email.com">
                            <div class="input-bar"></div>
                        </div>

                        <div class="input-group-aesthetic mb-5">
                            <label class="khula">Password</label>
                            <input type="password" name="password" required placeholder="••••••••">
                            <div class="input-bar"></div>
                        </div>

                        <button type="submit" class="btn-dayunan-lg w-100">
                            <span>Sign In</span>
                        </button>
                    </form>
                    
                    <div class="text-center mt-5">
                        <p class="khula text-muted small" style="letter-spacing: 0.1rem; font-size: 0.6rem;">
                            New to Dayúnan? 
                            <a href="{{ url('/signup') }}" class="text-terracotta text-decoration-none fw-bold ms-1">Create Account</a>
                        </p>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>

<style>
    .login-page-container {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
        background-color: var(--coconut-white);
    }

    /* --- THE GLASS BOX EFFECT --- */
    .glass-card {
        background: rgba(255, 255, 255, 0.4); /* Semi-transparent */
        backdrop-filter: blur(20px); /* Frosted Glass effect */
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6); /* Soft highlight edge */
        padding: 60px 50px;
        box-shadow: 0 25px 50px -12px rgba(58, 95, 65, 0.15); /* Soft jungle-green shadow */
        position: relative;
        z-index: 5;
    }

    /* Floating Background Orbs */
    .orb {
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        filter: blur(100px);
        z-index: 1;
        opacity: 0.35;
        animation: floatOrb 25s infinite alternate ease-in-out;
    }
    .orb-1 { background: var(--sandstorm-beige); top: -15%; left: -10%; }
    .orb-2 { background: var(--soft-bronze); bottom: -15%; right: -10%; animation-delay: -7s; }

    @keyframes floatOrb {
        from { transform: translate(0, 0) scale(1); }
        to { transform: translate(120px, 80px) scale(1.1); }
    }

    /* Aesthetic Inputs */
    .input-group-aesthetic label {
        display: block;
        font-size: 0.55rem;
        color: var(--soft-bronze);
        margin-bottom: 5px;
        letter-spacing: 0.2rem;
    }
    .input-group-aesthetic input {
        width: 100%;
        border: none;
        background: transparent;
        padding: 12px 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--jungle-green);
        outline: none;
    }
    .input-bar {
        width: 100%;
        height: 1px;
        background: rgba(58, 95, 65, 0.1);
        transition: all 0.4s ease;
    }
    .input-group-aesthetic input:focus + .input-bar {
        background: var(--jungle-green);
        height: 1.5px;
    }

   /* Button Styling */
    .btn-dayunan-lg {
        background: #3A5F41; /* Jungle Green */
        color: #FFFFFF; /* Coconut White text */
        border: none;
        padding: 20px;
        font-family: 'Khula', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.4rem;
        font-size: 0.7rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(58, 95, 65, 0.2);
    }

    .btn-dayunan-lg:hover {
        /* Ginhimo naton nga Terracotta para "mag-pop" kag makita gid sang user */
        background: #C26B4E; /* Terracotta */
        color: #FFFFFF;
        letter-spacing: 0.5rem;
        transform: translateY(-3px);
        /* Nagdugang kita sang shadow nga nagasunod sa color sang Terracotta */
        box-shadow: 0 15px 30px rgba(194, 107, 78, 0.3);
    }

    /* Active state kung i-click ang button */
    .btn-dayunan-lg:active {
        background: #B08D57; /* Soft Bronze */
        transform: translateY(-1px);
    }

    /* Aesthetic link update para sa "Create Account" */
    .text-terracotta:hover {
        color: #B08D57 !important; /* Shifting to Soft Bronze on hover */
        text-decoration: underline !important;
    }

    /* Fade-in Animation */
    .animate-in {
        opacity: 0;
        animation: fadeInUp 1.2s ease forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-aesthetic {
        font-family: 'Khula', sans-serif;
        font-size: 0.65rem;
        color: #d9534f;
        background: rgba(217, 83, 79, 0.05);
        padding: 12px;
        margin-bottom: 30px;
        border-left: 2px solid #d9534f;
        letter-spacing: 0.05rem;
    }
</style>
@endsection