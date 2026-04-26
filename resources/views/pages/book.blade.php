@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
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
                                <div class="p-4 text-center d-flex flex-column h-100">
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
                                    
                                    <div class="mt-auto">
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
                                        
                                        <div class="text-start" style="padding-left: 0.25rem;">
                                            <small class="text-muted d-block">Max {{ $package->max_guests ?? 'N/A' }} guests</small>
                                            <strong class="h5 text-terracotta d-block mt-2">₱{{ number_format($package->price, 2) }}/day</strong>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.package-select-card {
    border: 2px solid transparent;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    min-height: 480px;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(58,95,65,0.08);
    background: white;
}

.package-select-card:hover {
    border-color: var(--terracotta);
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(58,95,65,0.15);
}

.package-image-wrap {
    height: 220px;
    overflow: hidden;
}

.package-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.package-select-card:hover .package-img {
    transform: scale(1.05);
}

.package-select-label {
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
    height: 100%;
    cursor: pointer;
}

@media (max-width: 768px) {
    .package-image-wrap {
        height: 180px;
    }
    
    .package-select-card {
        min-height: 420px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle package selection and redirect to details page
    document.querySelectorAll('.package-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const packageId = this.value;
            window.location.href = `/book/details/${packageId}`;
        });
    });
    
    // Make entire card clickable
    document.querySelectorAll('.package-select-card').forEach(card => {
        const radio = card.querySelector('.package-radio');
        card.addEventListener('click', function() {
            if (radio) {
                radio.checked = true;
                const event = new Event('change');
                radio.dispatchEvent(event);
            }
        });
    });
});
</script>
@endsection