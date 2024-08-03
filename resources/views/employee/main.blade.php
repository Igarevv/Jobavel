@pushonce('employee-css')
    <link rel="stylesheet" href="/assets/css/employee.css" nonce="{{ csp_nonce() }}" type="text/css">
@endpushonce

@pushonce('vacancy-css')
    <link nonce="{{ csp_nonce() }}" href="/assets/css/vacancy.css" type="text/css" rel="stylesheet">
@endpushonce

<x-layout class="d-flex flex-column min-vh-100">
    <x-header></x-header>
    <x-main>
        <div class="container my-5">
            <div class="mb-5">
                <h4 class="text-center mb-3 font-monospace text-muted">Home page</h4>
                <h2 class="text-center text-decoration-underline link-danger fw-bold">My personal data</h2>
                <h6 class="text-center text-muted">*To change your information, just click on your data</h6>
            </div>
            <div class="w-75 mx-auto">
                @session('nothing-updated')
                <div class="alert alert-success text-center fw-bold my-2">
                    {{ $value }}
                </div>
                @endsession
                @session('success-updated')
                <div class="alert alert-success text-center fw-bold my-2">
                    {{ $value }}
                </div>
                @endsession
                <form method="post" action="{{ route('employee.account.personal-info') }}">
                    @csrf
                    <div class="d-flex flex-column justify-content-center text-center align-items-center">
                        <div class="d-flex gap-5 mb-5 text-center justify-content-center">
                            <x-input.block form="group">
                                <label for="last-name" class="text-muted mb-2">Your last name</label>
                                <h5 class="editable-input input-hover fw-bold px-2"
                                    data-id="last-name">{{ old('last-name') ?? $employee->lastName ?? '[last name]' }}</h5>
                                <input type="text" class="form-control py-2 d-none" name="last-name" id="last-name"
                                       value="{{ old('last-name') ?? $employee->lastName ?? '' }}">
                                @error('last-name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </x-input.block>

                            <x-input.block form="group">
                                <label for="first-name" class="text-muted mb-2">Your first name</label>
                                <h5 class="editable-input input-hover fw-bold px-2"
                                    data-id="first-name">{{ old('first-name') ?? $employee->firstName ?? '[first name]' }}</h5>
                                <input type="text" class="form-control py-2 d-none" name="first-name"
                                       id="first-name"
                                       value="{{ old('first-name') ?? $employee->firstName }}">
                                @error('first-name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </x-input.block>
                        </div>
                        <div class="w-50">
                            <x-input.block form="group" class="mb-5 col-12">
                                <label for="position" class="text-muted mb-2">Your job position</label>
                                <h5 class="editable-input input-hover fw-bold px-2"
                                    data-id="position">{{ old('position') ?? $employee->currentPosition ?? '[current position]'}}</h5>
                                <input type="text" class="form-control d-none" name="position" id="position"
                                       value="{{ old('position') ?? $employee->currentPosition ?? '' }}">
                                @error('position')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </x-input.block>

                            <x-input.block form="group" class="mb-5 col-12">
                                <label for="salary" class="text-muted mb-2">Your preferred salary in $</label>
                                <h5 class="editable-input input-hover fw-bold px-2"
                                    data-id="salary">{{ old('position') ?? $employee->salary ?? 0 }}</h5>
                                <input type="number" min="0" max="999999" class="form-control py-2 d-none"
                                       name="salary"
                                       id="salary" value="{{ old('position') ?? $employee->salary ?? 0 }}">
                                @error('salary')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </x-input.block>

                            <x-input.block form="group" class="mb-5 col-12">
                                <label for="about-employee" class="text-muted mb-2">Some sentences about me</label>
                                <h5 class="editable-input input-hover fw-bold text-block lh-sm px-2"
                                    data-id="about-employee">{{ old('about-employee') ?? $employee->aboutEmployee ?? '[about you]' }}</h5>
                                <textarea class="form-control d-none" rows="3" name="about-employee"
                                          id="about-employee">{{ old('about-employee') ?? $employee->aboutEmployee ?? '' }}</textarea>
                                @error('about-employee')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </x-input.block>
                        </div>
                    </div>

                    <h3 class="text-center text-decoration-underline link-danger fw-bold mb-5">Optional</h3>

                    <div class="mb-5">
                        <div class="text-center mb-4">
                            <h6 class="text-center">For better experience, you can choose your skills:</h6>

                            @if($skillsInRaw)
                                <h6 class="text-center text-muted">Your current skills set:</h6>
                                <span class="text-decoration-underline fw-bold">{{ $skillsInRaw }}</span>
                            @endif

                            <div class="d-flex justify-content-center mt-3">
                                <button type="button" id="view-skills" class="btn btn-outline-primary">Add skills
                                </button>
                                <button type="button" id="hide-skills" class="btn btn-outline-danger d-none">Hide
                                    skills
                                </button>
                            </div>
                            <p class="text-center h6 text-danger fw-bold" id="error-message-skills"></p>
                        </div>

                        <div class="container pt-2 font-12" id="skills-container"
                             data-employee-skills="@json($employee->skills)">
                        </div>
                    </div>

                    <x-input.block form="outline" class="mb-3 col-12 text-center">
                        <h6 id="about_employee-text" class="mb-3 text-muted">Experience
                            <span id="add-more"
                                  class="text-decoration-underline editable-input hover-primary">Add more</span>
                        </h6>
                        <div class="d-flex flex-column gap-3" id="experience-container">
                            <x-employee.experience-item
                                    :data="old('experiences') ?? $employee->experiences"></x-employee.experience-item>
                        </div>
                    </x-input.block>

                    <div class="d-flex justify-content-end mb-5">
                        <x-button.default type="submit">Save changes</x-button.default>
                    </div>

                </form>
            </div>
            @if($vacancies)
                <div class="container my-5 w-85">
                    <h2 class="text-center fw-bold text-decoration-underline mb-3">Vacancies related to your skill
                        set:</h2>
                    <div class="row">
                        @foreach($vacancies as $vacancy)
                            <x-card.jobcard :class="'w-50'" :vacancy="$vacancy"></x-card.jobcard>
                        @endforeach
                        <a href="{{ route('vacancies.all', ['skills' => implode(',', $employee->skills)]) }}"
                           class="btn btn-outline-danger float-center">Show more</a>
                    </div>
                </div>
            @endif

        </div>
    </x-main>
    <x-footer></x-footer>

    <script src="/assets/js/employee/employeePersonalInfo.js" nonce="{{ csp_nonce() }}"></script>

    <script src="/assets/js/addNewField.js" nonce="{{ csp_nonce() }}"></script>

    <script src="/assets/js/viewSkills.js" nonce="{{ csp_nonce() }}"></script>

</x-layout>