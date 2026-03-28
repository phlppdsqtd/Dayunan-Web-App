@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 850px;">
    <div class="mb-4">
        <span class="khula d-block mb-2" style="color: var(--terracotta);">ADMIN PANEL</span>
        <h1 class="mb-0">Add Package</h1>
    </div>

    <div class="bg-white p-4 p-md-5 shadow-sm" style="border: 1px solid #e7ddd1;">
        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Max Guests</label>
                    <input type="number" name="max_guests" class="form-control" value="{{ old('max_guests') }}">
                    @error('max_guests') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Amenities</label>
                <textarea name="amenities" rows="3" class="form-control">{{ old('amenities') }}</textarea>
                @error('amenities') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dayunan">Save Package</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection