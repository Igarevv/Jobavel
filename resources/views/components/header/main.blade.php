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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</div>
