@extends('layouts.app')

@section('content')
<div class="manage-search-wrapper d-flex align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="search-card p-5 shadow-sm">
                    <span class="khula text-terracotta d-block mb-3" style="letter-spacing: 0.4rem; font-size: 0.7rem;">ADMIN · EDIT BOOKING</span>
                    <h2 class="tenor-sans mb-2 text-jungle">Edit Booking</h2>
                    <p class="cormorant text-muted fst-italic mb-5" style="font-size: 1rem;">
                        REF #{{ $booking->id }} &middot; {{ $booking->package->title ?? 'Package' }}
                    </p>

                    <form action="{{ route('manage.admin.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                            <input type="text" id="admin_check_out" name="check_out"
                                   class="form-control aesthetic-input py-3"
                                   value="{{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}" required>
                            @error('check_out')
                                <span class="khula text-danger" style="font-size: 0.65rem;">{{ $message }}</span>
                            @enderror
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

                        <button type="submit" class="btn btn-dayunan w-100 py-3 tenor-sans" style="letter-spacing: 0.2rem;">
                            Save Changes
                        </button>

                        <a href="{{ route('manage.index') }}" class="d-block mt-4 khula text-muted text-decoration-none text-center" style="font-size: 0.65rem; letter-spacing: 0.15rem;">
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

    function styleDisabledDays(fp) {
        setTimeout(function() {
            if (!fp || !fp.days) return;
            const today = new Date().toISOString().slice(0,10);
            fp.days.querySelectorAll('.flatpickr-day:not(.prevMonthDay):not(.nextMonthDay)').forEach(function(day) {
                const dateStr = day.dateObj ?
                    day.dateObj.getFullYear() + '-' +
                    String(day.dateObj.getMonth()+1).padStart(2,'0') + '-' +
                    String(day.dateObj.getDate()).padStart(2,'0') : null;
                if (!dateStr) return;
                blockedDates.forEach(function(range) {
                    if (dateStr >= range.from && dateStr <= range.to && dateStr >= today) {
                        day.style.cssText = 'background:transparent !important; color:#B08D57 !important; border-radius:50% !important; border: 2px solid #B08D57 !important; opacity:1 !important; cursor:pointer !important;';
                        day.addEventListener('mouseover', function() {
                            this.style.cssText = 'background:#3A5F41 !important; color:#fff !important; border-radius:50% !important; border: 2px solid #3A5F41 !important; opacity:0.8 !important; cursor:pointer !important;';
                        });
                        day.addEventListener('mouseout', function() {
                            this.style.cssText = 'background:transparent !important; color:#B08D57 !important; border-radius:50% !important; border: 2px solid #B08D57 !important; opacity:1 !important; cursor:pointer !important;';
                        });
                    }
                });
            });
            // Re-apply selected highlight
            fp.days.querySelectorAll('.flatpickr-day.selected').forEach(function(day) {
                day.style.cssText = 'background:#3A5F41 !important; color:#fff !important; border-radius:50% !important; border: 2px solid #3A5F41 !important; opacity:1 !important; cursor:pointer !important;';
            });
        }, 100);
    }

    fetch(`{{ route("api.blocked-dates") }}`)
        .then(r => r.json())
        .then(data => {
            blockedDates = data
                .filter(range => range.booking_id !== {{ $booking->id }})
                .map(range => ({ from: range.start_date, to: range.end_date }));

            checkInPicker = flatpickr("#admin_check_in", {
                dateFormat: "Y-m-d",
                onReady: function() { styleDisabledDays(this); },
                onMonthChange: function() { styleDisabledDays(this); },
                onChange: function(selectedDates, dateStr, instance) {
                    styleDisabledDays(instance);
                    if (selectedDates[0]) {
                        const tomorrow = new Date(selectedDates[0]);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        checkOutPicker.set('minDate', tomorrow);
                        styleDisabledDays(checkOutPicker);
                    }
                }
            });

            checkOutPicker = flatpickr("#admin_check_out", {
                dateFormat: "Y-m-d",
                onReady: function() { styleDisabledDays(this); },
                onMonthChange: function() { styleDisabledDays(this); },
                onChange: function(selectedDates, dateStr, instance) {
                    styleDisabledDays(instance);
                }
            });
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
    .flatpickr-day:not(.prevMonthDay):not(.nextMonthDay):not(.flatpickr-disabled):hover {
        background: #3A5F41 !important;
        color: #fff !important;
        border-color: #3A5F41 !important;
        opacity: 0.8 !important;
    }
</style>
@endsection