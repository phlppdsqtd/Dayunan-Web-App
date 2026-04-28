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
                    
                    <h1 class="tenor-sans text-jungle mb-3" style="font-size: 2.5rem; letter-spacing: 0.3rem;">Confirm & Book</h1>
                    <p class="mx-auto text-muted" style="max-width: 600px; font-size: 1.1rem;">
                        Verify your accommodation details and complete your booking.
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
                <input type="hidden" name="check_out" id="check_out_hidden" value="">

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
                                        <ul class="text-muted mb-0" style="padding-left: 1.2rem;">
                                            @php
                                                $amenitiesList = array_map('trim', explode(',', $package->amenities));
                                            @endphp
                                            @foreach($amenitiesList as $amenity)
                                                <li style="margin-bottom: 0.25rem;">{{ $amenity }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-start">
                                            <div class="text-muted small mb-1">Max Guests</div>
                                            <div class="h4 mb-0">{{ $package->max_guests ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-start">
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
                                <label class="form-label fw-semibold text-terracotta mb-2">
                                    Check-out Date
                                    <small class="text-muted">(by 12:00 Noon)</small>
                                    <span class="text-danger">*</span>
                                </label>
                                <div id="checkout-selection" style="display:none;">
                                    <div class="dropdown w-100" id="custom-dropdown-container">
                                        <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start form-control-lg" 
                                                type="button" 
                                                id="stayLengthDropdown" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false"
                                                style="background: white; border-color: var(--terracotta);">
                                            Select stay length...
                                        </button>
                                        <ul class="dropdown-menu w-100" id="stayLengthOptions" style="max-height: 300px; overflow-y: auto;">
                                            <li><a class="dropdown-item disabled" href="#">Select check-in first</a></li>
                                        </ul>
                                    </div>
                                    <div id="date-overlap-warning" style="display:none;" class="mt-3">
                                        <span class="khula text-terracotta" style="font-size:0.65rem; letter-spacing:0.1rem;">
                                            Selected stay overlaps an existing booking. Choose shorter stay.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 mb-2 small p-3" style="border-left: 3px solid #B08D57; background: rgba(176,141,87,0.08); color: #B08D57; font-family: 'Khula', sans-serif; letter-spacing: 0.05rem;">
                            Encircled dates are booked and cannot be selected as check-in. Stay max 7 days or until next booking.
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
                                <input type="text" class="form-control form-control-lg border-terracotta shadow-sm" 
                                       id="guest_name" name="guest_name" 
                                       placeholder="Enter full name (e.g., Maria Santos)"
                                       maxlength="50"
                                       required>
                                <small class="text-muted d-block mt-1">Letters, spaces, hyphens, and apostrophes only (2-50 characters)</small>
                            </div>
                            <div class="col-md-6">
                                <label for="guest_phone" class="form-label fw-semibold text-terracotta mb-2">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-lg border-terracotta shadow-sm" 
                                       id="guest_phone" name="guest_phone" 
                                       placeholder="09171234567 or 02-1234567"
                                       maxlength="13"
                                       required>
                                <small class="text-muted d-block mt-1">Philippine format: 09171234567, 639171234567, or 02-1234567</small>
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

    let checkInPicker, blockedDates = [];

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

    function checkOverlap(checkInStr, checkOutStr) {
        return blockedDates.some(function(range) {
            return checkInStr < range.to && checkOutStr > range.from;
        });
    }

    function generateCheckOutDropdown(checkInStr) {
        const selection = document.getElementById('checkout-selection');
        const dropdownButton = document.getElementById('stayLengthDropdown');
        const optionsContainer = document.getElementById('stayLengthOptions');
        
        if (!checkInStr) {
            selection.style.display = 'none';
            return;
        }

        // Clear and populate dropdown
        optionsContainer.innerHTML = '';

                let hasAnyOptions = false;
        let dayCounter = 1;

        // Check up to 7 days maximum
        for (let i = 1; i <= 7; i++) {
            // Add i days to check-in date (1 day = next day)
            const checkoutDate = new Date(new Date(checkInStr + 'T00:00:00').getTime() + i * 24*60*60*1000);
            const checkoutStr = checkoutDate.toISOString().slice(0,10);
            
            // Skip same-day checkout
            if (checkoutStr === checkInStr) {
                continue;
            }
            
            // Skip if checkout would overlap any existing booking
            if (checkOverlap(checkInStr, checkoutStr)) {
                continue;
            }
            
            hasAnyOptions = true;
            // Use dayCounter instead of i for the label
            const label = `${dayCounter} ${dayCounter === 1 ? 'day' : 'days'} (${checkoutStr})`;
            dayCounter++;
            
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.className = 'dropdown-item';
            a.href = '#';
            a.textContent = label;
            a.setAttribute('data-checkout-date', checkoutStr);
            a.setAttribute('data-days', dayCounter - 1);
            
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedDate = this.getAttribute('data-checkout-date');
                const selectedDays = this.getAttribute('data-days');
                
                document.getElementById('date-overlap-warning').style.display = 'none';
                document.getElementById('check_out_hidden').value = selectedDate;
                dropdownButton.innerHTML = `${selectedDays} days (${selectedDate}) <span class="float-end">↗</span>`;
                
                optionsContainer.querySelectorAll('.dropdown-item').forEach(item => {
                    item.classList.remove('active');
                });
                a.classList.add('active');
                
                validateForm();
            });
            
            li.appendChild(a);
            optionsContainer.appendChild(li);
        }

        if (!hasAnyOptions) {
            optionsContainer.innerHTML = '<li><a class="dropdown-item disabled" href="#">No available dates</a></li>';
            dropdownButton.innerHTML = 'No available dates <span class="float-end">↗</span>';
        }

        selection.style.display = 'block';
        validateForm();
    }

    fetch(`{{ route("api.blocked-dates", $package->id) }}`)
        .then(r => r.json())
        .then(data => {
            blockedDates = data.map(range => ({
                from: range.start_date,
                to: range.end_date
            }));

            const disableRanges = blockedDates.map(range => ({
                from: new Date(range.from + 'T00:00:00'),
                to: new Date(range.to + 'T00:00:00')
            }));

            checkInPicker = flatpickr("#check_in", {
                minDate: new Date().fp_incr(1),
                dateFormat: "Y-m-d",
                disable: disableRanges,
                onReady: styleCheckInDays,
                onMonthChange: styleCheckInDays,
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        const checkInStr = selectedDates[0].getFullYear() + '-' +
                            String(selectedDates[0].getMonth()+1).padStart(2,'0') + '-' +
                            String(selectedDates[0].getDate()).padStart(2,'0');

                        generateCheckOutDropdown(checkInStr);
                        document.getElementById('date-overlap-warning').style.display = 'none';
                        styleCheckInDays();
                        validateForm();
                    } else {
                        document.getElementById('checkout-selection').style.display = 'none';
                        validateForm();
                    }
                }
            });

            styleCheckInDays();
        })
        .catch(err => {
            console.error('Failed to load blocked dates:', err);
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger mt-3';
            alertDiv.textContent = 'Unable to load availability. Please refresh the page or try again later.';
            document.querySelector('.dayunan-card.mb-4 .dayunan-card-body').prepend(alertDiv);
        });

    const form = document.getElementById('booking-details-form');
    const guestName = document.getElementById('guest_name');
    const guestEmail = document.getElementById('guest_email');
    const guestConfirmEmail = document.getElementById('guest_confirm_email');
    const guestPhone = document.getElementById('guest_phone');

    // Additional validation for name and phone
    if (guestName) {
        guestName.addEventListener('input', function() {
            // Remove any numbers or special characters (allow letters, spaces, hyphens, apostrophes, and ñ)
            this.value = this.value.replace(/[^A-Za-z\u00f1\u00d1\s\-']/g, '');
            
            // Capitalize first letter of each word
            this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
            
            // Check for at least two words
            const words = this.value.trim().split(/\s+/);
            if (words.length < 2 && this.value.length > 0) {
                this.setCustomValidity('Please enter both first and last name');
            } else if (this.value.length < 2 && this.value.length > 0) {
                this.setCustomValidity('Name must be at least 2 characters');
            } else if (this.value.length > 50) {
                this.setCustomValidity('Name cannot exceed 50 characters');
            } else {
                this.setCustomValidity('');
            }
            
            validateForm();
        });
    }

    if (guestPhone) {
        guestPhone.addEventListener('input', function() {
            // Remove all non-numeric characters except hyphen
            let cleaned = this.value.replace(/[^0-9-]/g, '');
            
            // Auto-format for landline (add hyphen after area code)
            if (cleaned.length === 2 && !cleaned.includes('-')) {
                // Don't add hyphen yet, wait for more digits
                this.value = cleaned;
            } else if (cleaned.length > 2 && cleaned.length <= 7 && !cleaned.includes('-') && !cleaned.startsWith('09') && !cleaned.startsWith('63')) {
                // Auto-add hyphen for landline (e.g., 021234567 -> 02-1234567)
                if (cleaned.length >= 2) {
                    this.value = cleaned.slice(0, 2) + '-' + cleaned.slice(2);
                } else {
                    this.value = cleaned;
                }
            } else if (cleaned.length > 7 && cleaned.length <= 10 && !cleaned.includes('-') && !cleaned.startsWith('09') && !cleaned.startsWith('63')) {
                // Auto-add hyphen for 3-digit area code (e.g., 0321234567 -> 032-1234567)
                if (cleaned.length >= 3) {
                    this.value = cleaned.slice(0, 3) + '-' + cleaned.slice(3);
                } else {
                    this.value = cleaned;
                }
            } else {
                this.value = cleaned;
            }
            
            // Validate Philippine number pattern
            // Patterns: 09171234567, 639171234567, 02-1234567, 032-1234567
            const phonePattern = /^(09[0-9]{9}|639[0-9]{9}|[0-9]{2,3}-[0-9]{6,7}|[0-9]{10,13})$/;
            
            if (this.value.length > 0 && !phonePattern.test(this.value)) {
                this.setCustomValidity('Enter a valid Philippine number (e.g., 09171234567, 639171234567, or 02-1234567)');
            } else if (this.value.length < 10 && this.value.length > 0) {
                this.setCustomValidity('Phone number must be at least 10 digits');
            } else if (this.value.length > 13) {
                this.setCustomValidity('Phone number cannot exceed 13 digits');
            } else {
                this.setCustomValidity('');
            }
            
            validateForm();
        });
    }

    function validateForm() {
        let isValid = true;
        
        [guestName, guestEmail, guestConfirmEmail, guestPhone].forEach(field => {
            if (field) field.classList.remove('is-invalid');
        });

        const checkInVal = document.getElementById('check_in').value;
        const checkOutVal = document.getElementById('check_out_hidden').value;
        const warningEl = document.getElementById('date-overlap-warning');
        const hasWarning = warningEl.style.display === 'block';
        
        if (!checkInVal || !checkOutVal) isValid = false;
        if (hasWarning) isValid = false;
        if (checkInVal && checkOutVal && checkOverlap(checkInVal, checkOutVal)) {
            warningEl.style.display = 'block';
            isValid = false;
        } else {
            warningEl.style.display = 'none';
        }
        
        if (guestName && !guestName.value.trim()) { 
            guestName.classList.add('is-invalid'); 
            isValid = false; 
        } else if (guestName && guestName.value.trim().split(/\s+/).length < 2 && guestName.value.trim().length > 0) {
            guestName.classList.add('is-invalid');
            isValid = false;
        }
        
        if (guestEmail) {
            if (!guestEmail.value.trim()) { 
                guestEmail.classList.add('is-invalid'); 
                isValid = false; 
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(guestEmail.value)) { 
                guestEmail.classList.add('is-invalid'); 
                isValid = false; 
            }
        }
        
        if (guestConfirmEmail) {
            if (!guestConfirmEmail.value.trim()) { 
                guestConfirmEmail.classList.add('is-invalid'); 
                isValid = false; 
            } else if (guestEmail && guestEmail.value !== guestConfirmEmail.value) {
                guestEmail.classList.add('is-invalid');
                guestConfirmEmail.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        if (guestPhone && !guestPhone.value.trim()) { 
            guestPhone.classList.add('is-invalid'); 
            isValid = false; 
        } else if (guestPhone && guestPhone.value.length > 0 && guestPhone.value.length < 10) {
            guestPhone.classList.add('is-invalid');
            isValid = false;
        } else if (guestPhone && guestPhone.value.length > 13) {
            guestPhone.classList.add('is-invalid');
            isValid = false;
        }
        
        const submitBtn = document.getElementById('submit-booking');
        if (submitBtn) {
            submitBtn.disabled = !isValid;
            if (isValid) {
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Confirm & Book Now';
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
        if (!validateForm()) {
            e.preventDefault();
        }
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

.dropdown-menu {
    font-family: inherit !important;
    border-color: var(--terracotta);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.dropdown-item {
    font-family: inherit !important;
    font-size: 1rem;
    padding: 10px 20px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #3A5F41;
    color: white;
}

.dropdown-item.active {
    background-color: #3A5F41;
    color: white;
}

.dropdown-item.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

#stayLengthDropdown {
    text-align: left;
    font-family: inherit;
    font-size: 1rem;
    background: white;
    border-width: 2px;
}

#stayLengthDropdown::after {
    float: right;
    margin-top: 8px;
}

@media (max-width: 768px) {
    .package-detail-image { height: 280px; }
    .form-control-lg, #stayLengthDropdown { font-size: 1rem !important; }
}
</style>
@endsection