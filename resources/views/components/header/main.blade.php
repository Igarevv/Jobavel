<div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center logo-greeting">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <strong>Job<span class="red">avel</span></strong>
            </a>
            <h6 class="text-center my-3 text-letter-spacing background-greeting">
                @greeting()
            </h6>
        </div>
        <div class="d-flex gap-3">
            @auth
                <form action="{{ route('login.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Log out</button>
                </form>
            @endauth
            @guest
                <div>
                    <a href="{{ route('login.show') }}" class="btn btn-outline-light">Sign In</a>
                </div>
            @endguest
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                         class="bi bi-grid-fill" viewBox="0 0 16 16">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z"/>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
