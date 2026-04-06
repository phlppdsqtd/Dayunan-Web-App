@extends('layouts.app')

@section('content')
<div class="manage-page-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-9">
                
                <div class="contact-card p-5 shadow-lg animate-fade-up text-center">
                    
                    <section class="mb-5">
                        <span class="khula fw-bold text-terracotta mb-2 d-block animate-letter-spacing" style="letter-spacing: 0.4rem; font-size: 0.7rem;">YOUR BOOKINGS</span>
                        <h2 class="tenor-sans text-jungle display-5 mb-0">{{ $user?->name ?? 'Booking Details' }}</h2>
                        <div class="mx-auto mt-4 accent-line"></div>
                    </section>

                    @if($bookings->count() > 0)
                        <div class="booking-list text-start mt-4">
                            @foreach($bookings as $booking)
                                <div class="py-4 border-bottom border-light row-hover-effect">
                                    
                                    <div class="row align-items-center">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                            <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1.1rem; letter-spacing: 0.1rem;">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }} 
                                                <span class="mx-2 opacity-50" style="font-family: 'Cormorant Garamond', serif;">&mdash;</span> 
                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                            </h5>
                                        </div>

                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">TOTAL AMOUNT</span>
                                            <p class="khula text-jungle fw-bold mb-0" style="font-size: 1.2rem; letter-spacing: 0.05rem;">
                                                ₱{{ number_format($booking->total_price, 2) }}
                                            </p>
                                        </div>

                                        <div class="col-md-3 text-md-end">
                                            <div class="d-inline-block px-3 py-1 border border-jungle text-jungle khula" 
                                                 style="font-size: 0.55rem; letter-spacing: 0.15rem; background-color: rgba(58, 95, 65, 0.03); font-weight: 700;">
                                                {{ strtoupper($booking->status ?? 'Confirmed') }}
                                            </div>
                                            <p class="khula text-muted mt-2 mb-0" style="font-size: 0.55rem; letter-spacing: 0.1rem; opacity: 0.6;">
                                                REF #{{ $booking->id }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-3 pt-3 border-top" style="border-color: rgba(216, 202, 184, 0.2) !important;">
                                        <p class="tenor-sans text-terracotta mb-1" style="font-size: 0.9rem; font-weight: 600;">
                                            {{ $booking->package->title ?? 'Package Unavailable' }}
                                        </p>
                                        @if($booking->package && $booking->package->description)
                                            <p class="khula text-muted mb-0" style="font-size: 0.75rem; white-space: pre-line; line-height: 1.4;">{{ $booking->package->description }}</p>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-5">
                            <i class="bi bi-calendar-x text-muted opacity-25 display-4 mb-3 d-block"></i>
                            <p class="cormorant fst-italic text-muted" style="font-size: 1.2rem;">You haven't booked a stay with us yet.</p>
                            <a href="{{ url('/book') }}" class="btn btn-dayunan mt-3">Reserve Your Stay</a>
                        </div>
                    @endif

                    <div class="mt-5 pt-4 border-top border-light">
                        @guest
                            <a href="{{ route('manage.index') }}" class="btn btn-dayunan-outline px-4 py-3 tenor-sans" style="font-size: 0.7rem;">
                                Search Another Email
                            </a>
                        @endguest
                        @auth
                            <a href="{{ url('/') }}" class="khula text-jungle text-decoration-none small" style="letter-spacing: 0.2rem;">
                                <i class="bi bi-arrow-left me-2"></i> RETURN TO HOME
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- Core Layout CSS --- */
    .manage-page-wrapper {
        min-height: 85vh;
        background-color: var(--coconut-white);
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 202, 184, 0.4);
        border-radius: 0;
    }

    .accent-line {
        width: 40px;
        height: 1px;
        background-color: var(--terracotta);
    }

    /* --- Typography --- */
    .tenor-sans { font-family: 'Tenor Sans', sans-serif; text-transform: uppercase; }
    .khula { font-family: 'Khula', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

    /* --- Row Hover --- */
    .row-hover-effect {
        transition: all 0.3s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(216, 202, 184, 0.1);
        padding-left: 10px;
        padding-right: 10px;
    }

    /* --- Animations --- */
    .animate-fade-up {
        animation: fadeUp 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-letter-spacing {
        animation: letterSpace 2s ease forwards;
    }
    @keyframes letterSpace {
        from { letter-spacing: 0.1rem; opacity: 0; }
        to { letter-spacing: 0.4rem; opacity: 1; }
    }
</style>
@endsection