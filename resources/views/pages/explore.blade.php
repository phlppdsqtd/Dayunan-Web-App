@extends('layouts.app')

@section('content')
<section class="explore-hero py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="khula d-block mb-3" style="color: var(--terracotta);">OUR SPACES</span>
            <h1 class="mb-3">Explore Dayúnan</h1>
            <p class="mx-auto text-muted" style="max-width: 680px; font-size: 1.15rem;">
                Find a space to rest, gather, and enjoy slow moments in the city.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="admin-panel mb-5">
                <h3 class="mb-4">Add Accommodation</h3>

                <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Max Guests</label>
                            <input type="number" name="max_guests" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Amenities</label>
                            <textarea name="amenities" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="new_is_active" checked>
                                <label class="form-check-label" for="new_is_active">
                                    Visible on Explore page
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-dayunan">Add Accommodation</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <div class="gallery-section mb-5">
            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="admin-panel mb-4">
                    <h3 class="mb-3">Add Gallery</h3>
                    <form action="{{ route('galleries.store') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="name" class="form-control" placeholder="New Gallery (e.g. Standard Room)" required>
                        <button class="btn btn-dayunan">Add</button>
                    </form>
                </div>
            @endif

            @forelse($galleries as $gallery)
                @php
                    $images = $gallery->images;
                    $firstImage = $images->first();
                @endphp

                <div class="gallery-row-card mb-4">
                    <div class="row g-0 align-items-stretch">
                        <div class="col-lg-4">
                            <div class="gallery-info-panel">
                                <span class="khula d-block mb-2" style="color: var(--terracotta);">DAYUNAN</span>
                                <h3 class="mb-3">{{ $gallery->name }}</h3>
                                @if(Auth::check() && Auth::user()->role === 'admin')
                                    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" class="mb-3">
                                        @csrf
                                        @method('PUT')

                                        <input type="text" name="name" class="form-control mb-2" value="{{ $gallery->name }}">

                                        <textarea name="description" class="form-control mb-2" rows="2" placeholder="Gallery description...">{{ $gallery->description }}</textarea>

                                        <button class="btn btn-sm btn-dark w-100">Save Text</button>
                                    </form>
                                @else
                                    <p class="text-muted mb-3">
                                        {{ $gallery->description ?? 'A closer look at the space and its details.' }}
                                    </p>
                                @endif

                                @if(Auth::check() && Auth::user()->role === 'admin')
                                    <form action="{{ route('galleries.addImage', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                                        @csrf
                                        <label class="form-label small">Add Photo</label>
                                        <input type="file" name="image" class="form-control mb-2" required>
                                        <button class="btn btn-sm btn-dark w-100">Upload Photo</button>
                                    </form>

                                    @if($images->count())
                                        <div class="gallery-image-list mb-3">
                                            @foreach($images as $img)
                                                <div class="gallery-image-item">
                                                    <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $gallery->name }}">

                                                    <form action="{{ route('galleries.deleteImage', $img->id) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">Remove Photo</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Delete this entire gallery?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger w-100">Delete Gallery</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="gallery-viewer-panel">
                                @if($images->count() > 0)
                                    <button type="button" class="gallery-arrow gallery-arrow-left" onclick="moveGallery({{ $gallery->id }}, -1)">
                                        &#10094;
                                    </button>

                                    <div class="gallery-frame">
                                        <div class="gallery-track" id="gallery-track-{{ $gallery->id }}">
                                            @foreach($images as $img)
                                                <div class="gallery-slide">
                                                    <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $gallery->name }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button type="button" class="gallery-arrow gallery-arrow-right" onclick="moveGallery({{ $gallery->id }}, 1)">
                                        &#10095;
                                    </button>
                                @else
                                    <div class="gallery-empty-state">
                                        <img src="{{ asset('images/home.jpg') }}" alt="{{ $gallery->name }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <h3 class="mb-3">No galleries available yet</h3>
                    <p class="text-muted mb-0">Please check back soon.</p>
                </div>
            @endforelse
        </div>

        <div class="row g-4">
            @forelse ($packages as $package)
                <div class="col-md-6 col-lg-4">
                    <div class="dayunan-card h-100 d-flex flex-column">
                        <div class="dayunan-card-image-wrap">
                            @if ($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" class="dayunan-card-image">
                            @else
                                <img src="{{ asset('images/home.jpg') }}" alt="{{ $package->title }}" class="dayunan-card-image">
                            @endif
                        </div>

                        <div class="dayunan-card-body d-flex flex-column flex-grow-1">
                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <span class="khula mb-2 d-block" style="color: var(--terracotta);">ACCOMMODATION</span>

                                    <div class="mb-2">
                                        <label class="form-label small">Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ $package->title }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label small">Description</label>
                                        <textarea name="description" rows="3" class="form-control" required>{{ $package->description }}</textarea>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label small">Amenities</label>
                                        <textarea name="amenities" rows="2" class="form-control">{{ $package->amenities }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <label class="form-label small">Guests</label>
                                            <input type="number" name="max_guests" class="form-control" value="{{ $package->max_guests }}">
                                        </div>

                                        <div class="col-6 mb-2">
                                            <label class="form-label small">Price</label>
                                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $package->price }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label small">Change Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active_{{ $package->id }}" {{ $package->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="is_active_{{ $package->id }}">
                                            Visible on Explore page
                                        </label>
                                    </div>

                                    <div class="d-flex gap-2 mt-auto">
                                        <button type="submit" class="btn btn-dayunan btn-sm">Save</button>
                                </form>

                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Delete this accommodation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                                    </div>
                            @else
                                <span class="khula mb-2" style="color: var(--terracotta);">ACCOMMODATION</span>

                                <h3 class="mb-3" style="font-size: 1.4rem; letter-spacing: 0.12rem;">
                                    {{ $package->title }}
                                </h3>

                                <p class="text-muted mb-3" style="font-size: 1.05rem; line-height: 1.7;">
                                    {{ $package->description }}
                                </p>

                                @if($package->amenities)
                                    <p class="mb-3" style="font-size: 1rem;">
                                        <strong>Amenities:</strong> {{ $package->amenities }}
                                    </p>
                                @endif

                                <div class="mt-auto pt-3 border-top" style="border-color: #e6ddd2 !important;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span><strong>Guests:</strong> {{ $package->max_guests ?? 'N/A' }}</span>
                                        <span><strong>₱{{ number_format($package->price, 2) }}</strong></span>
                                    </div>

                                    <a href="{{ url('/book') }}" class="btn btn-dayunan w-100">Book Now</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <h3 class="mb-3">No spaces available yet</h3>
                        <p class="text-muted mb-0">Please check back soon.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .explore-hero {
        background: linear-gradient(to bottom, #F5F1EC 0%, #f8f5f0 100%);
    }

    .admin-panel {
        background: #ffffff;
        border: 1px solid #e7ddd1;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(58, 95, 65, 0.06);
    }

    .gallery-row-card {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .gallery-info-panel {
        height: 100%;
        padding: 2rem;
        background: transparent;
        border: none;
    }

    .gallery-meta {
        color: #7a746c;
        font-size: 0.95rem;
    }

    .gallery-viewer-panel {
        position: relative;
        height: 100%;
        min-height: 320px;
        background: #f2eee8;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 4rem;
    }

    .gallery-frame {
        width: 100%;
        overflow: hidden;
        border: none;
        background: transparent;
    }

    .gallery-track {
        display: flex;
        transition: transform 0.45s ease;
        width: 100%;
    }

    .gallery-slide {
        min-width: 100%;
        width: 100%;
        height: 320px;
        flex-shrink: 0;
    }

    .gallery-slide img,
    .gallery-empty-state img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-empty-state {
        width: 100%;
        height: 320px;
        border: 1px solid #e7ddd1;
        overflow: hidden;
        background: #fff;
    }

    .gallery-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);

        width: 42px;
        height: 42px;

        background: transparent;
        border: none;
        box-shadow: none;

        color: #3A5F41;
        font-size: 1.6rem;

        display: flex;
        align-items: center;
        justify-content: center;

        cursor: pointer;
        z-index: 2;

        transition: opacity 0.2s ease;
    }

    .gallery-arrow:hover {
        opacity: 0.6;
    }

    .gallery-arrow-left {
        left: 1rem;
    }

    .gallery-arrow-right {
        right: 1rem;
    }

    .gallery-image-list {
        display: grid;
        gap: 0.75rem;
    }

    .gallery-image-item {
        border: none;
        padding: 0.75rem;
        background: transparent;
    }

    .gallery-image-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        display: block;
        margin-bottom: 0.5rem;
    }

    .dayunan-card {
        background: #ffffff;
        border: 1px solid #e7ddd1;
        overflow: hidden;
        height: 100%;
        transition: all 0.35s ease;
        box-shadow: 0 8px 24px rgba(58, 95, 65, 0.06);
    }

    .dayunan-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 35px rgba(58, 95, 65, 0.12);
    }

    .dayunan-card-image-wrap {
        height: 280px;
        overflow: hidden;
    }

    .dayunan-card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .dayunan-card:hover .dayunan-card-image {
        transform: scale(1.05);
    }

    .dayunan-card-body {
        padding: 1.7rem;
        background: #fff;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    @media (max-width: 991.98px) {
        .gallery-info-panel {
            border-right: none;
            border-bottom: 1px solid #e7ddd1;
        }

        .gallery-viewer-panel {
            min-height: 260px;
            padding: 1rem 3.5rem;
        }

        .gallery-slide,
        .gallery-empty-state {
            height: 260px;
        }
    }

    @media (max-width: 575.98px) {
        .gallery-viewer-panel {
            padding: 1rem 3rem;
        }

        .gallery-arrow {
            width: 36px;
            height: 36px;
            font-size: 1.1rem;
        }

        .gallery-slide,
        .gallery-empty-state {
            height: 220px;
        }
    }
</style>

<script>
    const galleryIndexes = {};

    function moveGallery(galleryId, direction) {
        const track = document.getElementById(`gallery-track-${galleryId}`);
        if (!track) return;

        const slides = track.querySelectorAll('.gallery-slide');
        const totalSlides = slides.length;
        if (totalSlides === 0) return;

        if (!(galleryId in galleryIndexes)) {
            galleryIndexes[galleryId] = 0;
        }

        galleryIndexes[galleryId] += direction;

        if (galleryIndexes[galleryId] < 0) {
            galleryIndexes[galleryId] = totalSlides - 1;
        }

        if (galleryIndexes[galleryId] >= totalSlides) {
            galleryIndexes[galleryId] = 0;
        }

        track.style.transform = `translateX(-${galleryIndexes[galleryId] * 100}%)`;
    }
</script>
@endsection