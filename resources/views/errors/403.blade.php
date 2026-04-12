@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center px-4">
        <span class="khula text-terracotta d-block mb-3" style="letter-spacing: 0.4rem; font-size: 0.7rem;">ACCESS RESTRICTED</span>
        <h1 class="tenor-sans text-jungle mb-3" style="font-size: 3rem; letter-spacing: 0.2rem;">403</h1>
        <div class="mx-auto mb-4" style="width: 40px; height: 1px; background-color: #C26B4E;"></div>
        <p class="cormorant fst-italic text-muted mb-5" style="font-size: 1.3rem;">
            This area is reserved for administrators only.
        </p>
        <a href="{{ url('/') }}" class="btn btn-dayunan px-5 py-3 tenor-sans" style="font-size: 0.7rem; letter-spacing: 0.2rem;">
            Return to Home
        </a>
    </div>
</div>

<style>
    .tenor-sans { font-family: 'Tenor Sans', sans-serif; text-transform: uppercase; }
    .khula { font-family: 'Khula', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }
</style>
@endsection