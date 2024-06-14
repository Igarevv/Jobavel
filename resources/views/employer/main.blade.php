<x-layout>
    <x-slot:title>Main</x-slot:title>
    <x-employer.header/>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="d-flex align-items-center flex-column">
                <div class="col-md-2">
                    <img src="/logo/Adidas_Logo.jpg" class="img-fluid logo-image" alt="logo">
                </div>
                <h1 class="text-center fw-bold">Adidas Inc.</h1>
            </div>
            <div class="row mt-5 justify-content-center">
                <div class="col-md-4 custom-col-lg-3 mb-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center my-3">
                                <h3>Your</h3>
                                <h5>total number of vacancy</h5>
                                <p>{{ '0' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 custom-col-lg-3 mb-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center my-3">
                                <h3>Your</h3>
                                <h5>total number of responses for today</h5>
                                <p> {{ '0' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 custom-col-lg-3 mb-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center my-3">
                                <h3>Your</h3>
                                <h5>total number of responses for month</h5>
                                <p> {{ '0' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 custom-col-lg-3 mb-4">
                    <div class="card border shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center my-3">
                                <h3>Your</h3>
                                <h5>top 3 most frequent required skills</h5>
                                <p> {{ 'PHP, Git, Laravel' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-layout>
