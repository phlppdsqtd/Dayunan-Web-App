@extends('layouts.app')

@section('content')
<div class="manage-search-wrapper d-flex align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="search-card p-5 text-center shadow-sm">
                    <span class="khula text-terracotta fw-bold d-block mb-3" style="letter-spacing: 0.4rem; font-size: 0.7rem; color: var(--terracotta);">ADMIN · EDIT BOOKING</span>
                    <h2 class="tenor-sans mb-2 text-jungle">{{ $booking->package->title ?? 'Booking' }}</h2>
                    <p class="cormorant text-muted fst-italic mb-5" style="font-size: 1rem;">
                        REF #{{ $booking->id }}
                    </p>

                    {{-- STATUS BUTTONS --}}
                    <div class="mb-5">
                        <label class="khula text-muted d-block mb-3" style="font-size: 0.6rem; letter-spacing: 0.2rem;">CHANGE STATUS</label>
                        <div class="d-flex gap-2">
                            <form action="{{ route('manage.status', $booking) }}" method="POST" style="flex:1;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" style="width:100%; padding: 8px; font-family:'Khula',sans-serif; font-size:0.6rem; letter-spacing:0.15rem; font-weight:700; border: 1px solid #3A5F41; background: {{ $booking->status === 'approved' ? '#3A5F41' : 'rgba(58,95,65,0.1)' }}; color: {{ $booking->status === 'approved' ? '#fff' : '#3A5F41' }}; cursor:pointer;">
                                    APPROVED
                                </button>
                            </form>
                            <form action="{{ route('manage.status', $booking) }}" method="POST" style="flex:1;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" style="width:100%; padding: 8px; font-family:'Khula',sans-serif; font-size:0.6rem; letter-spacing:0.15rem; font-weight:700; border: 1px solid #B08D57; background: {{ $booking->status === 'pending' ? '#B08D57' : 'rgba(176,141,87,0.1)' }}; color: {{ $booking->status === 'pending' ? '#fff' : '#B08D57' }}; cursor:pointer;">
                                    PENDING
                                </button>
                            </form>
                            <form action="{{ route('manage.status', $booking) }}" method="POST" style="flex:1;" onsubmit="return confirm('Cancel this booking?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" style="width:100%; padding: 8px; font-family:'Khula',sans-serif; font-size:0.6rem; letter-spacing:0.15rem; font-weight:700; border: 1px solid #C26B4E; background: {{ $booking->status === 'cancelled' ? '#C26B4E' : 'rgba(194,107,78,0.1)' }}; color: {{ $booking->status === 'cancelled' ? '#fff' : '#C26B4E' }}; cursor:pointer;">
                                    CANCELLED
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- MAIN EDIT FORM --}}
                    <form action="{{ route('manage.admin.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="check_out" id="check_out_hidden" value="{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}">

                        @if(session('success'))
                            <div class="mb-4 p-3" style="border-left: 3px solid #3A5F41; background: rgba(58,95,65,0.08); font-family:'Khula',sans-serif; font-size:0.65rem; color:#3A5F41; letter-spacing:0.1rem;">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">CHECK-IN DATE</label>
                            <input type="text" id="admin_check_in" name="check_in"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}" required>
                            @error('check_in')
                                <span class="khula text-danger" style="font-size: 0.65rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">CHECK-OUT DATE</label>
                            <div class="dropdown w-100">
                                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start aesthetic-input py-3"
                                        type="button"
                                        id="stayLengthDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="background: transparent; border: none; border-bottom: 1px solid var(--sandstorm-beige); border-radius: 0; font-family: 'Khula', sans-serif; font-size: 1rem;">
                                    {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} days ({{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }})
                                </button>
                                <ul class="dropdown-menu w-100" id="stayLengthOptions" style="max-height: 300px; overflow-y: auto;">
                                    <li><a class="dropdown-item disabled" href="#">Select check-in first</a></li>
                                </ul>
                            </div>
                            <div id="overlap-warning" style="display:none;" class="mt-2">
                                <span class="khula" style="font-size:0.65rem; letter-spacing:0.1rem; color:#B08D57;">
                                    THESE DATES OVERLAP AN EXISTING APPROVED BOOKING. PLEASE SELECT DIFFERENT DATES.
                                </span>
                            </div>
                            <div class="mt-2 small p-2" style="border-left: 3px solid #B08D57; background: rgba(176,141,87,0.08); color: #B08D57; font-family: 'Khula', sans-serif; letter-spacing: 0.05rem; font-size: 0.65rem;">
                                Encircled dates are booked. Stay max 7 days or until next booking.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">GUEST NAME</label>
                            <input type="text" name="guest_name"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ $booking->user?->name ?? $booking->guest_name ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">GUEST EMAIL</label>
                            <input type="email" name="guest_email"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ $booking->user?->email ?? $booking->guest_email ?? '' }}">
                        </div>

                        <div class="mb-5">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">GUEST PHONE</label>
                            <input type="text" name="guest_phone"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ $booking->user?->mobile ?? $booking->guest_phone ?? '' }}">
                        </div>

                        <button type="submit" id="save-btn" class="btn btn-dayunan w-100 py-3 tenor-sans" style="letter-spacing: 0.2rem;">
                            Save Changes
                        </button>

                        <a href="{{ route('manage.index') }}" class="d-block mt-4 khula text-muted text-decoration-none text-center" style="font-size: 0.65rem; letter-spacing: 0.15rem;">
                            BACK TO BOOKINGS
                        </a>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let blockedDates = [], checkInPicker;

    function styleCheckInDays() {
        setTimeout(function() {
            const el = document.getElementById('admin_check_in');
            if (!el || !el._flatpickr || !el._flatpickr.days) return;
            const fp = el._flatpickr;
            const today = new Date().toISOString().slice(0,10);
            fp.days.querySelectorAll('.flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)').forEach(function(day) {
                const dateStr = day.dateObj ?
                    day.dateObj.getFullYear() + '-' +
                    String(day.dateObj.getMonth()+1).padStart(2,'0') + '-' +
                    String(day.dateObj.getDate()).padStart(2,'0') : null;
                if (!dateStr) return;
                blockedDates.forEach(function(range) {
                    if (dateStr >= range.from && dateStr <= range.to && dateStr >= today) {
                        day.classList.add('disabled');
                        day.style.cssText = 'background:transparent !important; color:#B08D57 !important; border-radius:50% !important; border: 2px solid #B08D57 !important; opacity:1 !important; cursor:not-allowed !important;';
                        day.addEventListener('mouseover', function() {
                            this.style.cssText = 'background:transparent !important; color:#B08D57 !important; border-radius:50% !important; border: 2px solid #B08D57 !important; opacity:1 !important; cursor:not-allowed !important;';
                        });
                    }
                });
            });
        }, 100);
    }

    function checkOverlap(checkInStr, checkOutStr) {
        return blockedDates.some(function(range) {
            return checkInStr < range.to && checkOutStr > range.from;
        });
    }

    function daysBetween(start, end) {
        const s = new Date(start + 'T00:00:00');
        const e = new Date(end + 'T00:00:00');
        return Math.floor((e - s) / (1000 * 60 * 60 * 24));
    }

    function generateCheckOutDropdown(checkInStr) {
        const dropdownButton = document.getElementById('stayLengthDropdown');
        const optionsContainer = document.getElementById('stayLengthOptions');

        if (!checkInStr) return;

        const futureBlocked = blockedDates.filter(range => range.to >= checkInStr).sort((a,b) => a.from.localeCompare(b.from));
        const capStr = futureBlocked.length > 0 ? futureBlocked[0].from : null;
        const maxN = capStr ? Math.min(7, daysBetween(checkInStr, capStr) + 1) : 7;
        const maxDays = maxN;

        optionsContainer.innerHTML = '';

        if (maxDays < 1) {
            optionsContainer.innerHTML = '<li><a class="dropdown-item disabled" href="#">No available dates</a></li>';
            dropdownButton.textContent = 'No available dates';
            document.getElementById('check_out_hidden').value = '';
            updateSaveBtn();
            return;
        }

        for (let i = 1; i <= maxDays; i++) {
            const parts = checkInStr.split('-');
            const checkoutDate = new Date(parseInt(parts[0]), parseInt(parts[1])-1, parseInt(parts[2]) + i);
            const checkoutStr = checkoutDate.getFullYear() + '-' +
                String(checkoutDate.getMonth()+1).padStart(2,'0') + '-' +
                String(checkoutDate.getDate()).padStart(2,'0');
            const label = `${i} ${i === 1 ? 'day' : 'days'} (${checkoutStr})`;

            const li = document.createElement('li');
            const a = document.createElement('a');
            a.className = 'dropdown-item';
            a.href = '#';
            a.textContent = label;
            a.setAttribute('data-checkout-date', checkoutStr);
            a.setAttribute('data-days', i);

            a.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedDate = this.getAttribute('data-checkout-date');
                const selectedDays = this.getAttribute('data-days');

                if (checkOverlap(checkInStr, selectedDate)) {
                    document.getElementById('overlap-warning').style.display = 'block';
                    document.getElementById('check_out_hidden').value = '';
                    updateSaveBtn();
                    return;
                }

                document.getElementById('overlap-warning').style.display = 'none';
                document.getElementById('check_out_hidden').value = selectedDate;
                dropdownButton.textContent = `${selectedDays} days (${selectedDate})`;

                optionsContainer.querySelectorAll('.dropdown-item').forEach(item => item.classList.remove('active'));
                a.classList.add('active');

                updateSaveBtn();
            });

            li.appendChild(a);
            optionsContainer.appendChild(li);
        }
    }

    function updateSaveBtn() {
        const saveBtn = document.getElementById('save-btn');
        const checkInVal = document.getElementById('admin_check_in').value;
        const checkOutVal = document.getElementById('check_out_hidden').value;
        const warning = document.getElementById('overlap-warning');
        if (checkInVal && checkOutVal && warning.style.display !== 'block') {
            saveBtn.disabled = false;
            saveBtn.style.opacity = '1';
            saveBtn.style.cursor = 'pointer';
        } else {
            saveBtn.disabled = true;
            saveBtn.style.opacity = '0.5';
            saveBtn.style.cursor = 'not-allowed';
        }
    }

    fetch(`{{ route("api.blocked-dates") }}`)
        .then(r => r.json())
        .then(data => {
            blockedDates = data
                .filter(range => range.booking_id !== {{ $booking->id }})
                .map(range => ({ from: range.start_date, to: range.end_date }));

            const disableRanges = blockedDates.map(range => ({
                from: new Date(range.from + 'T00:00:00'),
                to: new Date(range.to + 'T00:00:00')
            }));

            checkInPicker = flatpickr("#admin_check_in", {
                dateFormat: "Y-m-d",
                defaultDate: "{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}",
                disable: disableRanges,
                onReady: styleCheckInDays,
                onMonthChange: styleCheckInDays,
                onChange: function(selectedDates) {
                    styleCheckInDays();
                    if (selectedDates[0]) {
                        const checkInStr = selectedDates[0].getFullYear() + '-' +
                            String(selectedDates[0].getMonth()+1).padStart(2,'0') + '-' +
                            String(selectedDates[0].getDate()).padStart(2,'0');
                        document.getElementById('check_out_hidden').value = '';
                        document.getElementById('overlap-warning').style.display = 'none';
                        generateCheckOutDropdown(checkInStr);
                    }
                    updateSaveBtn();
                }
            });

            // Generate dropdown for existing check-in
            generateCheckOutDropdown("{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}");
            updateSaveBtn();
        });
});
</script>

