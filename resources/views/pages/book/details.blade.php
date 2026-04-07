@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <a href="{{ url('/book') }}" class="btn btn-outline-secondary btn-sm mb-3">
                    <i class="bi bi-arrow-left me-2"></i> Back to accommodations
                </a>
                <span class="khula d-block mb-3" style="color: var(--terracotta);">CONFIRM & BOOK</span>
                <h1 class="mb-3">Review {{ $package->title }}</h1>
                <p class="mx-auto text-muted" style="max-width: 600px; font-size: 1.1rem;">
                    Confirm your accommodation details and complete your booking.
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

            <form action="{{ route('book.store') }}" method="POST" id="booking-details-form">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                {{-- Package Details Card --}}
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

                {{-- Dates --}}
                <div class="dayunan-card mb-4">
                    <div class="dayunan-card-body">
                        <h3 class="mb-4">Select Dates</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="check_in" class="form-label">Check-in Date <small class="text-muted">(from 2PM)</small></label>
                                <input type="date" class="form-control" id="check_in" name="check_in" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out" class="form-label">Check-out Date <small class="text-muted">(by 12NN)</small></label>
                                <input type="date" class="form-control" id="check_out" name="check_out" required>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 small">
                            <i class="bi bi-check-circle me-2"></i> Past dates blocked • Approved bookings blocked • Daily rates.
                        </div>
                    </div>
                </div>

                {{-- Guest Info --}}
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
                    <button type="submit" class="btn btn-dayunan btn-lg px-5">
                        <i class="bi bi-check-circle me-2"></i> Confirm & Book Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Same JS as book.blade.php for dates/blocked --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
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
    
    fetch(`{{ route("api.blocked-dates") }}?package={{ $package->id }}`)
        .then(r => r.json())
        .then(data => {
            // Make blocked ranges unselectable via validation + visual
            const blockedRanges = data;
            
            const isOverlapping = (checkin, checkout) => {
                return blockedRanges.some(range => checkin < range.end_date && checkout > range.start_date);
            };
            
            const validateDates = () => {
                const checkin = checkInInput.value;
                const checkout = checkOutInput.value;
                if (checkin && checkout && isOverlapping(checkin, checkout)) {
                    checkInInput.style.backgroundColor = '#ffebee';
                    checkOutInput.style.backgroundColor = '#ffebee';
                    checkOutInput.setCustomValidity('Dates overlap approved booking for this package.');
                } else {
                    checkInInput.style.backgroundColor = '';
                    checkOutInput.style.backgroundColor = '';
                    checkOutInput.setCustomValidity('');
                }
            };
            
            checkInInput.addEventListener('change', validateDates);
            checkOutInput.addEventListener('change', validateDates);
            
            // Prevent form submit if invalid
            document.getElementById('booking-details-form').addEventListener('submit', function(e) {
                if (checkInInput.value && checkOutInput.value && isOverlapping(checkInInput.value, checkOutInput.value)) {
                    e.preventDefault();
                    alert('Please select available dates - overlaps with approved booking.');
                }
            });
        });
});
</script>

<style>
.object-fit-cover { object-fit: cover !important; }
@media (max-width: 768px) {
    .package-detail-image { height: 280px; }
}
</style>
@endsection
