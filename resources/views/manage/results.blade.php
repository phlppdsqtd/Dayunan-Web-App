@extends('layouts.app')

@section('content')
<div class="manage-page-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11 col-lg-9">

                <div class="contact-card p-5 shadow-lg animate-fade-up text-center">

                    <section class="mb-5">
                        <span class="khula fw-bold text-terracotta mb-2 d-block animate-letter-spacing" style="letter-spacing: 0.4rem; font-size: 0.7rem;">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    ALL SYSTEM BOOKINGS
                                @else
                                    YOUR BOOKINGS
                                @endif
                            @else
                                YOUR BOOKINGS
                            @endauth
                        </span>
                        <h2 class="tenor-sans text-jungle display-5 mb-0">{{ $user?->name ?? 'Booking Details' }}</h2>
                        <div class="mx-auto mt-4 accent-line"></div>
                    </section>

                    @if(session('success'))
                        <div class="alert-dayunan success mb-4">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert-dayunan error mb-4">{{ session('error') }}</div>
                    @endif

                    @if($bookings->count() > 0)
                        <div class="booking-list text-start mt-4">

                            @auth
                                @if(auth()->user()->role === 'admin')
                                    {{-- ADMIN: grouped by package --}}
                                    @foreach($bookings->groupBy(fn($b) => $b->package->title ?? 'Unknown Package') as $packageTitle => $packageBookings)
                                        <div class="mb-5">
                                            <div class="package-group-header mb-3 pb-2">
                                                <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.3rem; font-weight: 700;">ACCOMMODATION</span>
                                                <h4 class="tenor-sans text-jungle mb-0" style="font-size: 1.1rem;">{{ $packageTitle }}</h4>
                                            </div>

                                            @foreach($packageBookings as $booking)
                                                <div class="py-4 border-bottom border-light row-hover-effect">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4 mb-3 mb-md-0">
                                                            <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                                            <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1rem; letter-spacing: 0.1rem;">
                                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                                                <span class="mx-2 opacity-50">&mdash;</span>
                                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                                            </h5>
                                                            <span class="khula text-muted d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                                {{ $booking->user?->name ?? $booking->guest_name ?? 'Guest' }} &middot; {{ $booking->user?->email ?? $booking->guest_email }}
                                                            </span>
                                                        </div>

                                                        <div class="col-md-3 mb-3 mb-md-0">
                                                            <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">TOTAL AMOUNT</span>
                                                            <p class="khula text-jungle fw-bold mb-0" style="font-size: 1.2rem;">
                                                                ₱{{ number_format($booking->total_price, 2) }}
                                                            </p>
                                                        </div>

                                                        <div class="col-md-2 mb-3 mb-md-0 text-md-center">
                                                            <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STATUS</span>
                                                            <div class="status-badge status-{{ $booking->status }}">
                                                                {{ strtoupper($booking->status ?? 'PENDING') }}
                                                            </div>
                                                            <p class="khula text-muted mt-1 mb-0" style="font-size: 0.55rem; letter-spacing: 0.1rem;">REF #{{ $booking->id }}</p>
                                                        </div>

                                                        <div class="col-md-3 text-md-end">
                                                            <div class="d-flex flex-column gap-2 align-items-end">
                                                                {{-- Mark Approved / Mark Pending toggle --}}
                                                                @if($booking->status === 'pending')
                                                                    <form action="{{ route('manage.status', $booking) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="status" value="approved">
                                                                        <button type="submit" class="btn-action update">Mark Approved</button>
                                                                    </form>
                                                                @elseif($booking->status === 'approved')
                                                                    <form action="{{ route('manage.status', $booking) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="status" value="pending">
                                                                        <button type="submit" class="btn-action pending">Mark Pending</button>
                                                                    </form>
                                                                @endif
                                                                {{-- Cancel if not already cancelled --}}
                                                                @if($booking->status !== 'cancelled')
                                                                    <form action="{{ route('manage.status', $booking) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="status" value="cancelled">
                                                                        <button type="submit" class="btn-action delete" onclick="return confirm('Cancel this booking?')">Cancel</button>
                                                                    </form>
                                                                @endif
                                                                {{-- Edit button --}}
                                                                <a href="{{ route('manage.admin.edit', $booking) }}" class="btn-action edit">Edit</a>
                                                                {{-- Delete --}}
                                                                <form action="{{ route('manage.destroy', $booking) }}" method="POST"
                                                                      onsubmit="return confirm('Permanently delete this booking?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn-action delete">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

                                @else
                                    {{-- CUSTOMER: flat list --}}
                                    @foreach($bookings as $booking)
                                        <div class="py-4 border-bottom border-light row-hover-effect">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                                    <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1rem; letter-spacing: 0.1rem;">
                                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                                        <span class="mx-2 opacity-50">&mdash;</span>
                                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                                    </h5>
                                                </div>

                                                <div class="col-md-3 mb-3 mb-md-0">
                                                    <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">TOTAL AMOUNT</span>
                                                    <p class="khula text-jungle fw-bold mb-0" style="font-size: 1.2rem;">
                                                        ₱{{ number_format($booking->total_price, 2) }}
                                                    </p>
                                                </div>

                                                <div class="col-md-2 mb-3 mb-md-0 text-md-center">
                                                    <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STATUS</span>
                                                    <div class="status-badge status-{{ $booking->status }}">
                                                        {{ strtoupper($booking->status ?? 'PENDING') }}
                                                    </div>
                                                    <p class="khula text-muted mt-1 mb-0" style="font-size: 0.55rem; letter-spacing: 0.1rem;">REF #{{ $booking->id }}</p>
                                                </div>

                                                <div class="col-md-3 text-md-end">
                                                    @if($booking->status === 'pending')
                                                        <div class="d-flex flex-column gap-2 align-items-end">
                                                            <a href="{{ route('manage.edit', $booking) }}" class="btn-action update">Edit</a>
                                                            <form action="{{ route('manage.cancel', $booking) }}" method="POST"
                                                                  onsubmit="return confirm('Cancel this booking?')">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn-action delete">Cancel</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-3 pt-3 border-top" style="border-color: rgba(216, 202, 184, 0.2) !important;">
                                                <p class="tenor-sans text-terracotta mb-1" style="font-size: 0.9rem; font-weight: 600;">
                                                    {{ $booking->package->title ?? 'Package Unavailable' }}
                                                </p>
                                                @if($booking->package && $booking->package->description)
                                                    <p class="khula text-muted mb-0" style="font-size: 0.75rem; line-height: 1.4;">{{ $booking->package->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            @else
                                {{-- GUEST: flat list --}}
                                @foreach($bookings as $booking)
                                    <div class="py-4 border-bottom border-light row-hover-effect">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 mb-3 mb-md-0">
                                                <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                                <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1rem; letter-spacing: 0.1rem;">
                                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                                    <span class="mx-2 opacity-50">&mdash;</span>
                                                    {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                                </h5>
                                            </div>
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">TOTAL AMOUNT</span>
                                                <p class="khula text-jungle fw-bold mb-0" style="font-size: 1.2rem;">
                                                    ₱{{ number_format($booking->total_price, 2) }}
                                                </p>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                                <div class="status-badge status-{{ $booking->status }}">
                                                    {{ strtoupper($booking->status ?? 'PENDING') }}
                                                </div>
                                                <p class="khula text-muted mt-1 mb-0" style="font-size: 0.55rem; letter-spacing: 0.1rem;">REF #{{ $booking->id }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-top" style="border-color: rgba(216, 202, 184, 0.2) !important;">
                                            <p class="tenor-sans text-terracotta mb-1" style="font-size: 0.9rem; font-weight: 600;">
                                                {{ $booking->package->title ?? 'Package Unavailable' }}
                                            </p>
                                            @if($booking->package && $booking->package->description)
                                                <p class="khula text-muted mb-0" style="font-size: 0.75rem; line-height: 1.4;">{{ $booking->package->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endauth

                        </div>
                    @else
                        <div class="py-5">
                            <i class="bi bi-calendar-x text-muted opacity-25 display-4 mb-3 d-block"></i>
                            <p class="cormorant fst-italic text-muted" style="font-size: 1.2rem;">No bookings found.</p>
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
    .manage-page-wrapper { min-height: 85vh; background-color: var(--coconut-white); }
    .contact-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 202, 184, 0.4);
        border-radius: 0;
    }
    .accent-line { width: 40px; height: 1px; background-color: var(--terracotta); }
    .tenor-sans { font-family: 'Tenor Sans', sans-serif; text-transform: uppercase; }
    .khula { font-family: 'Khula', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }
    .row-hover-effect { transition: all 0.3s ease; }
    .row-hover-effect:hover { background-color: rgba(216, 202, 184, 0.1); padding-left: 10px; padding-right: 10px; }
    .package-group-header { border-bottom: 1px solid rgba(216, 202, 184, 0.5); }
    .status-badge {
        display: inline-block;
        padding: 2px 10px;
        font-family: 'Khula', sans-serif;
        font-size: 0.55rem;
        letter-spacing: 0.15rem;
        font-weight: 700;
    }
    .status-pending { background: rgba(176, 141, 87, 0.1); color: #B08D57; border: 1px solid #B08D57; }
    .status-approved { background: rgba(58, 95, 65, 0.1); color: #3A5F41; border: 1px solid #3A5F41; }
    .status-cancelled { background: rgba(194, 107, 78, 0.1); color: #C26B4E; border: 1px solid #C26B4E; }
    .btn-action {
        display: inline-block;
        padding: 4px 14px;
        font-family: 'Khula', sans-serif;
        font-size: 0.6rem;
        letter-spacing: 0.15rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-action.update { background: #3A5F41; color: white; }
    .btn-action.update:hover { background: #2e4d34; }
    .btn-action.pending { background: #B08D57; color: white; }
    .btn-action.pending:hover { background: #9a7a4a; }
    .btn-action.edit { background: #5b7fa6; color: white; }
    .btn-action.edit:hover { background: #4a6d90; }
    .btn-action.delete { background: #C26B4E; color: white; }
    .btn-action.delete:hover { background: #a85a3f; }
    .alert-dayunan { padding: 10px 20px; font-family: 'Khula', sans-serif; font-size: 0.75rem; letter-spacing: 0.1rem; }
    .alert-dayunan.success { background: rgba(58, 95, 65, 0.08); color: #3A5F41; border-left: 3px solid #3A5F41; }
    .alert-dayunan.error { background: rgba(194, 107, 78, 0.08); color: #C26B4E; border-left: 3px solid #C26B4E; }
    .animate-fade-up { animation: fadeUp 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-letter-spacing { animation: letterSpace 2s ease forwards; }
    @keyframes letterSpace { from { letter-spacing: 0.1rem; opacity: 0; } to { letter-spacing: 0.4rem; opacity: 1; } }
</style>
@endsection