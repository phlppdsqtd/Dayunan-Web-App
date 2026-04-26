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

                <h2 class="tenor-sans text-jungle mb-4 text-center">Edit Staff Info</h2>
                
                <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                    @csrf 
                    @method('PUT')

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">FULL NAME</label>
                        <input type="text" name="name" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('name', $contact->name) }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">ROLE</label>
                        <input type="text" name="role" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('role', $contact->role) }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">STAFF TYPE</label>
                        <input type="text" name="staff_type" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('staff_type', $contact->staff_type) }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">PHONE NUMBER</label>
                        <input type="text" name="contact_number" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('contact_number', $contact->contact_number) }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control rounded-0 border-dark-subtle shadow-none" value="{{ old('email', $contact->email) }}" required>
                    </div>
<<<<<<< HEAD

                    <button type="submit" class="btn btn-dayunan-outline w-100 py-3 mt-3">UPDATE DETAILS</button>
=======
                    <button type="submit" class="btn btn-dayunan w-100 py-3 mt-3">UPDATE DETAILS</button>
>>>>>>> 9d1e214bcff5729b9dabc833c4576948133b9c18
                </form>
            </div>
        </div>
    </div>
</div>
@endsection