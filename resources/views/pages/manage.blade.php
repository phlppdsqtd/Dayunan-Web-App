@extends('layouts.app')

@section('content')
<div class="manage-page-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-7">
                
                <div class="contact-card p-5 shadow-lg animate-fade-up">
                    
                    @guest
                        <div class="text-center">
                            <span class="khula text-terracotta d-block mb-3" style="letter-spacing: 0.4rem; font-size: 0.7rem;">RETRIEVE STAY</span>
                            <h2 class="tenor-sans mb-5 text-jungle">Manage your journey.</h2>
                            
                            <form action="{{ route('manage.search') }}" method="POST" class="mt-4 px-lg-4">
                                @csrf
                                <div class="mb-5">
                                    <input type="email" name="email" 
                                           class="form-control aesthetic-input text-center py-3" 
                                           placeholder="Enter your registered email" required>
                                </div>
                                <button type="submit" class="btn btn-dayunan w-100 py-3 tenor-sans">Search Records</button>
                            </form>
                        </div>
                    @endguest

                    @auth
                        <div class="text-center mb-5">
                            <span class="khula text-terracotta d-block mb-2" style="letter-spacing: 0.3rem; font-size: 0.7rem;">WELCOME BACK</span>
                            <h2 class="tenor-sans text-jungle">{{ auth()->user()->name }}</h2>
                            <div class="mx-auto mt-3 accent-line"></div>
                        </div>

                        @if($bookings->count() > 0)
                            <div class="booking-list mt-4 text-start">
                                @foreach($bookings as $booking)
                                    <div class="p-4 border-bottom border-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="khula mb-0 fw-bold text-jungle" style="font-size: 0.8rem;">BOOKING #{{ $booking->id }}</p>
                                            <p class="cormorant text-muted mb-0">{{ $booking->check_in }} — {{ $booking->check_out }}</p>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-outline-dark khula" style="font-size: 0.6rem;">Details</a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-5 text-center">
                                <i class="bi bi-calendar-x text-muted opacity-25 display-4 mb-3 d-block"></i>
                                <p class="cormorant fst-italic text-muted" style="font-size: 1.2rem;">You haven't booked a stay with us yet.</p>
                                <a href="{{ url('/book') }}" class="btn btn-dayunan mt-3">Start Your Journey</a>
                            </div>
                        @endif
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Matches your Contact Page aesthetic */
    .aesthetic-input {
        border: none;
        border-bottom: 1px solid var(--sandstorm-beige);
        background: transparent;
        border-radius: 0;
        font-family: 'Khula', sans-serif;
    }
    .accent-line { width: 40px; height: 1px; background-color: var(--terracotta); }
</style>
@endsection