<style>
    .manage-search-wrapper { min-height: 70vh; }
    .search-card {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 202, 184, 0.3);
        border-radius: 0;
    }
    .aesthetic-input {
        border: none !important;
        border-bottom: 1px solid var(--sandstorm-beige) !important;
        background: transparent !important;
        border-radius: 0 !important;
        font-family: 'Khula', sans-serif;
        font-size: 1rem;
        box-shadow: none !important;
        transition: border-color 0.4s ease;
    }
    .aesthetic-input:focus { border-bottom: 1px solid var(--jungle-green) !important; }
    .tenor-sans { font-family: 'Tenor Sans', sans-serif; text-transform: uppercase; }
    .khula { font-family: 'Khula', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }
    .dropdown-menu {
        font-family: inherit !important;
        border-color: var(--terracotta);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .dropdown-item {
        font-family: inherit !important;
        font-size: 0.9rem;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }
    .dropdown-item:hover { background-color: #3A5F41; color: white; }
    .dropdown-item.active { background-color: #3A5F41; color: white; }
    .dropdown-item.disabled { opacity: 0.5; cursor: not-allowed; }
    #overlap-warning {
        border-left: 3px solid #B08D57;
        background: rgba(176, 141, 87, 0.08);
        padding: 10px 15px;
    }
    .flatpickr-day:not(.disabled):not(.prevMonthDay):not(.nextMonthDay):not(.flatpickr-disabled):hover {
        background: #3A5F41 !important;
        color: #fff !important;
        border-color: #3A5F41 !important;
        opacity: 0.8 !important;
    }
</style>
@endsection