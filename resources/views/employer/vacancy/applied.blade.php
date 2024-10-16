<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>{{ session('user.name') ?? 'Jobavel' }}</x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container">
            <h2 class="my-5 text-center fw-bold">Responses to your vacancies</h2>
            @if($vacancies->isEmpty())
                <div class="d-flex flex-column align-items-center justify-content-center vh-70">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <p class="text-muted text-sm">Create a new one or check your trashed vacancies</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('employer.vacancy.create') }}" class="btn btn-danger">Create new
                            vacancy</a>
                        <a href="{{ route('employer.vacancy.trashed') }}" class="btn btn-danger">View my
                            trash</a>
                    </div>
                </div>
            @else
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3 gap-1" id="v-pills-tab" role="tablist"
                         aria-orientation="vertical">
                        @foreach($vacancies as $index => $vacancy)
                            <button class="nav-link{{ $index === 0 ? ' active' : '' }}"
                                    id="v-pills-{{ $vacancy->id }}-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#v-pills-{{ $vacancy->id }}"
                                    type="button"
                                    role="tab"
                                    aria-controls="v-pills-{{ $vacancy->id }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                                    data-vacancy-slug="{{ $vacancy->slug }}">
                                {{ $vacancy->title }}
                            </button>
                        @endforeach
                    </div>
                    <div class="tab-content w-100" id="v-pills-tabContent">
                        @foreach($vacancies as $index => $vacancy)
                            <div class="tab-pane fade{{ $index === 0 ? ' show active' : '' }}"
                                 id="v-pills-{{ $vacancy->id }}"
                                 role="tabpanel"
                                 aria-labelledby="v-pills-{{ $vacancy->id }}-tab">
                                <div class="container employee-table" data-vacancy-slug="{{ $vacancy->slug }}">
                                    <h6 class="fst-italic">Vacancy was created at - {{ $vacancy->created_at }} UTC</h6>
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="card bg-dark shadow-table">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-borderless mb-0"
                                                               data-vacancy-slug="{{ $vacancy->slug }}">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">NO.</th>
                                                                <th scope="col">FULL NAME</th>
                                                                <th scope="col">CONTACT EMAIL</th>
                                                                <th scope="col">CV</th>
                                                                <th scope="col">APPLIED AT</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="tbody">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pagination-controls mt-3">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </x-main>

    <x-footer></x-footer>

    @pushonce('vite')
        @vite([
            'resources/assets/js/employer/getEmployeesForVacancy.js',
        ])
    @endpushonce

</x-layout>
