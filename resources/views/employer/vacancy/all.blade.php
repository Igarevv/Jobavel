@php
    use App\Enums\Vacancy\EmploymentEnum;
@endphp
<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>{{ $vacancy->title ?? 'Jobavel' }}</x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container">
            <div class="row my-5">
                <div class="mb-5">
                    <h1 class="text-center">All published vacancies</h1>
                    <h6 class="text-muted text-center">Found: {{ $vacancies->total() ?? 0 }} vacancies</h6>
                </div>
                <div class="col-lg-8 offset-lg-1 d-flex justify-content-center align-items-center flex-column">
                    @forelse($vacancies as $vacancy)
                        <x-card.jobcard :vacancy="$vacancy" :class="'w-75'"></x-card.jobcard>
                    @empty
                        <div class="d-flex flex-column align-items-center justify-content-center vh-50">
                            <h2 class="text-danger fw-bold">Vacancies not found</h2>
                            <p class="text-muted text-sm">UFO stole all vacancies. Please, wait until we contact
                                them</p>
                        </div>
                    @endforelse
                </div>
                <div class="col-lg-3">
                    <div class="sticky-top top-15 d-flex flex-column justify-content-center gap-3">
                        <form data-url="{{ route('vacancies.all') }}"
                              id="filterForm">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <h3 class="text-center">Filters</h3>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseOne">
                                            Technology
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
                                         aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <x-categories.skills-filter-raw :skillSet="$skills"
                                                                            name="skills"></x-categories.skills-filter-raw>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseTwo">
                                            Experience
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                         aria-labelledby="panelsStayOpen-headingThree">
                                        <div class="accordion-body">
                                            <div class="text-14 ps-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="flexCheckChecked"
                                                           value="1" name="consider">
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        Consider without experience
                                                    </label>
                                                </div>
                                                <x-input.radio name="experience" label="Without experience"
                                                               value="0"></x-input.radio>
                                                <x-input.radio name="experience" label="1+ year"
                                                               value="1"></x-input.radio>
                                                <x-input.radio name="experience" label="3+ year"
                                                               value="3"></x-input.radio>
                                                <x-input.radio name="experience" label="5+ year"
                                                               value="5"></x-input.radio>
                                                <x-input.radio name="experience" label="10+ year"
                                                               value="10"></x-input.radio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseThree">
                                            Employment
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                         aria-labelledby="panelsStayOpen-headingFour">
                                        <div class="accordion-body">
                                            <div class="text-14 ps-1">
                                                <x-input.radio name="employment" label="Office"
                                                               value="{{ EmploymentEnum::EMPLOYMENT_OFFICE->value }}">
                                                </x-input.radio>
                                                <x-input.radio name="employment" label="Remote"
                                                               value="{{ EmploymentEnum::EMPLOYMENT_REMOTE->value }}">
                                                </x-input.radio>
                                                <x-input.radio name="employment" label="Part-time"
                                                               value="{{ EmploymentEnum::EMPLOYMENT_PART_TIME->value }}">
                                                </x-input.radio>
                                                <x-input.radio name="employment" label="Office / remote"
                                                               value="{{ EmploymentEnum::EMPLOYMENT_MIXED }}">
                                                </x-input.radio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseFour">
                                            Salary
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
                                         aria-labelledby="panelsStayOpen-headingFive">
                                        <div class="accordion-body">
                                            <div class="text-14 w-75 d-flex gap-2 flex-column ps-1">
                                                <div class="d-flex flex-row gap-2">
                                                    <input type="range" name="salary" min="0"
                                                           max="{{ $vacancies->max('salary') }}"
                                                           value="{{ old('salary', 0) }}"
                                                           class="form-range" id="rangeInput">
                                                    <output id="salaryOutput"></output>
                                                </div>
                                                <div>
                                                    <input type="number" min="0" max="{{ $vacancies->max('salary') }}"
                                                           class="form-input"
                                                           value="{{ old('salary', 0) }}"
                                                           id="numberInput">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseSix">
                                            Location
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse"
                                         aria-labelledby="panelsStayOpen-headingSeven">
                                        <div class="accordion-body">
                                            <div class="text-14 w-75 d-flex gap-2 ps-1">
                                                <input type="text" class="form-input" placeholder="USA"
                                                       value="{{ old('location') }}" name="location">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around alight-items-center mt-3">
                                    <a href="{{ route('vacancies.all') }}" class="btn btn-outline-warning">Reset
                                        filters</a>
                                    <x-button.outline type="submit" colorType="danger">Apply filters</x-button.outline>
                                </div>
                            </div>
                        </form>
                        <div>
                            {{ $vacancies->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-main>
    <x-footer></x-footer>

    <script nonce="{{ csp_nonce() }}" src="/assets/js/employer/filter.js"></script>
</x-layout>