@extends('layouts.app')
@section('content')
<div class="manage-search-wrapper d-flex align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="search-card p-5 text-center shadow-sm">
                    <span class="khula text-terracotta d-block mb-3" style="letter-spacing: 0.4rem; font-size: 0.7rem;">EDIT BOOKING</span>
                    <h2 class="tenor-sans mb-2 text-jungle">Adjust your stay.</h2>
                    <p class="cormorant text-muted fst-italic mb-5" style="font-size: 1rem;">REF #{{ $booking->id }} &middot; {{ $booking->package->title ?? 'Package' }}</p>

                    <form action="{{ route('manage.update', $booking) }}" method="POST" class="mt-4 px-lg-4">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 text-start">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">CHECK-IN DATE</label>
                            <input type="text" id="check_in" name="check_in"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}" required>
                            @error('check_in')
                                <span class="khula text-danger" style="font-size: 0.65rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-2 text-start">
                            <label class="khula text-muted d-block mb-2" style="font-size: 0.6rem; letter-spacing: 0.2rem;">CHECK-OUT DATE</label>
                            <input type="text" id="check_out" name="check_out"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}" required>
                            @error('check_out')
                                <span class="khula text-danger" style="font-size: 0.65rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="overlap-warning" style="display:none;" class="mb-4 text-start">
                            <span class="khula" style="font-size:0.65rem; letter-spacing:0.1rem; color:#B08D57;">
                                SELECTED DATES OVERLAP AN EXISTING BOOKING. PLEASE CHOOSE DIFFERENT DATES.
                            </span>
                        </div>

                        <button type="submit" id="save-btn" class="btn btn-dayunan w-100 py-3 tenor-sans" style="letter-spacing: 0.2rem;">
                            Save Changes
                        </button>

                        <a href="{{ route('manage.index') }}" class="d-block mt-4 khula text-muted text-decoration-none" style="font-size: 0.65rem; letter-spacing: 0.15rem;">
                            CANCEL
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let blockedDates = [], checkInPicker, checkOutPicker;

    function styleCheckInDays() {
        setTimeout(function() {
            const el = document.getElementById('check_in');
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

    function styleCheckOutDays() {
        setTimeout(function() {
            const el = document.getElementById('check_out');
            if (!el || !el._flatpickr || !el._flatpickr.days) return;
            const fp = el._flatpickr;
            const today = new Date().toISOString().slice(0,10);
            const checkIn = checkInPicker && checkInPicker.selectedDates[0] ?
                checkInPicker.selectedDates[0].getFullYear() + '-' +
                String(checkInPicker.selectedDates[0].getMonth()+1).padStart(2,'0') + '-' +
                String(checkInPicker.selectedDates[0].getDate()).padStart(2,'0') : null;

            fp.days.querySelectorAll('.flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)').forEach(function(day) {
                const dateStr = day.dateObj ?
                    day.dateObj.getFullYear() + '-' +
                    String(day.dateObj.getMonth()+1).padStart(2,'0') + '-' +
                    String(day.dateObj.getDate()).padStart(2,'0') : null;
                if (!dateStr) return;
                blockedDates.forEach(function(range) {
                    if (dateStr >= range.from && dateStr <= range.to && dateStr >= today) {
                        const isValidCheckout = checkIn && dateStr === range.from;
                        if (!isValidCheckout) {
                            day.classList.add('disabled');
                            day.style.cssText = 'background:transparent !important; color:#B08D57 !important; border-radius:50% !important; border: 2px solid #B08D57 !important; opacity:1 !important; cursor:not-allowed !important;';
                            day.addEventListener('mouseover', function() {
                                this.style.cssText = 'background:transparent !important; color:#B08D57 !important; border-radius:50% !important; border: 2px solid #B08D57 !important; opacity:1 !important; cursor:not-allowed !important;';
                            });
                        }
                    }
                });
            });
        }, 100);
    }

    function checkOverlap(checkIn, checkOut) {
        return blockedDates.some(function(range) {
            return checkIn < range.to && checkOut > range.from;
        });
    }

    function getDateStr(date) {
        return date.getFullYear() + '-' +
            String(date.getMonth()+1).padStart(2,'0') + '-' +
            String(date.getDate()).padStart(2,'0');
    }

    fetch(`{{ route("api.blocked-dates") }}`)
        .then(r => r.json())
        .then(data => {
            blockedDates = data
                .filter(range => range.booking_id !== {{ $booking->id }})
                .map(range => ({ from: range.start_date, to: range.end_date }));

            checkInPicker = flatpickr("#check_in", {
                minDate: new Date().fp_incr(1),
                dateFormat: "Y-m-d",
                defaultDate: "{{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}",
                disable: blockedDates,
                onReady: styleCheckInDays,
                onMonthChange: styleCheckInDays,
                onChange: function(selectedDates) {
                    styleCheckInDays();
                    if (selectedDates[0]) {
                        const tomorrow = new Date(selectedDates[0]);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        checkOutPicker.set('minDate', tomorrow);
                        checkOutPicker.setDate('');
                        styleCheckOutDays();
                        document.getElementById('overlap-warning').style.display = 'none';
                    }
                    updateSaveBtn();
                }
            });

            checkOutPicker = flatpickr("#check_out", {
                dateFormat: "Y-m-d",
                defaultDate: "{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}",
                onReady: styleCheckOutDays,
                onMonthChange: styleCheckOutDays,
                onChange: function(selectedDates) {
                    styleCheckOutDays();
                    if (selectedDates[0] && checkInPicker.selectedDates[0]) {
                        const checkIn = getDateStr(checkInPicker.selectedDates[0]);
                        const checkOut = getDateStr(selectedDates[0]);
                        const warningEl = document.getElementById('overlap-warning');
                        if (checkOverlap(checkIn, checkOut)) {
                            warningEl.style.display = 'block';
                            checkOutPicker.setDate('');
                        } else {
                            warningEl.style.display = 'none';
                        }
                    }
                    updateSaveBtn();
                }
            });

            styleCheckInDays();
            styleCheckOutDays();
        });

    function updateSaveBtn() {
        const saveBtn = document.getElementById('save-btn');
        const checkInVal = document.getElementById('check_in').value;
        const checkOutVal = document.getElementById('check_out').value;
        const warning = document.getElementById('overlap-warning');
        if (checkInVal && checkOutVal && warning.style.display !== 'block') {
            saveBtn.disabled = false;
            saveBtn.style.opacity = '1';
        } else {
            saveBtn.disabled = true;
            saveBtn.style.opacity = '0.6';
        }
    }
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
    .flatpickr-day:not(.disabled):not(.prevMonthDay):not(.nextMonthDay):not(.flatpickr-disabled):hover {
        background: #3A5F41 !important;
        color: #fff !important;
        border-color: #3A5F41 !important;
        opacity: 0.8 !important;
    }
    #overlap-warning {
        border-left: 3px solid #B08D57;
        background: rgba(176, 141, 87, 0.08);
        padding: 10px 15px;
    }
</style>
@endsection