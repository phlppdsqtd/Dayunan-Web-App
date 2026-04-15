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

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div class="mb-4 d-flex gap-2 flex-wrap justify-content-center">
                                <input type="text" id="search-ref" class="filter-select khula" placeholder="SEARCH REF #" oninput="filterBookings()" style="width: 130px;">
                                <select id="filter-status" class="filter-select khula" onchange="filterBookings()">
                                    <option value="">ALL STATUS</option>
                                    <option value="pending">PENDING</option>
                                    <option value="approved">APPROVED</option>
                                    <option value="cancelled">CANCELLED</option>
                                </select>
                                <select id="filter-package" class="filter-select khula" onchange="filterBookings()">
                                    <option value="">ALL PACKAGES</option>
                                    @foreach($packages as $package)
                                        <option value="{{ strtolower($package->title) }}">{{ strtoupper($package->title) }}</option>
                                    @endforeach
                                </select>
                                <select id="sort-date" class="filter-select khula" onchange="filterBookings()">
                                    <option value="recent">RECENTLY BOOKED</option>
                                    <option value="asc">CHECK-IN: ASCENDING</option>
                                    <option value="desc">CHECK-IN: DESCENDING</option>
                                </select>
                            </div>
                        @else
                            <div class="mb-4 d-flex gap-2 flex-wrap justify-content-center">
                                <input type="text" id="user-search-ref" class="filter-select khula" placeholder="SEARCH REF #" oninput="filterUserRows()" style="width: 130px;">
                                <select id="user-filter-status" class="filter-select khula" onchange="filterUserRows()">
                                    <option value="">ALL STATUS</option>
                                    <option value="pending">PENDING</option>
                                    <option value="approved">APPROVED</option>
                                    <option value="cancelled">CANCELLED</option>
                                </select>
                                <select id="user-sort-date" class="filter-select khula" onchange="filterUserRows()">
                                    <option value="recent">RECENTLY BOOKED</option>
                                    <option value="asc">CHECK-IN: ASCENDING</option>
                                    <option value="desc">CHECK-IN: DESCENDING</option>
                                </select>
                            </div>
                        @endif
                    @else
                        <div class="mb-4 d-flex gap-2 flex-wrap justify-content-center">
                            <input type="text" id="user-search-ref" class="filter-select khula" placeholder="SEARCH REF #" oninput="filterUserRows()" style="width: 130px;">
                            <select id="user-filter-status" class="filter-select khula" onchange="filterUserRows()">
                                <option value="">ALL STATUS</option>
                                <option value="pending">PENDING</option>
                                <option value="approved">APPROVED</option>
                                <option value="cancelled">CANCELLED</option>
                            </select>
                            <select id="user-sort-date" class="filter-select khula" onchange="filterUserRows()">
                                <option value="recent">RECENTLY BOOKED</option>
                                <option value="asc">CHECK-IN: ASCENDING</option>
                                <option value="desc">CHECK-IN: DESCENDING</option>
                            </select>
                        </div>
                    @endauth

                    @if($bookings->count() > 0)
                        <div class="booking-list text-start mt-4" id="booking-list">

                            @auth
                                @if(auth()->user()->role === 'admin')
                                    {{-- ADMIN: flat list sorted by date --}}
                                    @foreach($bookings as $booking)
                                        <div class="py-4 border-bottom border-light row-hover-effect booking-row"
                                            data-status="{{ $booking->status }}"
                                            data-package="{{ strtolower($booking->package->title ?? '') }}"
                                            data-date="{{ $booking->check_in->timestamp }}"
                                            data-created="{{ $booking->created_at->timestamp }}"
                                            data-ref="{{ $booking->id }}">
                                            <div class="row align-items-start">
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                                    <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1rem; letter-spacing: 0.1rem;">
                                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                                        <span class="mx-2 opacity-50">&mdash;</span>
                                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                                    </h5>
                                                    <span class="khula text-muted d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                        {{ $booking->user?->name ?? $booking->guest_name ?? 'Guest' }}
                                                    </span>
                                                    <span class="khula text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                        {{ $booking->user?->email ?? $booking->guest_email }}
                                                    </span>
                                                    @if($booking->user?->mobile ?? $booking->guest_phone)
                                                        <span class="khula text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                            {{ $booking->user?->mobile ?? $booking->guest_phone }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-md-3 mb-3 mb-md-0">
                                                    <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">PACKAGE</span>
                                                    <p class="tenor-sans text-jungle mb-1" style="font-size: 0.8rem; letter-spacing: 0.05rem;">
                                                        {{ $booking->package->title ?? 'Package Unavailable' }}
                                                    </p>
                                                    <p class="khula text-jungle fw-bold mb-2" style="font-size: 1rem;">
                                                        ₱{{ number_format($booking->total_price, 2) }}
                                                    </p>
                                                    @if($booking->package && $booking->package->description)
                                                        @php
                                                            $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $booking->package->description)));
                                                        @endphp
                                                        <a href="#" class="khula d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem; text-decoration:none; color: #3A5F41;" onclick="toggleDetails(this); return false;">VIEW DETAILS ▾</a>
                                                        <ul class="khula text-muted mb-0 ps-3 package-details" style="font-size: 0.7rem; line-height: 1.8; display:none;">
                                                            @foreach($lines as $line)
                                                                <li>{{ preg_replace('/^[^\w\d\(]+/', '', $line) }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
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
                                                        <a href="{{ route('manage.admin.edit', $booking) }}" class="btn-action edit">Edit</a>
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

                                @else
                                    {{-- CUSTOMER: flat list --}}
                                    @foreach($bookings as $booking)
                                        <div class="py-4 border-bottom border-light row-hover-effect user-row"
                                            data-ref="{{ $booking->id }}"
                                            data-status="{{ $booking->status }}"
                                            data-date="{{ $booking->check_in->timestamp }}"
                                            data-created="{{ $booking->created_at->timestamp }}">
                                            <div class="row align-items-start">
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                                    <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1rem; letter-spacing: 0.1rem;">
                                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                                        <span class="mx-2 opacity-50">&mdash;</span>
                                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                                    </h5>
                                                    <span class="khula text-muted d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                        {{ $booking->user?->name ?? $booking->guest_name ?? 'Guest' }}
                                                    </span>
                                                    <span class="khula text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                        {{ $booking->user?->email ?? $booking->guest_email ?? '' }}
                                                    </span>
                                                    @if($booking->user?->mobile ?? $booking->guest_phone)
                                                        <span class="khula text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                            {{ $booking->user?->mobile ?? $booking->guest_phone }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-md-3 mb-3 mb-md-0">
                                                    <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">PACKAGE</span>
                                                    <p class="tenor-sans text-jungle mb-1" style="font-size: 0.8rem; letter-spacing: 0.05rem;">
                                                        {{ $booking->package->title ?? 'Package Unavailable' }}
                                                    </p>
                                                    <p class="khula text-jungle fw-bold mb-2" style="font-size: 1rem;">
                                                        ₱{{ number_format($booking->total_price, 2) }}
                                                    </p>
                                                    @if($booking->package && $booking->package->description)
                                                        @php
                                                            $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $booking->package->description)));
                                                        @endphp
                                                        <a href="#" class="khula d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem; text-decoration:none; color: #3A5F41;" onclick="toggleDetails(this); return false;">VIEW DETAILS ▾</a>
                                                        <ul class="khula text-muted mb-0 ps-3 package-details" style="font-size: 0.7rem; line-height: 1.8; display:none;">
                                                            @foreach($lines as $line)
                                                                <li>{{ preg_replace('/^[^\w\d\(]+/', '', $line) }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
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
                                        </div>
                                    @endforeach
                                @endif

                            @else
                                {{-- GUEST: flat list --}}
                                @foreach($bookings as $booking)
                                    <div class="py-4 border-bottom border-light row-hover-effect user-row"
                                        data-ref="{{ $booking->id }}"
                                        data-status="{{ $booking->status }}"
                                        data-date="{{ $booking->check_in->timestamp }}"
                                        data-created="{{ $booking->created_at->timestamp }}">
                                        <div class="row align-items-start">
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <span class="khula text-terracotta d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STAY DATES</span>
                                                <h5 class="tenor-sans text-jungle mb-0" style="font-size: 1rem; letter-spacing: 0.1rem;">
                                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                                    <span class="mx-2 opacity-50">&mdash;</span>
                                                    {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                                </h5>
                                                <span class="khula text-muted d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                    {{ $booking->user?->name ?? $booking->guest_name ?? 'Guest' }}
                                                </span>
                                                <span class="khula text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                    {{ $booking->user?->email ?? $booking->guest_email ?? '' }}
                                                </span>
                                                @if($booking->user?->mobile ?? $booking->guest_phone)
                                                    <span class="khula text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.1rem;">
                                                        {{ $booking->user?->mobile ?? $booking->guest_phone }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3 mb-3 mb-md-0">
                                                <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">PACKAGE</span>
                                                <p class="tenor-sans text-jungle mb-1" style="font-size: 0.8rem; letter-spacing: 0.05rem;">
                                                    {{ $booking->package->title ?? 'Package Unavailable' }}
                                                </p>
                                                <p class="khula text-jungle fw-bold mb-2" style="font-size: 1rem;">
                                                    ₱{{ number_format($booking->total_price, 2) }}
                                                </p>
                                                @if($booking->package && $booking->package->description)
                                                    @php
                                                        $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $booking->package->description)));
                                                    @endphp
                                                    <a href="#" class="khula d-block mt-1" style="font-size: 0.6rem; letter-spacing: 0.1rem; text-decoration:none; color: #3A5F41;" onclick="toggleDetails(this); return false;">VIEW DETAILS ▾</a>
                                                    <ul class="khula text-muted mb-0 ps-3 package-details" style="font-size: 0.7rem; line-height: 1.8; display:none;">
                                                        @foreach($lines as $line)
                                                            <li>{{ preg_replace('/^[^\w\d\(]+/', '', $line) }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="col-md-2 mb-3 mb-md-0 text-md-center">
                                                <span class="khula text-muted d-block mb-1" style="font-size: 0.6rem; letter-spacing: 0.2rem; font-weight: 700;">STATUS</span>
                                                <div class="status-badge status-{{ $booking->status }}">
                                                    {{ strtoupper($booking->status ?? 'PENDING') }}
                                                </div>
                                                <p class="khula text-muted mt-1 mb-0" style="font-size: 0.55rem; letter-spacing: 0.1rem;">REF #{{ $booking->id }}</p>
                                            </div>
                                            <div class="col-md-3 text-md-end">
                                            </div>
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
                            <a href="{{ url('/') }}" class="khula text-decoration-none small" style="letter-spacing: 0.2rem; color: #3A5F41;">
                                <i class="bi bi-arrow-left me-2"></i> RETURN TO HOME
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterBookings() {
    const status = document.getElementById('filter-status')?.value.toLowerCase();
    const pkg = document.getElementById('filter-package')?.value.toLowerCase();
    const sort = document.getElementById('sort-date')?.value;
    const ref = document.getElementById('search-ref')?.value.toLowerCase().replace('#', '');

    const rows = Array.from(document.querySelectorAll('.booking-row'));

    if (sort === 'asc') {
        rows.sort((a, b) => parseInt(a.dataset.date) - parseInt(b.dataset.date));
    } else if (sort === 'recent') {
        rows.sort((a, b) => parseInt(b.dataset.created) - parseInt(a.dataset.created));
    } else {
        rows.sort((a, b) => parseInt(b.dataset.date) - parseInt(a.dataset.date));
    }

    const container = document.getElementById('booking-list');
    rows.forEach(row => container.appendChild(row));

    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const rowPkg = row.dataset.package;
        const statusMatch = !status || rowStatus === status;
        const pkgMatch = !pkg || rowPkg.includes(pkg);
        const rowRef = row.dataset.ref || '';
        const refMatch = !ref || rowRef.includes(ref);
        row.style.display = (statusMatch && pkgMatch && refMatch) ? '' : 'none';
    });
}

