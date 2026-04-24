@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-card p-5 shadow-lg">
                <h2 class="tenor-sans text-jungle mb-4 text-center">Edit Staff</h2>
                
                <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">STAFF NAME</label>
                        <input type="text" name="name" class="form-control" value="{{ $contact->name }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">ROLE</label>
                        <input type="text" name="role" class="form-control" value="{{ $contact->role }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">CONTACT NUMBER</label>
                        <input type="text" name="contact_number" class="form-control" value="{{ $contact->contact_number }}" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="khula fw-bold small">EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control" value="{{ $contact->email }}" required>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary w-50">CANCEL</a>
                        <button type="submit" class="btn btn-dayunan-outline w-50">SAVE CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection