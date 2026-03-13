@extends('layouts.app')

@section('content')
<div class="row min-vh-75 align-items-center text-center">
    <div class="col-12 py-5">
        <h1 class="display-3 mb-3">A quiet space to slow down.</h1>
        <p class="lead mb-5 mx-auto" style="max-width: 700px; font-style: italic;">
            "Step into the sun, drift into the water."
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('/explore') }}" class="btn btn-dayunan">Explore the Villa</a>
            <a href="{{ url('/book') }}" class="btn btn-outline-dayunan">Book Your Stay</a>
        </div>
    </div>
    
    <div class="col-12 mt-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-minimal p-4 h-100">
                    <h3 class="h5">Rest</h3>
                    <p class="small text-muted mb-0">Designed for slow mornings and quiet nights in the heart of Bacolod.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-minimal p-4 h-100">
                    <h3 class="h5">Gather</h3>
                    <p class="small text-muted mb-0">A warm, grounded space where families and friends reconnect.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-minimal p-4 h-100">
                    <h3 class="h5">Balance</h3>
                    <p class="small text-muted mb-0">From poolside relaxation to focused coworking, find your rhythm.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection