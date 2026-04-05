@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(to bottom, #F5F1EC 0%, #f8f5f0 100%); min-height: 100vh;">
    <div class="container py-5" style="margin-top: 80px;">
        <div class="text-center mb-5">
            <span class="khula d-block mb-3" style="color: var(--terracotta);">MANAGE YOUR STAY</span>
            <h1 class="mb-3">Manage Access</h1>
            <p class="mx-auto text-muted" style="max-width: 680px; font-size: 1.05rem;">
                Access your booking details or continue to the admin panel.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="bg-white h-100 p-4 p-md-5 shadow-sm text-center" style="border: 1px solid #e7ddd1;">
                    <span class="khula d-block mb-3" style="color: var(--terracotta);">GUEST</span>
                    <h3 class="mb-3">Manage Booking</h3>
                    <p class="text-muted mb-4">
                        View your booking details through your booking email and reference information.
                    </p>
                    <a href="{{ route('manage.index') }}" class="btn btn-dayunan w-100">Go to Manage Booking</a>
                </div>
            </div>

            {{-- <div class="col-md-5">
                <div class="bg-white h-100 p-4 p-md-5 shadow-sm text-center" style="border: 1px solid #e7ddd1;">
                    <span class="khula d-block mb-3" style="color: var(--terracotta);">ADMIN</span>
                    <h3 class="mb-3">Admin Login</h3>
                    <p class="text-muted mb-4">
                        Sign in to edit accommodation cards, update details, upload images, and manage visibility.
                    </p>
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-dark w-100">Go to Admin Login</a>
                </div>
            </div> --}}
        </div>
    </div>
</section>
@endsection