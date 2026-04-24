@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-card p-5 shadow-lg" style="background: rgba(255,255,255,0.8); border: 1px solid #d8cab8;">
                <h2 class="tenor-sans text-jungle mb-4 text-center">Edit Staff Info</h2>
                <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">FULL NAME</label>
                        <input type="text" name="name" class="form-control rounded-0" value="{{ $contact->name }}" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">ROLE</label>
                        <input type="text" name="role" class="form-control rounded-0" value="{{ $contact->role }}" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">STAFF TYPE</label>
                        <input type="text" name="staff_type" class="form-control rounded-0" value="{{ $contact->staff_type }}" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">PHONE NUMBER</label>
                        <input type="text" name="contact_number" class="form-control rounded-0" value="{{ $contact->contact_number }}" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control rounded-0" value="{{ $contact->email }}" required>
                    </div>
                    <button type="submit" class="btn btn-dayunan-outline w-100 py-3 mt-3">UPDATE DETAILS</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection