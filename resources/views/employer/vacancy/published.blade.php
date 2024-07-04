<x-layout>
    <x-slot:title>{{ session('user.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-5 mb-5">
            <div class="text-center">
                <h5 class="fw-light">company</h5>
                <h1 class="red text-decoration-underline fw-bold fw-italic">{{ 'Adidas Inc.' }}</h1>
                <h4 class="fw-light">Total number of vacancy</h4>
                <h5 class="fw-normal mb-5">{{ 0 }}</h5>
            </div>
            @php
                $parameters = ['PHP', 'Laravel', 'Git', 'Python', 'Java', 'Docker'];
            @endphp
            <div class="row" @style(['border: 5px solid #212529', 'border-radius: 0% 10% 10% 0%'])>
                <div class="col-md-3 filter-column">
                    <h4 class="text-center fw-bold">Filters</h4>
                    <h6>By technology</h6>
                    <x-catalog.filterul :parameters="$parameters"></x-catalog.filterul>
                </div>

                <div class="col-md-9 content-column">
                    <h4 class="text-center fw-bold">List of your vacancies</h4>
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center gap-5">
                            <x-card.jobcard :jobInfo="$jobInfo"></x-card.jobcard>
                            <a href="#" class="btn btn-outline-primary">Edit</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-5">
                            <x-card.jobcard :jobInfo="$jobInfo"></x-card.jobcard>
                            <a href="#" class="btn btn-outline-primary">Edit</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-5">
                            <x-card.jobcard :jobInfo="$jobInfo"></x-card.jobcard>
                            <a href="#" class="btn btn-outline-primary">Edit</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-main>

    <x-footer></x-footer>
</x-layout>
