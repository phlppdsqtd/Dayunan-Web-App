@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 850px;">
    <div class="mb-4">
        <span class="khula d-block mb-2" style="color: var(--terracotta);">ADMIN PANEL</span>
        <h1 class="mb-0">Edit Package</h1>
    </div>

    <div class="bg-white p-4 p-md-5 shadow-sm" style="border: 1px solid #e7ddd1;">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $package->title) }}" required>
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control" required>{{ old('description', $package->description) }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $package->price) }}" required>
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Max Guests</label>
                    <input type="number" name="max_guests" class="form-control" value="{{ old('max_guests', $package->max_guests) }}">
                    @error('max_guests') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Amenities</label>
                <textarea name="amenities" rows="3" class="form-control">{{ old('amenities', $package->amenities) }}</textarea>
                @error('amenities') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                @if($package->image)
                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" style="width: 180px; height: 130px; object-fit: cover; border: 1px solid #ddd;">
                @else
                    <p class="text-muted mb-0">No image uploaded.</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" name="image" class="form-control">
                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    Visible on Explore page
                </label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dayunan">Update Package</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection