@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <span class="khula d-block mb-3" style="color: var(--terracotta);">BOOK NOW</span>
                <h1 class="mb-3">Reserve Your Stay</h1>
                <p class="mx-auto text-muted" style="max-width: 600px; font-size: 1.1rem;">
                    Select your preferred accommodation and dates to secure your booking at Dayúnan.
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger shadow-sm border-0 mb-4">
                    {{ session('error') }}
                </div>
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

            <form action="{{ route('book.store') }}" method="POST" id="booking-form">
                @csrf

                <div class="dayunan-card mb-4">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Select Accommodation</h3>

                        <div class="row g-3">
                            @foreach($packages as $package)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="package_id" id="package_{{ $package->id }}" value="{{ $package->id }}" {{ $selectedPackage && $selectedPackage->id == $package->id ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="package_{{ $package->id }}">
                                            <strong>{{ $package->title }}</strong><br>
                                            <small class="text-muted">₱{{ number_format($package->price, 2) }} per day • Up to {{ $package->max_guests }} guests</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="dayunan-card mb-4">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Select Dates</h3>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label">Check-in Date & Time</label>
                                <input type="datetime-local" class="form-control" id="check_in" name="check_in" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label">Check-out Date & Time</label>
                                <input type="datetime-local" class="form-control" id="check_out" name="check_out" required>
                            </div>
                        </div>

                        <div id="calendar-container" class="mt-4">
                            <!-- Calendar will be rendered here -->
                        </div>
                    </div>
                </div>

                @if(!Auth::check())
                <div class="dayunan-card mb-4">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Guest Information</h3>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="guest_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guest_email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="guest_email" name="guest_email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guest_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="guest_phone" name="guest_phone">
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="text-center">
                    <button type="submit" class="btn btn-dayunan btn-lg">Submit Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const packageRadios = document.querySelectorAll('input[name="package_id"]');
    let selectedHours = 22; // default

    // Function to get hours from package title
    function getHoursFromTitle(title) {
        const match = title.match(/\((\d+) Hours\)/);
        return match ? parseInt(match[1]) : 22;
    }

    // Update selected hours when package changes
    packageRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (label) {
                selectedHours = getHoursFromTitle(label.textContent);
            }
        });
    });

    // Set check_out based on check_in + hours
    checkInInput.addEventListener('change', function() {
        if (this.value) {
            const checkInDate = new Date(this.value);
            checkInDate.setHours(checkInDate.getHours() + selectedHours);
            checkOutInput.value = checkInDate.toISOString().slice(0, 16); // Format for datetime-local
            checkOutInput.min = this.value; // Ensure check_out is after check_in
        } else {
            checkOutInput.value = '';
            checkOutInput.min = '';
        }
    });

    // Prevent check_out from being before check_in
    checkOutInput.addEventListener('change', function() {
        if (checkInInput.value && this.value <= checkInInput.value) {
            // Reset to check_in + hours
            const checkInDate = new Date(checkInInput.value);
            checkInDate.setHours(checkInDate.getHours() + selectedHours);
            this.value = checkInDate.toISOString().slice(0, 16);
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('');
        }
    });

    // Fetch blocked datetime ranges
    fetch('{{ route("api.blocked-dates") }}')
        .then(response => response.json())
        .then(blockedRanges => {
            // Validate against blocked datetime ranges
            function isTimeBlocked(checkInTime, checkOutTime) {
                return blockedRanges.some(range => {
                    const rangeStart = new Date(range.start);
                    const rangeEnd = new Date(range.end);
                    const userCheckIn = new Date(checkInTime);
                    const userCheckOut = new Date(checkOutTime);
                    
                    // Check if there's any overlap
                    return userCheckIn < rangeEnd && userCheckOut > rangeStart;
                });
            }

            checkInInput.addEventListener('change', function() {
                if (this.value && checkOutInput.value) {
                    if (isTimeBlocked(this.value, checkOutInput.value)) {
                        this.setCustomValidity('This time period overlaps with an existing booking.');
                    } else {
                        this.setCustomValidity('');
                    }
                }
            });

            checkOutInput.addEventListener('change', function() {
                if (checkInInput.value && this.value) {
                    if (isTimeBlocked(checkInInput.value, this.value)) {
                        this.setCustomValidity('This time period overlaps with an existing booking.');
                    } else {
                        this.setCustomValidity('');
                    }
                }
            });
        });
});
</script>
@endsection