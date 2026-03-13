@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-minimal p-5 shadow-sm">
            <h2 class="text-center mb-4">Welcome Back</h2>
            <p class="text-center text-muted mb-4">Everything is set so you can settle in.</p>
            
            @if ($errors->any())
                <div class="alert alert-danger small rounded-0">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-0" value="{{ old('email') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control rounded-0" required>
                </div>
                <button type="submit" class="btn btn-dayunan w-100">Sign In</button>
            </form>
            
            <p class="mt-4 text-center small text-muted">
                New to Day&uacute;nan? <a href="{{ url('/signup') }}" class="text-terracotta text-decoration-none">Create an account</a>
            </p>
        </div>
    </div>
</div>
@endsection