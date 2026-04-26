@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-card p-5 shadow-lg position-relative" style="background: rgba(255,255,255,0.8); border: 1px solid #d8cab8;">
                
                <!-- Back Button -->
                <div class="position-absolute" style="top: 20px; left: 20px;">
                    <a href="{{ route('contact.index') }}" class="text-decoration-none text-muted khula small d-flex align-items-center gap-1" style="letter-spacing: 0.1rem;">
                        <i class="bi bi-arrow-left"></i> BACK
                    </a>
                </div>

                <h2 class="tenor-sans text-jungle mb-4 text-center">Add Staff Member</h2>
                
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">FULL NAME</label>
                        <input type="text" name="name" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">ROLE (e.g. Front Desk)</label>
                        <input type="text" name="role" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('role') }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">STAFF TYPE (e.g. Manager / Staff)</label>
                        <input type="text" name="staff_type" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('staff_type') }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">PHONE NUMBER</label>
                        <input type="text" name="contact_number" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('contact_number') }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('email') }}" required>
                    </div>
<<<<<<< HEAD

                    <button type="submit" class="btn btn-dayunan-outline w-100 py-3 mt-3">CREATE STAFF</button>
=======
                    <button type="submit" class="btn btn-dayunan w-100 py-3 mt-3">CREATE STAFF</button>
>>>>>>> 9d1e214bcff5729b9dabc833c4576948133b9c18
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-dayunan-outline {
        border: 1px solid var(--jungle-green);
        color: var(--jungle-green);
        background: transparent;
        border-radius: 0;
        letter-spacing: 0.2rem;
        transition: all 0.4s ease;
    }
    .btn-dayunan-outline:hover { background-color: var(--jungle-green); color: #fff; }
    .text-muted:hover { color: var(--terracotta) !important; transition: color 0.3s ease; }
</style>
@endsection