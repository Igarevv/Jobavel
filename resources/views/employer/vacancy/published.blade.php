@php use App\Enums\Vacancy\EmploymentEnum; @endphp
<x-layout>
    <x-slot:title>{{ session('user.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-5 mb-5">
            <div class="text-center">
                <h5 class="fw-light">company</h5>
                <h1 class="red text-decoration-underline fw-bold fw-italic">{{ session('user.name') }}</h1>
                <h4 class="fw-light">Total number of vacancy</h4>
                <h5 class="fw-normal mb-5">{{ $vacancies->total() ?? 0 }}</h5>
            </div>

            <div class="row border-published">
                <form data-url="{{ route('employer.vacancy.published') }}" class="col-md-3 filter-column mh-75vh"
                      id="filterForm">
                    <div class="d-flex flex-column h-75 overflow-scroll">
                        <div class="sticky-top dark-gray">
                            <h4 class="text-center fw-bold">Filters</h4>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-decoration-underline fst-italic">By technology</h6>
                            <x-categories.skills-filter-column :skillSet="$skills"
                                                               name="skills"></x-categories.skills-filter-column>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-decoration-underline fst-italic">By experience</h6>
                            <div class="text-14 ps-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckChecked"
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
                            @error('experience')
                            <span class="text-danger fw-bold mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-decoration-underline fst-italic">By employment</h6>
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
                        <div class="mb-3">
                            <h6 class="fw-bold text-decoration-underline fst-italic">Salary (max)</h6>
                            <div class="text-14 w-75 d-flex gap-2 flex-column ps-1">
                                <div class="d-flex flex-row gap-2">
                                    <input type="range" name="salary" min="0" max="{{ $vacancies->max('salary') }}"
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
                        <div class="mb-3">
                            <h6 class="fw-bold text-decoration-underline fst-italic">Location</h6>
                            <div class="text-14 w-75 d-flex gap-2 ps-1">
                                <input type="text" class="form-input" placeholder="USA"
                                       value="{{ old('location') }}" name="location">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around alight-items-center mt-3">
                        <a href="{{ route('employer.vacancy.published') }}" class="btn btn-outline-warning">Reset
                            filters</a>
                        <x-button.outline type="submit" colorType="danger">Apply filters</x-button.outline>
                    </div>
                </form>
                <div class="col-md-9 content-column mh-75vh">
                    <div class="d-flex flex-column align-items-center">
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
                            <h4 class="text-center fw-bold">List of your published vacancies</h4>
                            @foreach($vacancies as $vacancy)
                                <div class="d-flex align-items-center justify-content-center gap-5 transform-card">
                                    <x-card.jobcard :vacancy="$vacancy"></x-card.jobcard>
                                    <div class="d-flex flex-row gap-3">
                                        <a href="{{ route('employer.vacancy.show.edit', ['vacancy' => $vacancy->id]) }}"
                                           class="btn btn-outline-primary">Edit</a>
                                        <form action="{{ route('employer.vacancy.unpublish', ['vacancy' => $vacancy->id]) }}"
                                              method="POST">
                                            @csrf
                                            <x-button.outline colorType="danger" type="submit">Unpublish
                                            </x-button.outline>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-3">
                {{ $vacancies->withQueryString()->links() }}
            </div>
        </div>
    </x-main>
    @once
        @push('vacancy-css')
            <link nonce="{{ csp_nonce() }}" href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
        @endpush
    @endonce
    <x-footer></x-footer>
    <script nonce="{{ csp_nonce() }}" src="/assets/js/employer/filter.js"></script>
</x-layout>