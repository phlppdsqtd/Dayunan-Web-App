@extends('layouts.app')

@section('content')
<div class="manage-search-wrapper d-flex align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                
                <div class="search-card p-5 text-center shadow-sm">
                    <span class="khula text-terracotta d-block mb-3 animate-fade-in" style="letter-spacing: 0.4rem; font-size: 0.7rem;">RETRIEVE BOOKING</span>
                    <h2 class="tenor-sans mb-5 text-jungle animate-slide-up">Manage your stay.</h2>
                    
                    <form action="{{ route('manage.search') }}" method="POST" class="mt-4 px-lg-4">
                        @csrf
                        <div class="mb-5 position-relative">
                            <input type="email" name="email" 
                                   class="form-control aesthetic-input text-center py-3" 
                                   placeholder="Enter your booking email" required>
                            <div class="input-focus-line"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-dayunan w-100 py-3 tenor-sans" style="letter-spacing: 0.2rem;">
                            Search Records
                        </button>
                    </form>

                    @if(session('error'))
                        <div class="mt-4 py-2 px-3 bg-light-danger animate-fade-in">
                            <p class="khula text-danger small mb-0" style="letter-spacing: 0.1rem;">{{ session('error') }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .manage-search-wrapper {
        min-height: 70vh; /* Keeps footer grounded */
    }

    .search-card {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 202, 184, 0.3);
        border-radius: 0;
    }

    /* Minimalist Input Style */
    .aesthetic-input {
        border: none !important;
        border-bottom: 1px solid var(--sandstorm-beige) !important;
        background: transparent !important;
        border-radius: 0 !important;
        font-family: 'Khula', sans-serif;
        font-size: 1rem;
        letter-spacing: 0.05rem;
        box-shadow: none !important;
        transition: border-color 0.4s ease;
    }

    .aesthetic-input:focus {
        border-bottom: 1px solid var(--jungle-green) !important;
    }

    .aesthetic-input::placeholder {
        text-transform: uppercase;
        font-size: 0.65rem;
        letter-spacing: 0.15rem;
        opacity: 0.5;
    }

    /* Animations */
    .animate-slide-up { animation: slideUp 0.8s ease forwards; }
    .animate-fade-in { animation: fadeIn 1.2s ease forwards; }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endsection