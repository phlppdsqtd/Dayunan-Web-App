@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-card p-5 shadow-lg" style="background: rgba(255,255,255,0.8); border: 1px solid #d8cab8;">
                <h2 class="tenor-sans text-jungle mb-4 text-center">Add Staff Member</h2>
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">FULL NAME</label>
                        <input type="text" name="name" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">ROLE (e.g. Front Desk)</label>
                        <input type="text" name="role" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">STAFF TYPE (e.g. Manager / Staff)</label>
                        <input type="text" name="staff_type" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">PHONE NUMBER</label>
                        <input type="text" name="contact_number" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control rounded-0" required>
                    </div>
                    <button type="submit" class="btn btn-dayunan w-100 py-3 mt-3">CREATE STAFF</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection