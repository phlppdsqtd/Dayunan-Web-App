@extends('layouts.app')

@section('content')
<div class="login-page-container">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-7 col-lg-5 col-xl-4">
                
                <div class="glass-card animate-in">
                    <div class="text-center mb-5 stagger-1">
                        <span class="text-terracotta khula fw-bold d-block mb-2" style="letter-spacing: 0.5rem; font-size: 0.6rem;">JOIN THE ESCAPE</span>
                        <h1 class="tenor-sans mb-3 text-jungle" style="font-size: 1.6rem; letter-spacing: 0.3rem;">Create Account</h1>
                        <div class="mx-auto" style="width: 40px; height: 1px; background: var(--sandstorm-beige); opacity: 0.5;"></div>
                    </div>

                    @if ($errors->any())
                        <div class="alert-aesthetic animate-shake">
                            <i class="bi bi-info-circle me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ url('/signup') }}" method="POST" id="signupForm">
                        @csrf
                        
                        <div class="input-group-aesthetic mb-4 stagger-2">
                            <label class="khula">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Juan Dela Cruz">
                            <div class="input-bar"></div>
                        </div>

                        <div class="input-group-aesthetic mb-4 stagger-3">
                            <label class="khula">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="juan@example.com">
                            <div class="input-bar"></div>
                        </div>

                  <div class="input-group-aesthetic mb-4">
    <label class="khula">Mobile Number</label>
    <input type="tel" 
           name="mobile"  id="phone" 
           required 
           placeholder="09123456789" 
           maxlength="11">
    <div class="input-bar"></div>
</div>

                        <div class="input-group-aesthetic mb-4 stagger-5">
                            <label class="khula">Password</label>
                            <input type="password" name="password" required placeholder="••••••••">
                            <div class="input-bar"></div>
                        </div>

                        <div class="input-group-aesthetic mb-5 stagger-6">
                            <label class="khula">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••">
                            <div class="input-bar"></div>
                        </div>

                        <button type="submit" class="btn-dayunan-lg w-100 stagger-7">
                            <span>Register Now</span>
                        </button>
                    </form>
                    
                    <div class="text-center mt-5 stagger-8">
                        <p class="khula text-muted small" style="letter-spacing: 0.1rem; font-size: 0.6rem;">
                            Already a member? 
                            <a href="{{ url('/login') }}" class="text-terracotta text-decoration-none fw-bold ms-1 link-underline">Login here</a>
                        </p>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>

<style>
    /* 1. Page Wrapper */
    .login-page-container {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
        background-color: var(--coconut-white);
    }

    /* 2. Glass Box Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        padding: 50px 45px;
        box-shadow: 0 40px 80px -15px rgba(58, 95, 65, 0.12);
        position: relative;
        z-index: 5;
        border-radius: 4px;
    }

    /* 3. Floating Background Orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(120px);
        z-index: 1;
        opacity: 0.3;
        animation: floatOrb 30s infinite alternate ease-in-out;
    }
    .orb-1 { width: 600px; height: 600px; background: var(--sandstorm-beige); top: -20%; left: -10%; }
    .orb-2 { width: 500px; height: 500px; background: var(--soft-bronze); bottom: -10%; right: -5%; animation-delay: -10s; }
    .orb-3 { width: 300px; height: 300px; background: var(--terracotta); top: 40%; left: 40%; opacity: 0.15; }

    @keyframes floatOrb {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(150px, 100px) scale(1.2); }
    }

    /* 4. Aesthetic Inputs */
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
        padding: 10px 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--jungle-green);
        outline: none;
    }
    .input-bar {
        width: 0%;
        height: 1.5px;
        background: var(--jungle-green);
        transition: width 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        margin: 0 auto;
    }
    .input-group-aesthetic input:focus + .input-bar {
        width: 100%;
    }

    /* 5. Custom Button */
    .btn-dayunan-lg {
        background: #3A5F41; /* Jungle Green */
        color: #FFFFFF; /* Coconut White */
        border: none;
        padding: 20px;
        font-family: 'Khula', sans-serif;
        text-transform: uppercase;
        letter-spacing: 0.4rem;
        font-size: 0.7rem;
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(58, 95, 65, 0.1);
    }

    .btn-dayunan-lg:hover {
        /* Ginhimo naton nga Terracotta para mas kitanon kag "high-contrast" */
        background: #C26B4E; /* Terracotta */
        color: #FFFFFF;
        letter-spacing: 0.55rem;
        transform: translateY(-5px);
        /* Nagdugang kita sang "glow" nga Terracotta para sa luxury effect */
        box-shadow: 0 15px 30px rgba(194, 107, 78, 0.25);
    }

    /* Active state para sa feedback kung i-click */
    .btn-dayunan-lg:active {
        background: #B08D57; /* Soft Bronze */
        transform: translateY(-2px);
    }

    /* 6. Staggered Entrance Animations */
    .animate-in [class*="stagger-"] { opacity: 0; }
    .stagger-1 { animation: fadeInUp 0.8s ease 0.1s forwards; }
    .stagger-2 { animation: fadeInUp 0.8s ease 0.15s forwards; }
    .stagger-3 { animation: fadeInUp 0.8s ease 0.2s forwards; }
    .stagger-4 { animation: fadeInUp 0.8s ease 0.25s forwards; }
    .stagger-5 { animation: fadeInUp 0.8s ease 0.3s forwards; }
    .stagger-6 { animation: fadeInUp 0.8s ease 0.35s forwards; }
    .stagger-7 { animation: fadeInUp 0.8s ease 0.4s forwards; }
    .stagger-8 { animation: fadeInUp 0.8s ease 0.45s forwards; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* 7. Error Alerts & Shake Animation */
    .alert-aesthetic {
        font-family: 'Khula', sans-serif;
        font-size: 0.65rem;
        color: #d9534f;
        background: rgba(217, 83, 79, 0.05);
        padding: 12px;
        margin-bottom: 25px;
        border-left: 2px solid #d9534f;
    }

    .animate-shake {
        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }
    @keyframes shake {
        10%, 90% { transform: translate3d(-1px, 0, 0); }
        20%, 80% { transform: translate3d(2px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
        40%, 60% { transform: translate3d(4px, 0, 0); }
    }

    .link-underline {
        position: relative;
        transition: color 0.3s;
    }
    .link-underline::after {
        content: ''; position: absolute; width: 0; height: 1px;
        bottom: -2px; left: 0; background: var(--terracotta);
        transition: width 0.3s ease;
    }
    .link-underline:hover::after { width: 100%; }
</style>

<script>
    // Enforce only digits in the phone field
    document.getElementById('phone').addEventListener('keypress', function(e) {
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });
</script>
@endsection