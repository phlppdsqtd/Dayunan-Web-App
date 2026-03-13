<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">DAYÚNAN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dayunanNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="dayunanNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/explore') }}">Explore</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/book') }}">Book</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                
                @auth
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/manage') }}">Manage</a></li>
                    
                    <li class="nav-item mx-2">
                        <span class="nav-link text-terracotta" style="text-transform: capitalize; font-weight: bold;">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </span>
                    </li>
                    
                    <li class="nav-item ms-3">
                        <form action="{{ url('/logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-dayunan">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item mx-2"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-item ms-3">
                        <a href="{{ url('/signup') }}" class="btn btn-dayunan">Signup</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>