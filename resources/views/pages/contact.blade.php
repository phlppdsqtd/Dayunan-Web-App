@extends('layouts.app')

@section('content')
<div class="contact-page-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="container py-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-8">
                
                <div class="contact-card p-5 text-center shadow-lg animate-fade-up">
                    
                    <section class="mb-5">
                        <span class="khula fw-bold text-terracotta mb-2 d-block animate-letter-spacing" style="letter-spacing: 0.4rem; font-size: 0.7rem;">CONNECT</span>
                        <h2 class="tenor-sans text-jungle display-5 mb-0">A personal touch.</h2>
                        <div class="mx-auto mt-4 accent-line"></div>
                    </section>

                    @if($contacts && $contacts->count() > 0)
                        <div class="row g-4 justify-content-center mb-4">
                            @foreach($contacts as $contact)
                                <div class="col-md-6 mb-4">
                                    <div class="contact-details-wrapper py-3 px-2 border-end border-start border-light">
                                        <div class="mb-4">
                                            <h4 class="tenor-sans text-jungle mb-1" style="font-size: 1.4rem; letter-spacing: 0.1rem;">{{ $contact->name }}</h4>
                                            <p class="cormorant text-muted fst-italic mb-0" style="font-size: 1.1rem;">
                                                {{ $contact->role }} {{ $contact->staff_type }}
                                            </p>
                                        </div>

                                        <div class="d-flex flex-column gap-2">
                                            <a href="mailto:{{ $contact->email }}" class="contact-link text-decoration-none" style="font-size: 0.9rem;">
                                                <i class="bi bi-envelope me-2 opacity-50"></i>{{ $contact->email }}
                                            </a>
                                            <a href="tel:{{ $contact->contact_number }}" class="contact-link text-decoration-none" style="font-size: 0.9rem;">
                                                <i class="bi bi-telephone me-2 opacity-50"></i>{{ $contact->contact_number }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-5">
                            <p class="cormorant fst-italic text-muted" style="font-size: 1.2rem;">Currently awaiting management details.</p>
                        </div>
                    @endif

                    <div class="mt-4 pt-4 border-top border-light">
                        <p class="khula small text-muted mb-4" style="letter-spacing: 0.15rem; font-size: 0.65rem;">FOR IMMEDIATE ASSISTANCE</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="https://m.me/dayunan.bcd" target="_blank" class="btn btn-dayunan-outline px-4 py-3 tenor-sans">
                                Messenger
                            </a>
                            <a href="https://www.facebook.com/dayunan.bcd" target="_blank" class="btn btn-dayunan-outline px-4 py-3 tenor-sans">
                                Facebook
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5 animate-fade-in">
                    <p class="khula text-muted small" style="letter-spacing: 0.3rem;">BACOLOD CITY &bull; NEGROS OCCIDENTAL</p>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Aesthetic Styling */
    .contact-page-wrapper {
        min-height: 80vh;
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(216, 202, 184, 0.3);
        border-radius: 0;
    }

    .accent-line {
        width: 40px;
        height: 1px;
        background-color: var(--terracotta);
        transition: width 0.8s ease;
    }

    .contact-card:hover .accent-line {
        width: 80px;
    }

    .contact-link {
        font-family: 'Khula', sans-serif;
        color: var(--jungle-green);
        letter-spacing: 0.1rem;
        transition: all 0.3s ease;
    }

    .contact-link:hover {
        color: var(--terracotta);
        transform: translateX(3px);
    }

    .btn-dayunan-outline {
        border: 1px solid var(--jungle-green);
        color: var(--jungle-green);
        background: transparent;
        border-radius: 0;
        font-size: 0.7rem;
        letter-spacing: 0.2rem;
        transition: all 0.4s ease;
        min-width: 160px;
    }

    .btn-dayunan-outline:hover {
        background-color: var(--jungle-green);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Animations */
    .animate-fade-up {
        animation: fadeUp 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }

    .animate-letter-spacing {
        animation: letterSpace 2s ease forwards;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes letterSpace {
        from { letter-spacing: 0.1rem; opacity: 0; }
        to { letter-spacing: 0.4rem; opacity: 1; }
    }

    .animate-fade-in { animation: fadeIn 2s ease forwards; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection