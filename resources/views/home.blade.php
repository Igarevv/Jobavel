<x-layout>
    <x-slot:title>Jobavel</x-slot:title>

    <x-header></x-header>

    <x-main>
        @guest
            <div class="mt-5 background-badge">
                <section class="py-5 text-center container">
                    <div class="row py-lg-5">
                        <div class="col-lg-6 col-md-8 mx-auto">
                            <h1 class="fw-light"><strong class="text-white">Job<span
                                            class="red">avel</span></strong>
                            </h1>
                            <p class="lead text-light">Find or post developers jobs</p>
                            <div class="d-flex justify-content-center align-items-center flex-row">
                                <div class="text-center">
                                    <p class="text-white m-2">↓ I'm an Employee</p>
                                    <a href="{{ route('employee.register') }}" class="btn btn-danger mx-2">Start finding
                                        job</a>
                                    <a href="{{ route('employer.register') }}" class="btn btn-danger mx-2">Start posting
                                        job</a>
                                    <p class="text-white m-2">I'm an Employer ↑</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endguest
        <section class="py-5 text-center bg-light">
            <div class="container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-4 order-md-last">
                        <img src="{{ asset('static/home-picture-1.jpg') }}" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-lg-6 col-md-8 order-md-first">
                        <h2 class="fw-bold mt-3">Who we are?</h2>
                        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p class="text-center h5">Integer malesuada nunc vel risus commodo. Euismod in pellentesque
                            massa
                            placerat duis. Sed
                            viverra tellus in hac habitasse platea dictumst. Metus vulputate eu scelerisque felis
                            imperdiet proin fermentum leo vel. Turpis cursus in hac habitasse platea dictumst quisque
                            sagittis purus. Ut placerat orci nulla pellentesque dignissim. Gravida rutrum quisque non
                            tellus orci. Ut consequat semper viverra nam libero justo. Turpis egestas sed tempus urna et
                            pharetra pharetra. Vitae congue mauris rhoncus aenean vel elit scelerisque mauris
                            pellentesque. Aliquam faucibus purus in massa. Vestibulum lectus mauris ultrices eros.
                            Euismod nisi porta lorem mollis aliquam ut porttitor leo. Eget sit amet tellus cras
                            adipiscing enim eu turpis.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 text-center bg-light">
            <div class="container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-4 order-md-first">
                        <img src="{{ asset('static/home-picture-2.jpg') }}" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-lg-6 col-md-8 order-md-last">
                        <h2 class="fw-bold mt-3">Why you should choose us?</h2>
                        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <p class="text-center h5">Integer malesuada nunc vel risus commodo. Euismod in pellentesque
                            massa
                            placerat duis. Sed
                            viverra tellus in hac habitasse platea dictumst. Metus vulputate eu scelerisque felis
                            imperdiet proin fermentum leo vel. Turpis cursus in hac habitasse platea dictumst quisque
                            sagittis purus. Ut placerat orci nulla pellentesque dignissim. Gravida rutrum quisque non
                            tellus orci. Ut consequat semper viverra nam libero justo. Turpis egestas sed tempus urna et
                            pharetra pharetra. Vitae congue mauris rhoncus aenean vel elit scelerisque mauris
                            pellentesque. Aliquam faucibus purus in massa. Vestibulum lectus mauris ultrices eros.
                            Euismod nisi porta lorem mollis aliquam ut porttitor leo. Eget sit amet tellus cras
                            adipiscing enim eu turpis.</p>
                    </div>
                </div>
            </div>
        </section>
        <h2 class="text-center my-5">These companies leave their vacancies with us</h2>
        <div class="row justify-content-center background-greeting">
            @foreach($logos as $logo)
                <div class="col-2 d-flex justify-content-center my-3">
                    <x-image.logo url="{{ $logo->url }}" imgColSize="4"></x-image.logo>
                </div>
            @endforeach
        </div>
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="text-center fw-bold text-decoration-underline">The latest published vacancies</h2>
                <form action="" method="post">
                    @csrf
                    <div class="row my-4">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Search Jobavel...">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-danger">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="container my-5 w-85">
                <div class="row gx-2 gy-4">
                    @foreach($vacancies as $vacancy)
                        <div class="col-lg-6 col-12 d-flex justify-content-center">
                            <x-card.jobcard :class="'w-85'" :vacancy="$vacancy"></x-card.jobcard>
                        </div>
                    @endforeach
                    <a href="{{ route('vacancies.all') }}" class="btn btn-outline-danger float-center">Show more</a>
                </div>
            </div>
        </div>
    </x-main>

    <x-footer></x-footer>
</x-layout>

