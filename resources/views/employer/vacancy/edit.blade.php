<x-layout class="d-flex flex-column min-vh-100">
    <x-slot:title>{{ session('user.name') }}</x-slot:title>

    <x-header></x-header>

    <x-main>
        <div class="container mt-3 mb-3">
            <h5 class="text-center fw-light">Create new vacancy for</h5>
            <h1 class="text-center fw-bold text-danger red">{{ session('user.name') }}</h1>
            <h5 class="text-center fw-light">company</h5>
            <div class="w-75 mx-auto">
                <form action="{{ route('employer.vacancy.store') }}" method="POST">
                    @csrf
                    <x-input.block id="createVacancyInput">
                        <div class="my-5">
                            <h6 class="fw-bold text-decoration-underline">Choose skills that will be required for
                                vacancy</h6>
                            <p>Your current skills in
                                vacancy: {{ implode(', ', $existingSkills->names }}</p>
                            <x-categories.list name="skillset" :skillSet="$skills"
                                               :existingSkills="$existingSkills"></x-categories.list>
                            @error('skillset')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">Job title (ex. Middle Laravel Developer)</h6>
                            <x-input.index type="text"
                                           id="jobTitle" name="title" value="{{ old('title') ?? $vacancy->title }}"
                                           required></x-input.index>
                            @error('title')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">Location (ex. USA, New Your or Work on
                                distance)</h6>
                            <x-input.index type="text"
                                           id="location" name="location"
                                           value="{{ old('location') ?? $vacancy->location }}"
                                           required></x-input.index>
                            @error('location')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">Salary in USD. (Optional. If you leave it
                                empty or 0, salary
                                field will automatically set as 'Negotiated salary')</h6>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <x-input.index type="number" name="salary" id="salary"
                                               value="{{ old('salary') ?? $vacancy->salary }}"
                                               min="0"></x-input.index>
                            </div>
                            @error('salary')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <h6 class="fw-bold text-decoration-underline">About job</h6>
                            <x-input.textarea rows="5" name="description"
                                              required>{{ old('description') ?? $vacancy->description }}</x-input.textarea>
                            @error('description')
                            <p class="text-danger text-center font-monospace fw-bold mt-2 h6">{{ $message }}</p>
                            @enderror
                        </div>
                        {{--<div class="mb-5">
                            <x-input.field-add id="createResponsibilityInput" name="responsibilities"
                                               required value="{{ old('responsibilities')[0] ?? '' }}"
                                               label="Responsibilities (ex. Write clean, efficient and testable code)"></x-input.field-add>
                            <x-input.nested-field-error name="responsibilities"></x-input.nested-field-error>
                        </div>
                        <div class="mb-5">
                            <x-input.field-add id="createRequirementsInput" name="requirements" required label="Requirements (ex. Well-knowing
                                PHP,
                                basic of docker etc.)" value="{{ old('requirements')[0] ?? '' }}"></x-input.field-add>
                            <x-input.nested-field-error name="requirements"></x-input.nested-field-error>
                        </div>
                        <div class="mb-5">
                            <x-input.field-add id="createOffersInput" name="offers" value="{{ old('offers')[0] ?? '' }}"
                                               label="Job offers(ex. Medical insurance...) (Optional. You may leave it as empty field)"></x-input.field-add>
                            <x-input.nested-field-error name="offers"></x-input.nested-field-error>
                        </div>--}}
                    </x-input.block>
                    <x-button.default class="float-end mb-5" type="submit">Create vacancy</x-button.default>
                </form>
            </div>
        </div>
    </x-main>

    <x-footer></x-footer>

    <script src="/assets/js/addNewField.js"></script>
</x-layout>
