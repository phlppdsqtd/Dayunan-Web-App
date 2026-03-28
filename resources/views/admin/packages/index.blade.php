@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="khula d-block mb-2" style="color: var(--terracotta);">ADMIN PANEL</span>
            <h1 class="mb-0">Manage Packages</h1>
        </div>

        <a href="{{ route('admin.packages.create') }}" class="btn btn-dayunan">
            Add Package
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive bg-white shadow-sm" style="border: 1px solid #e7ddd1;">
        <table class="table align-middle mb-0">
            <thead style="background-color: #f8f3ed;">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Guests</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr>
                        <td class="p-3">
                            @if($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" style="width: 90px; height: 70px; object-fit: cover; border: 1px solid #ddd;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td class="p-3">{{ $package->title }}</td>
                        <td class="p-3">₱{{ number_format($package->price, 2) }}</td>
                        <td class="p-3">{{ $package->max_guests ?? 'N/A' }}</td>
                        <td class="p-3">
                            @if($package->is_active)
                                <span class="badge text-bg-success">Visible</span>
                            @else
                                <span class="badge text-bg-secondary">Hidden</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-sm btn-outline-dark">
                                    Edit
                                </a>

                                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Delete this package?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-muted">No packages yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection