@extends('layouts.app')

@section('content')
<div class="manage-page-wrapper d-flex align-items-center justify-content-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6"> 
                
                <div class="contact-card p-5 shadow-lg animate-fade-up text-center">
                    
                    <section class="mb-4">
                        <span class="khula fw-bold text-terracotta mb-2 d-block animate-letter-spacing" style="letter-spacing: 0.4rem; font-size: 0.7rem;">RETRIEVE STAY</span>
                        <h2 class="tenor-sans text-jungle display-6 mb-0">Manage your stay.</h2>
                        <div class="mx-auto mt-4 accent-line"></div>
                    </section>

                    <form action="{{ route('manage.search') }}" method="POST" class="mt-5 px-lg-3">
                        @csrf
                        <div class="mb-4 text-start">
                            <label for="email" class="khula fw-bold text-muted mb-2" style="font-size: 0.7rem; letter-spacing: 0.1rem;">REGISTERED EMAIL</label>
                            <input type="email" name="email" id="email"
                                   class="form-control text-center py-3 khula" 
                                   style="border-radius: 0; border: 1px solid rgba(216, 202, 184, 0.8); background-color: rgba(255, 255, 255, 0.9);"
                                   placeholder="Enter your email address" required>
                        </div>
                        <button type="submit" class="btn btn-dayunan w-100 py-3 tenor-sans mt-2" style="letter-spacing: 0.1rem;">Search Records</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* --- Core Layout CSS --- */
    .manage-page-wrapper {
        min-height: 85vh;
        background-color: var(--coconut-white);
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(216, 202, 184, 0.4);
        border-radius: 0;
    }

    .accent-line {
        width: 40px;
        height: 1px;
        background-color: var(--terracotta);
    }

    /* --- Typography --- */
    .tenor-sans { font-family: 'Tenor Sans', sans-serif; text-transform: uppercase; }
    .khula { font-family: 'Khula', sans-serif; }

    /* --- Animations --- */
    .animate-fade-up {
        animation: fadeUp 1s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-letter-spacing {
        animation: letterSpace 2s ease forwards;
    }
    @keyframes letterSpace {
        from { letter-spacing: 0.1rem; opacity: 0; }
        to { letter-spacing: 0.4rem; opacity: 1; }
    }
</style>
@endsection