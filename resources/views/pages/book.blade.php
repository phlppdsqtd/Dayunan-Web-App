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

                        <div class="row g-4 mt-3">
                            @foreach($packages as $package)
                                <div class="col-md-6">
                                    <div class="package-select-card {{ $selectedPackage && $selectedPackage->id == $package->id ? 'selected' : '' }}">
                                        <input type="radio" class="package-radio" name="package_id" id="package_{{ $package->id }}" value="{{ $package->id }}" {{ $selectedPackage && $selectedPackage->id == $package->id ? 'checked' : '' }} required style="display:none;">
                                        <label for="package_{{ $package->id }}" class="package-select-label w-100 h-100">
                                            <div class="package-image-wrap">
                                                @if($package->image)
                                                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" class="package-img">
                                                @else
                                                    <img src="{{ asset('images/home.jpg') }}" alt="{{ $package->title }}" class="package-img">
                                                @endif
                                            </div>
                                            <div class="p-3">
                                                <h6 class="mb-2">{{ $package->title }}</h6>
                                                @if($package->description)
                                                    <p class="text-muted small mb-2">{{ Str::limit($package->description, 80) }}</p>
                                                @endif
                                                @if($package->amenities)
                                                    <p class="text-muted xsmall mb-2"><strong>Amen:</strong> {{ Str::limit($package->amenities, 60) }}</p>
                                                @endif
                                                <div class="d-flex justify-content-between mt-2">
                                                    <span class="text-muted small">Max {{ $package->max_guests }} guests</span>
                                                    <strong class="text-terracotta">₱{{ number_format($package->price, 2) }}/day</strong>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <style>
.package-select-card {
    border: 2px solid transparent;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 240px;
    cursor: pointer;
}
.package-select-card:hover {
    border-color: var(--terracotta);
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(58,95,65,0.15);
}
.package-select-card.selected {
    border-color: var(--terracotta);
    box-shadow: 0 8px 32px rgba(58,95,65,0.2);
}
.package-image-wrap {
    height: 140px;
    overflow: hidden;
}
.package-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.package-select-label {
    display: flex !important;
    flex-direction: column;
    margin: 0;
    padding: 0;
}
.xsmall { font-size: 0.75rem; }
                        </style>
                    </div>
                </div>

                <div class="dayunan-card mb-4">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Select Dates</h3>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label">Check-in Date <small class="text-muted">(from 2PM)</small></label>
                                <input type="date" class="form-control" id="check_in" name="check_in" min="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label">Check-out Date <small class="text-muted">(by 12NN)</small></label>
                                <input type="date" class="form-control" id="check_out" name="check_out" required>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 small">
                            <i class="bi bi-check-circle me-2"></i> Past dates blocked • Approved bookings blocked • Daily rates apply (check-in after 2PM, checkout before 12NN).
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
    
    // Min check_out = check_in + 1 day
    checkInInput.addEventListener('change', function() {
        if (this.value) {
            const checkInDate = new Date(this.value);
            const minCheckOutDate = new Date(checkInDate);
            minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);
            checkOutInput.min = minCheckOutDate.toISOString().slice(0, 10);
            if (checkOutInput.value < checkOutInput.min) {
                checkOutInput.value = checkOutInput.min;
            }
        }
    });
    
    // Blocked dates validation (date-only)
    fetch('{{ route("api.blocked-dates") }}')
        .then(r => r.json())
        .then(data => {
            const isDateOverlapping = (start, end) => data.some(range => 
                start <= range.end_date && end >= range.start_date
            );
            
            const validate = () => {
                const start = checkInInput.value;
                const end = checkOutInput.value;
                if (start && end && isDateOverlapping(start, end)) {
                    checkOutInput.setCustomValidity('Dates overlap approved booking.');
                    checkInInput.setCustomValidity('Dates overlap approved booking.');
                } else {
                    checkInInput.setCustomValidity('');
                    checkOutInput.setCustomValidity('');
                }
            };
            
            checkInInput.addEventListener('change', validate);
            checkOutInput.addEventListener('change', validate);
        });
        
    // Package visual feedback
    document.querySelectorAll('.package-radio').forEach(r => {
        r.addEventListener('change', () => {
            document.querySelectorAll('.package-select-card').forEach(c => c.classList.remove('selected'));
            r.closest('.package-select-card').classList.add('selected');
        });
    });
});
</script>
@endsection