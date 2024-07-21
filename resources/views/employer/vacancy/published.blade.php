@php use App\Enums\Vacancy\EmploymentEnum; @endphp
<x-layout>
    <x-slot:title>{{ session('user.name') }} </x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-5 mb-5">
            @if($vacancies->isEmpty())
                <div class="text-center">
                    <h2 class="fw-bold">Your trashed vacancies</h2>
                    <h5 class="fw-bold text-muted">Here you can restore or permanently delete your vacancy</h5>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center" style="height: 70vh;">
                    <h1 class="text-danger fw-bold">Vacancies not found</h1>
                    <p class="text-muted text-sm">Create a new one or check your trashed vacancies</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('employer.vacancy.create') }}" class="btn btn-danger">Create new vacancy</a>
                        <a href="{{ route('employer.vacancy.trashed') }}" class="btn btn-danger">View my trash</a>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <h5 class="fw-light">company</h5>
                    <h1 class="red text-decoration-underline fw-bold fw-italic">{{ session('user.name') }}</h1>
                    <h4 class="fw-light">Total number of vacancy</h4>
                    <h5 class="fw-normal mb-5">{{ $vacancies->total() }}</h5>
                </div>

                <div class="row" style="border: 5px solid #212529;">
                    <form action="{{ route('employer.vacancy.published') }}" class="col-md-3 filter-column"
                          style="max-height:75vh;" id="filterForm">
                        <div class="d-flex flex-column h-75" style="overflow-y: scroll;">
                            <div class="sticky-top" style="background-color:#212529;">
                                <h4 class="text-center fw-bold">Filters</h4>
                            </div>
                            <div class="mb-3">
                                <h6 class="fw-bold text-decoration-underline fst-italic">By technology</h6>
                                <x-categories.skills-filter :skillSet="$skills"
                                                            name="skills"></x-categories.skills-filter>
                            </div>
                            <div class="mb-3">
                                <h6 class="fw-bold text-decoration-underline fst-italic">By experience</h6>
                                <div class="text-14 ps-1">
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
                                        <input type="range" name="salary" min="0" max="1000"
                                               value="{{ old('salary', 0) }}"
                                               class="form-range" id="rangeInput"
                                               oninput="this.nextElementSibling.value = '$'+this.value">
                                        <output id="salaryOutput"></output>
                                    </div>
                                    <div>
                                        <input type="number" min="0" max="1000" class="form-input"
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
                        <div class="d-flex justify-content-center alight-items-center">
                            <x-button.outline type="submit" colorType="danger">Apply filters</x-button.outline>
                        </div>
                    </form>
                    <div class="col-md-9 content-column">
                        <h4 class="text-center fw-bold">List of your vacancies</h4>
                        <div class="d-flex flex-column align-items-center">
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
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $vacancies->links() }}
                </div>
            @endif
        </div>
    </x-main>
    @once
        @push('vacancy-css')
            <link href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
        @endpush
    @endonce

    <script src="/assets/js/rangeNumberInput.js"></script>

    <x-footer></x-footer>
</x-layout>