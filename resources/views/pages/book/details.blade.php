@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-5">
                <a href="{{ url('/book') }}" class="btn btn-outline-secondary btn-sm mb-4 d-inline-flex align-items-center">
                    <i class="bi bi-arrow-left me-2"></i> Back to accommodations
                </a>
                <div class="text-center">
                    <span class="khula d-block mb-3" style="color: var(--terracotta);">CONFIRM & BOOK</span>
                    <h1 class="tenor-sans text-jungle mb-3" style="font-size: 2.5rem; letter-spacing: 0.3rem;">Confirm & Book</h1>
                    <p class="mx-auto text-muted" style="max-width: 600px; font-size: 1.1rem;">
                        Confirm your accommodation details and complete your booking.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger shadow-sm border-0 mb-4">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger shadow-sm border-0 mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('book.store') }}" method="POST" id="booking-details-form">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                <div class="dayunan-card mb-5">
                    <div class="row g-0 h-100">
                        <div class="col-md-5">
                            <div class="package-detail-image" style="height: 400px; background: linear-gradient(135deg, #f8f5f0 0%, #f2eee8 100%);">
                                @if($package->image)
                                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <img src="{{ asset('images/home.jpg') }}" alt="{{ $package->title }}" class="w-100 h-100 object-fit-cover">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="dayunan-card-body p-5">
                                <h2 class="mb-4">{{ $package->title }}</h2>
                                @if($package->description)
                                    <div class="mb-4">
                                        <h6 class="text-terracotta mb-3">Description</h6>
                                        <p class="lead text-muted mb-0">{!! nl2br(e($package->description)) !!}</p>
                                    </div>
                                @endif
                                @if($package->amenities)
                                    <div class="mb-4">
                                        <h6 class="text-terracotta mb-3">Amenities</h6>
                                        <p class="text-muted mb-0">{{ $package->amenities }}</p>
                                    </div>
                                @endif
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end border-light">
                                            <div class="text-muted small mb-1">Max Guests</div>
                                            <div class="h4 mb-0">{{ $package->max_guests ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <div class="text-muted small mb-1">Price</div>
                                            <div class="h3 text-terracotta mb-0">₱{{ number_format($package->price, 2) }} <small class="text-muted">/day</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dayunan-card mb-4">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Select Dates</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-terracotta mb-2">Check-in Date <small class="text-muted">(from 2PM)</small> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg border-terracotta shadow-sm flatpickr-input" id="check_in" name="check_in" placeholder="Select check-in" readonly required style="background: white;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-terracotta mb-2">Check-out Date <small class="text-muted">(by 12NN)</small> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg border-terracotta shadow-sm flatpickr-input" id="check_out" name="check_out" placeholder="Select check-out" readonly required>
                                <div id="date-overlap-warning" style="display:none;" class="mt-2">
                                    <span class="khula text-terracotta" style="font-size:0.65rem; letter-spacing:0.1rem;">
                                        SELECTED DATES OVERLAP AN EXISTING BOOKING. PLEASE CHOOSE DIFFERENT DATES.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 mb-5 small">
                            <i class="bi bi-check-circle me-2"></i> Past dates blocked • Approved bookings blocked • Daily rates.
                        </div>
                    </div>
                </div>

                @if(!Auth::check())
                <div class="dayunan-card mb-5">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Guest Information</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="guest_name" class="form-label fw-semibold text-terracotta mb-2">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg border-terracotta shadow-sm" id="guest_name" name="guest_name" placeholder="Enter full name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guest_phone" class="form-label fw-semibold text-terracotta mb-2">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-lg border-terracotta shadow-sm" id="guest_phone" name="guest_phone" placeholder="+63 123 465 789" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guest_email" class="form-label fw-semibold text-terracotta mb-2">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg border-terracotta shadow-sm" id="guest_email" name="guest_email" placeholder="your@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guest_confirm_email" class="form-label fw-semibold text-terracotta mb-2">Confirm Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-lg border-terracotta shadow-sm" id="guest_confirm_email" name="guest_confirm_email" placeholder="Retype your email" required>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="text-center mt-5 pt-5">
                    <button type="submit" id="submit-booking" class="btn btn-dayunan px-5 py-3" style="font-size: 0.8rem; box-shadow: 0 8px 25px rgba(58,95,65,0.2);">
                        <i class="bi bi-check-circle me-2"></i> Complete all fields first
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let checkInPicker, checkOutPicker, blockedDates = [];

    function styleDisabledDays() {
        setTimeout(function() {
            ['check_in', 'check_out'].forEach(function(id) {
                const el = document.getElementById(id);
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
            });
        }, 100);
    }

    function checkOverlap(checkIn, checkOut) {
        return blockedDates.some(function(range) {
            return checkIn < range.to && checkOut > range.from;
        });
    }

    fetch(`{{ route("api.blocked-dates") }}`)
        .then(r => r.json())
        .then(data => {
            blockedDates = data.map(range => ({
                from: range.start_date,
                to: range.end_date
            }));

            checkInPicker = flatpickr("#check_in", {
                minDate: new Date().fp_incr(1),
                dateFormat: "Y-m-d",
                disable: blockedDates,
                onReady: styleDisabledDays,
                onMonthChange: styleDisabledDays,
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        const tomorrow = new Date(selectedDates[0]);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        checkOutPicker.set('minDate', tomorrow);
                        checkOutPicker.setDate('');
                        document.getElementById('date-overlap-warning').style.display = 'none';
                        styleDisabledDays();
                        validateForm();
                    }
                }
            });

            checkOutPicker = flatpickr("#check_out", {
                dateFormat: "Y-m-d",
                minDate: new Date().fp_incr(2),
                disable: blockedDates,
                clickOpens: false,
                onReady: styleDisabledDays,
                onMonthChange: styleDisabledDays,
                onChange: function(selectedDates) {
                    if (selectedDates[0] && checkInPicker.selectedDates[0]) {
                        const checkIn = checkInPicker.selectedDates[0].getFullYear() + '-' +
                            String(checkInPicker.selectedDates[0].getMonth()+1).padStart(2,'0') + '-' +
                            String(checkInPicker.selectedDates[0].getDate()).padStart(2,'0');
                        const checkOut = selectedDates[0].getFullYear() + '-' +
                            String(selectedDates[0].getMonth()+1).padStart(2,'0') + '-' +
                            String(selectedDates[0].getDate()).padStart(2,'0');

                        const warningEl = document.getElementById('date-overlap-warning');
                        if (checkOverlap(checkIn, checkOut)) {
                            warningEl.style.display = 'block';
                            checkOutPicker.setDate('');
                        } else {
                            warningEl.style.display = 'none';
                        }
                    }
                    styleDisabledDays();
                    validateForm();
                }
            });

            document.getElementById('check_out').addEventListener('click', function() {
                if (!checkInPicker.selectedDates[0]) {
                    alert('Please select check-in date first');
                    return;
                }
                checkOutPicker.open();
            });

            styleDisabledDays();
        });

    const form = document.getElementById('booking-details-form');
    const guestName = document.getElementById('guest_name');
    const guestEmail = document.getElementById('guest_email');
    const guestConfirmEmail = document.getElementById('guest_confirm_email');
    const guestPhone = document.getElementById('guest_phone');

    function validateForm() {
        let isValid = true;
        [guestName, guestEmail, guestConfirmEmail, guestPhone].forEach(field => {
            if (field) field.classList.remove('is-invalid');
        });
        const checkInVal = document.getElementById('check_in').value;
        const checkOutVal = document.getElementById('check_out').value;
        if (!checkInVal || !checkOutVal) isValid = false;
        if (document.getElementById('date-overlap-warning').style.display === 'block') isValid = false;
        if (guestName && !guestName.value.trim()) { guestName.classList.add('is-invalid'); isValid = false; }
        if (guestEmail) {
            if (!guestEmail.value.trim()) { guestEmail.classList.add('is-invalid'); isValid = false; }
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(guestEmail.value)) { guestEmail.classList.add('is-invalid'); isValid = false; }
        }
        if (guestConfirmEmail) {
            if (!guestConfirmEmail.value.trim()) { guestConfirmEmail.classList.add('is-invalid'); isValid = false; }
            else if (guestEmail && guestEmail.value !== guestConfirmEmail.value) {
                guestEmail.classList.add('is-invalid');
                guestConfirmEmail.classList.add('is-invalid');
                isValid = false;
            }
        }
        if (guestPhone && !guestPhone.value.trim()) { guestPhone.classList.add('is-invalid'); isValid = false; }
        const submitBtn = document.getElementById('submit-booking');
        if (submitBtn) {
            submitBtn.disabled = !isValid;
            if (isValid) {
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Confirm &amp; Book Now';
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2" style="opacity:0.5;"></i> Complete all fields first';
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }
        }
        return isValid;
    }

    [guestName, guestEmail, guestConfirmEmail, guestPhone].forEach(field => {
        if (field) {
            field.addEventListener('input', validateForm);
            field.addEventListener('change', validateForm);
        }
    });

    form.addEventListener('submit', function(e) {
        if (!validateForm()) e.preventDefault();
    });

    validateForm();
});
</script>

<style>
.object-fit-cover { object-fit: cover !important; }
.btn-dayunan:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(58,95,65,0.3) !important; }
.border-terracotta { border-color: var(--terracotta) !important; border-width: 2px !important; }
.border-terracotta:focus { border-color: #d97706 !important; box-shadow: 0 0 0 0.25rem rgba(217, 119, 6, 0.25) !important; }
.flatpickr-day:not(.disabled):not(.prevMonthDay):not(.nextMonthDay):not(.flatpickr-disabled):hover {
    background: #3A5F41 !important;
    color: #fff !important;
    border-color: #3A5F41 !important;
    opacity: 0.8 !important;
}
@media (max-width: 768px) {
    .package-detail-image { height: 280px; }
    .form-control-lg { font-size: 1rem !important; }
}
</style>
@endsection