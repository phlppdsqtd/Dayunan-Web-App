@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-minimal p-5 shadow-sm">
            <h2 class="text-center mb-4">Join Day&uacute;nan</h2>
            <p class="text-center text-muted mb-4">A calm urban retreat awaits.</p>
            
            @if ($errors->any())
                <div class="alert alert-danger small rounded-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/signup') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control rounded-0" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-0" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control rounded-0" value="{{ old('mobile') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control rounded-0" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-0" required>
                </div>
                <button type="submit" class="btn btn-dayunan w-100">Create Account</button>
            </form>
            
            <p class="mt-4 text-center small text-muted">
                Already have an account? <a href="{{ url('/login') }}" class="text-terracotta text-decoration-none">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection