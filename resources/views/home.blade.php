<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Jobavel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

<header data-bs-theme="dark">
    <div class="collapse text-bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4>About</h4>
                    <p class="text-body-secondary">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <h4>Contact</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Follow on Twitter</a></li>
                        <li><a href="#" class="text-white">Like on Facebook</a></li>
                        <li><a href="#" class="text-white">Email me</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <strong>Job<span @style(['color:#f9322c'])>avel</span></strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>

<main>
    <div @style(['background:#212529']) class="mt-5">
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><strong @style(['color:white'])>Job<span @style(['color:#f9322c'])>avel</span></strong></h1>
                    <p class="lead text-light">Find or post developers jobs</p>
                    <p>
                        <a href="#" class="btn btn-danger my-2">Want to find job</a>
                        <a href="#" class="btn btn-danger my-2">Want to post job</a>
                    </p>
                </div>
            </div>
        </section>
    </div>


    <div class="album py-5 bg-body-tertiary">
        <div class="container">

            <div class="row my-4">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search Laravel Gigs...">
                </div>
                <div class="col-auto">
                    <button class="btn btn-danger">Search</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Senior Developer | Laravel & Vue</h5>
                            <p class="card-text">Wonka Industries</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">api</span>
                                <span class="badge bg-dark text-light">vue</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Miami, FL</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Backend Engineer</h5>
                            <p class="card-text">Skynet Systems</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">backend</span>
                                <span class="badge bg-dark text-light">api</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Boston, MA</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Laravel Developer</h5>
                            <p class="card-text">Wayne Enterprises</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">vue</span>
                                <span class="badge bg-dark text-light">api</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Gotham, NY</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 job-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Junior Developer</h5>
                            <p class="card-text">Stark Industries</p>
                            <div>
                                <span class="badge bg-dark text-light">laravel</span>
                                <span class="badge bg-dark text-light">html</span>
                                <span class="badge bg-dark text-light">css</span>
                            </div>
                            <p class="card-text"><small class="text-muted">Newark, NJ</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<footer @style(['background:#f9322c', 'color:#fff'])class="py-5">
    <div class="container">
        <p class="float-end mb-1">
            <a href="#" @style(['color:white'])>Back to top</a>
        </p>
        <p class="mb-1">Copyright @ 2024 All rights reserved</p>
        <a href="/" @style(['color:white'])>Visit the homepage</a>
    </div>
</footer>
</body>
</html>