function filterUserRows() {
    const ref = document.getElementById('user-search-ref')?.value.toLowerCase().replace('#', '');
    const status = document.getElementById('user-filter-status')?.value.toLowerCase();
    const sort = document.getElementById('user-sort-date')?.value;

    const rows = Array.from(document.querySelectorAll('.user-row'));

    if (sort === 'asc') {
        rows.sort((a, b) => parseInt(a.dataset.date) - parseInt(b.dataset.date));
    } else if (sort === 'recent') {
        rows.sort((a, b) => parseInt(b.dataset.created) - parseInt(a.dataset.created));
    } else {
        rows.sort((a, b) => parseInt(b.dataset.date) - parseInt(a.dataset.date));
    }

    const container = document.getElementById('booking-list');
    rows.forEach(row => container.appendChild(row));

    rows.forEach(row => {
        const rowRef = row.dataset.ref || '';
        const rowStatus = row.dataset.status || '';
        const refMatch = !ref || rowRef.includes(ref);
        const statusMatch = !status || rowStatus === status;
        row.style.display = (refMatch && statusMatch) ? '' : 'none';
    });
}

function toggleDetails(el) {
    const ul = el.nextElementSibling;
    if (ul.style.display === 'none') {
        ul.style.display = 'block';
        el.textContent = 'HIDE DETAILS ▴';
    } else {
        ul.style.display = 'none';
        el.textContent = 'VIEW DETAILS ▾';
    }
}
</script>

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
    .btn-action.edit { background: #3A5F41; color: white; }
    .btn-action.edit:hover { background: #2e4d34; }
    .btn-action.delete { background: #C26B4E; color: white; }
    .btn-action.delete:hover { background: #a85a3f; }
    .alert-dayunan { padding: 10px 20px; font-family: 'Khula', sans-serif; font-size: 0.75rem; letter-spacing: 0.1rem; }
    .alert-dayunan.success { background: rgba(58, 95, 65, 0.08); color: #3A5F41; border-left: 3px solid #3A5F41; }
    .alert-dayunan.error { background: rgba(194, 107, 78, 0.08); color: #C26B4E; border-left: 3px solid #C26B4E; }
    .filter-select {
        font-size: 0.6rem;
        letter-spacing: 0.15rem;
        border: 1px solid rgba(216, 202, 184, 0.6);
        padding: 6px 12px;
        background: white;
        color: #3A5F41;
        cursor: pointer;
    }
    .filter-select:focus { outline: none; border-color: #3A5F41; }
    .animate-fade-up { animation: fadeUp 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-letter-spacing { animation: letterSpace 2s ease forwards; }
    @keyframes letterSpace { from { letter-spacing: 0.1rem; opacity: 0; } to { letter-spacing: 0.4rem; opacity: 1; } }
</style>
@endsection