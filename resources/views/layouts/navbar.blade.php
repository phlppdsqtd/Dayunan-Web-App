<nav class="navbar navbar-expand-lg fixed-top transition-all">
    <div class="container">
        <a class="navbar-brand tenor-sans fw-bold" href="{{ url('/') }}" style="font-size: 1.5rem; letter-spacing: 0.3rem;">DAYÚNAN</a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#dayunanNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="dayunanNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item mx-2"><a class="nav-link khula fw-bold" href="{{ url('/explore') }}">Explore</a></li>
                <li class="nav-item mx-2"><a class="nav-link khula fw-bold" href="{{ url('/book') }}">Book</a></li>
                <li class="nav-item mx-2"><a class="nav-link khula fw-bold" href="{{ url('/contact') }}">Contact</a></li>
                <li class="nav-item mx-2"><a class="nav-link khula fw-bold" href="{{ route('manage.index') }}">Manage</a></li>
                
                @auth
                    <li class="nav-item mx-2 ms-lg-4">
                        <span class="nav-link text-terracotta khula fw-bold">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </span>
                    </li>
                    
                    <li class="nav-item ms-lg-2">
                        <form action="{{ url('/logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn-logout-nav">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item mx-2"><a class="nav-link khula fw-bold" href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ url('/signup') }}" class="btn btn-dayunan py-2 px-4" style="font-size: 0.6rem;">Signup</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        transition: all 0.5s ease;
        padding: 1.5rem 0;
        z-index: 1000; /* Ensures it stays above glass cards */
    }

    /* DEFAULT STATE (Inner Pages) */
    .is-inner .navbar {
        background: white !important;
        border-bottom: 1px solid var(--sandstorm-beige);
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }
    .is-inner .navbar .nav-link, .is-inner .navbar .navbar-brand {
        color: var(--jungle-green) !important;
    }

    /* HOME STATE (Initially Transparent) */
    .is-home .navbar {
        background: transparent !important;
    }
    .is-home .navbar .nav-link, .is-home .navbar .navbar-brand {
        color: white !important;
    }

    /* HOME STATE (After Scroll) */
    .is-home .navbar.scrolled {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        padding: 1rem 0;
    }
    .is-home .navbar.scrolled .nav-link, .is-home .navbar.scrolled .navbar-brand {
        color: var(--jungle-green) !important;
    }

    /* --- THE LOGOUT BUTTON STYLE --- */
    .btn-logout-nav {
        background: transparent;
        border: 1px solid var(--terracotta);
        color: var(--terracotta) !important;
        font-family: 'Khula', sans-serif;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.6rem;
        letter-spacing: 0.1rem;
        padding: 8px 18px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    /* On Home Page (Before Scroll), make the border white for visibility */
    .is-home .navbar:not(.scrolled) .btn-logout-nav {
        border-color: white;
        color: white !important;
    }

    .btn-logout-nav:hover {
        background: var(--terracotta);
        color: white !important;
        border-color: var(--terracotta);
    }

    /* Nav Link Underline */
    .nav-link { position: relative; }
    .nav-link::after {
        content: ''; position: absolute; width: 0; height: 1px;
        bottom: 5px; left: 0; background-color: var(--terracotta);
        transition: width 0.4s ease;
    }
    .nav-link:hover::after { width: 100%; }
</style>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>