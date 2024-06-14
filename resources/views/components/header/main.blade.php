<div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a href="/" class="navbar-brand d-flex align-items-center">
            <strong>Job<span @style(['color:#f9322c'])>avel</span></strong>
        </a>
        <div class="d-flex gap-3">
            <div>
                <a href="{{ route('login.show') }}" class="btn btn-outline-light">Sign In</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</div>
