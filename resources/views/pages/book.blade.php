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


            <div class="text-center">
               

                <div class="row g-4">
                    @foreach($packages as $package)
                        <div class="col-md-6 col-lg-4">
                            <div class="package-select-card">
                                <input type="radio" class="package-radio" name="package_id" id="package_{{ $package->id }}" value="{{ $package->id }}" style="display:none;">
                                <label for="package_{{ $package->id }}" class="package-select-label w-100 h-100">
                                    <div class="package-image-wrap">
                                        @if($package->image)
                                            <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" class="package-img">
                                        @else
                                            <img src="{{ asset('images/home.jpg') }}" alt="{{ $package->title }}" class="package-img">
                                        @endif
                                    </div>
                                    <div class="p-4 text-center">
                                        <h5 class="mb-3">{{ $package->title }}</h5>
                                        <div class="mb-3">
                                            @if($package->description)
                                                @php
                                                    $descLines = preg_split('/\\n+|\\.+\\s*\\n?|\\.\\s+(?=\\w{4,})/', trim($package->description), 4);
                                                    $descLines = array_filter($descLines, fn($line) => trim($line));
                                                    $descLines = array_slice($descLines, 0, 3);
@endphp
                                                <ul class="list-unstyled text-muted small mb-0 text-start" style="line-height: 1.3; padding-left: 0.25rem;">
                                                    @foreach($descLines as $line)
                                                        <li style="margin-bottom: 0.25rem;">{{ trim($line) }}</li>
                                                    @endforeach
                                                </ul>



                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end flex-column h-100">
                                            <div class="mb-auto">
@if($package->amenities)
                                                    @php
                                                        $amenityItems = array_map('trim', explode(',', $package->amenities));
                                                        $amenityItems = array_slice(array_filter($amenityItems), 0, 3);
                                                    @endphp
                                                    <ul class="list-unstyled text-muted small mb-2 text-start" style="line-height: 1.3; padding-left: 0.25rem;">
                                                        @foreach($amenityItems as $item)
                                                            <li style="margin-bottom: 0.125rem;">{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                <small class="text-muted">Max {{ $package->max_guests }} guests</small>
                                            </div>
                                            <div>
                                                <strong class="h5 text-terracotta d-block mb-2">₱{{ number_format($package->price, 2) }}/day</strong>
                                                <span class="btn btn-dayunan btn-sm">Select</span>
                                            </div>
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
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 440px;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(58,95,65,0.08);
}
.package-select-card:hover {
    border-color: var(--terracotta);
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(58,95,65,0.15);
}
.package-image-wrap {
    height: 200px;
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
    height: 100%;
}
.xsmall { font-size: 0.8rem; }
                </style>
            </div>

            <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.package-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const packageId = this.value;
            window.location.href = `/book/details/${packageId}`;
        });
    });
});
            </script>
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
                start < range.end_date && end > range.start_date
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